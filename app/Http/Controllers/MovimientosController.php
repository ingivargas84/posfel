<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\User_Perfil;
use App\Empresa;
use App\Bodega;
use App\Cliente;
use App\Proveedor;
use App\Serie;
use App\Articulo;
use App\Tipo_Documento;
use App\Movimiento_Detalle;
use App\Movimiento_Maestro;
use App\Movimiento_Bodega;
use App\Events\ActualizacionBitacora;
use Validator;

class MovimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('admin.movimientos.index');
    }


    public function getJson(Request $params)
    {
       $api_Result['data'] = Movimiento_Maestro::select(
           'movimientos_maestro.id',
           'movimientos_maestro.serie_id',
           'series.serie',
           'movimientos_maestro.correlativo_documento',
           'movimientos_maestro.fecha_documento',
           'tipo_documento.tipo_documento',
           'bodegas.descripcion as bodega_origen',
           'movimientos_maestro.estado_id',
           'estados.descripcion as estado',
           'movimientos_maestro.total',
           'movimientos_maestro.created_at'
        )->join(
           'estados',
           'movimientos_maestro.estado_id',
           '=',
           'estados.id'
        )->join(
            'series',
            'movimientos_maestro.serie_id',
            '=',
            'series.id'
         )->join(
           'tipo_documento',
           'movimientos_maestro.tipo_documento_id',
           '=',
           'tipo_documento.id'
        )->join(
            'bodegas',
            'movimientos_maestro.bodega_origen_id',
            '=',
            'bodegas.id'
        )->where(
           'movimientos_maestro.estado_id',
           '=',
           '1'
        )->get(); 

       return Response::json( $api_Result );
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipo_documento = Tipo_Documento::all();
        $bodegas = Bodega::WHERE("estado_id","=", 1)->get();
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        $clientes = Cliente::WHERE("estado_id","=", 1)->WHERE("id",">", 0)->get();
        $proveedores = Proveedor::WHERE("estado_id","=", 1)->get();
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 1)->get();
        
        return view('admin.movimientos.create', compact('tipo_documento', 'bodegas', 'articulos', 'series', 'clientes', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arr = json_decode($request->getContent(), true);
        
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();

        $serie_id               = $arr[1]["value"];
        $correlativo_documento  = $arr[2]["value"];
        $fecha_documento        = date_format(date_create($arr[3]["value"]), "Y/m/d");
        $tipo_documento_id      = $arr[4]["value"];

        if ($arr[4]["value"] == 1)
        {
            $aplicacion    = "Proveedor";
            $proveedor_id  = $arr[5]["value"];
            $cliente_id    = 1;
            $bodega_origen_id      = $arr[6]["value"];
            $bodega_destino_id      = 1;
            $observaciones          = $arr[7]["value"];
            $total                  = $arr[12]["value"];

            $empresa_id             = $user_perfil[0]->empresa_id;
            $estado_id              = 1;
            $user_id                = Auth::user()->id;
    
            $series = Serie::WHERE("estado_id","=", 1)->WHERE("id","=", $serie_id)->get();
            $series[0]->correlativo = $correlativo_documento + 1;
            $series[0]->save();
    
            $mm = Movimiento_Maestro::create([
                'serie_id'                  => $serie_id,
                'correlativo_documento'     => $correlativo_documento,
                'fecha_documento'           => $fecha_documento,
                'tipo_documento_id'         => $tipo_documento_id,
                'proveedor_id'              => $proveedor_id,
                'cliente_id'                => $cliente_id,
                'bodega_origen_id'          => $bodega_origen_id,
                'bodega_destino_id'         => $bodega_destino_id,
                'aplicacion'                => $aplicacion,
                'observaciones'             => $observaciones,
                'total'                     => $total,
                'empresa_id'                => $empresa_id,
                'estado_id'                 => $estado_id,
                'user_id'                   => $user_id,
                ]);
    
            for ($i=13; $i < sizeof($arr) ; $i++) {
    
                $md = Movimiento_Detalle::create([
                    'movimiento_maestro_id'  => $mm->id,
                    'articulo_id'            => $arr[$i]["articulo_id"],
                    'desc_articulo'          => $arr[$i]["articulo"],
                    'cantidad'               => $arr[$i]["cantidad"],
                    'precio_unitario'        => $arr[$i]["precio_unitario"],
                    'subtotal'               => $arr[$i]["subtotal"],
                ]);

                $mb = Movimiento_Bodega::create([
                    'producto_id'           =>  $arr[$i]["articulo_id"],
                    'bodega_id'             =>  $bodega_destino_id,
                    'tipo_movimiento'       =>  "Movimiento Entrada",
                    'cantidad'              =>  $arr[$i]["cantidad"],
                    'movimiento_detalle_id' =>  $md->id,
                ]);

                $arti = Articulo::where("id","=",$arr[$i]["articulo_id"])->get()->first();
                $arti->costo_promedio_quetzales = (($arti->costo_promedio_quetzales * $arti->existencia) + $arr[$i]["subtotal"]) / ($arti->existencia + $arr[$i]["cantidad"]);
                $arti->existencia = $arti->existencia + $arr[$i]["cantidad"];
                $arti->costo_quetzales = $arr[$i]["precio_unitario"];
                $arti->ultimo_costo = $arr[$i]["precio_unitario"];
                $arti->precio_quetzales = ($arti->costo_quetzales/0.5225) * 1.12;
                $arti->ultimo_precio = $arti->precio_quetzales;
                $arti->proveedor_id = $proveedor_id;
                $arti->fecha_ultima_compra = $fecha_documento;
                $arti->save();

            }
        }
        elseif ($arr[4]["value"] == 2)
        {
            $aplicacion = "Cliente";
            $proveedor_id  = 1;
            $cliente_id = $arr[5]["value"];
            $bodega_origen_id      = $arr[6]["value"];
            $bodega_destino_id      = 1;
            $observaciones          = $arr[7]["value"];
            $total                  = $arr[12]["value"];

            $empresa_id             = $user_perfil[0]->empresa_id;
            $estado_id              = 1;
            $user_id                = Auth::user()->id;
    
            $series = Serie::WHERE("estado_id","=", 1)->WHERE("id","=", $serie_id)->get();
            $series[0]->correlativo = $correlativo_documento + 1;
            $series[0]->save();
    
            $mm = Movimiento_Maestro::create([
                'serie_id'                  => $serie_id,
                'correlativo_documento'     => $correlativo_documento,
                'fecha_documento'           => $fecha_documento,
                'tipo_documento_id'         => $tipo_documento_id,
                'proveedor_id'              => $proveedor_id,
                'cliente_id'                => $cliente_id,
                'bodega_origen_id'          => $bodega_origen_id,
                'bodega_destino_id'         => $bodega_destino_id,
                'aplicacion'                => $aplicacion,
                'observaciones'             => $observaciones,
                'total'                     => $total,
                'empresa_id'                => $empresa_id,
                'estado_id'                 => $estado_id,
                'user_id'                   => $user_id,
                ]);
    
            for ($i=13; $i < sizeof($arr) ; $i++) {
    
                $md = Movimiento_Detalle::create([
                    'movimiento_maestro_id'  => $mm->id,
                    'articulo_id'            => $arr[$i]["articulo_id"],
                    'desc_articulo'          => $arr[$i]["articulo"],
                    'cantidad'               => $arr[$i]["cantidad"],
                    'precio_unitario'        => $arr[$i]["precio_unitario"],
                    'subtotal'               => $arr[$i]["subtotal"],
                ]);

                $mb = Movimiento_Bodega::create([
                    'producto_id'           =>  $arr[$i]["articulo_id"],
                    'bodega_id'             =>  $bodega_destino_id,
                    'tipo_movimiento'       =>  "Movimiento Salida",
                    'cantidad'              =>  $arr[$i]["cantidad"],
                    'movimiento_detalle_id' =>  $md->id,
                ]);

                $arti = Articulo::where("id","=",$arr[$i]["articulo_id"])->get()->first();
                $arti->existencia = $arti->existencia - $arr[$i]["cantidad"];
                $arti->save();
            }
        }
        else
        {
            $aplicacion = "No Aplica";
            $proveedor_id  = 1;
            $cliente_id = 1;
            $bodega_origen_id      = $arr[5]["value"];
            $bodega_destino_id      = $arr[6]["value"];
            $observaciones          = $arr[7]["value"];
            $total                  = $arr[12]["value"];

            $empresa_id             = $user_perfil[0]->empresa_id;
            $estado_id              = 1;
            $user_id                = Auth::user()->id;
    
            $series = Serie::WHERE("estado_id","=", 1)->WHERE("id","=", $serie_id)->get();
            $series[0]->correlativo = $correlativo_documento + 1;
            $series[0]->save();
    
            $mm = Movimiento_Maestro::create([
                'serie_id'                  => $serie_id,
                'correlativo_documento'     => $correlativo_documento,
                'fecha_documento'           => $fecha_documento,
                'tipo_documento_id'         => $tipo_documento_id,
                'proveedor_id'              => $proveedor_id,
                'cliente_id'                => $cliente_id,
                'bodega_origen_id'          => $bodega_origen_id,
                'bodega_destino_id'         => $bodega_destino_id,
                'aplicacion'                => $aplicacion,
                'observaciones'             => $observaciones,
                'total'                     => $total,
                'empresa_id'                => $empresa_id,
                'estado_id'                 => $estado_id,
                'user_id'                   => $user_id,
                ]);
    
            for ($i=13; $i < sizeof($arr) ; $i++) {
    
                $md = Movimiento_Detalle::create([
                    'movimiento_maestro_id'  => $mm->id,
                    'articulo_id'            => $arr[$i]["articulo_id"],
                    'desc_articulo'          => $arr[$i]["articulo"],
                    'cantidad'               => $arr[$i]["cantidad"],
                    'precio_unitario'        => $arr[$i]["precio_unitario"],
                    'subtotal'               => $arr[$i]["subtotal"],
                ]);

                $movBodega = Movimiento_Bodega::WHERE("bodega_id",$bodega_origen_id)->WHERE("cantidad",">",0)->WHERE("producto_id",$arr[$i]["articulo_id"])->orderBy("cantidad","desc")->get();
                $movBodega[0]->cantidad = $movBodega[0]->cantidad - $arr[$i]["cantidad"];
                $movBodega[0]->save();

                $mb = Movimiento_Bodega::create([
                    'producto_id'           =>  $arr[$i]["articulo_id"],
                    'bodega_id'             =>  $bodega_destino_id,
                    'tipo_movimiento'       =>  "Movimiento Traslado",
                    'cantidad'              =>  $arr[$i]["cantidad"],
                    'movimiento_detalle_id' =>  $md->id,
                ]);
            }

        }               
       

        //writes the new purchase to log
        event(new ActualizacionBitacora($mm->id, Auth::user()->id, 'Creación', '', $mm, 'movimientos_maestro'));

        return Response::json(['success' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Movimiento_Maestro $movimientoMaestro)
    {
        $movimiento_maestro = Movimiento_Maestro::select(
            'movimientos_maestro.id',
            'movimientos_maestro.serie_id',
            'series.serie',
            'movimientos_maestro.cliente_id',
            'clientes.nombre_comercial as cliente',
            'movimientos_maestro.proveedor_id',
            'proveedores.nombre_comercial as proveedor',
            'movimientos_maestro.correlativo_documento',
            'movimientos_maestro.fecha_documento',
            'tipo_documento.tipo_documento',
            'bodegas.descripcion as bodega_origen',
            'movimientos_maestro.aplicacion',
            'movimientos_maestro.observaciones',
            'movimientos_maestro.total',
            'users.name'
        )->join(
            'tipo_documento',
            'movimientos_maestro.tipo_documento_id',
            '=',
            'tipo_documento.id'
        )->join(
            'users',
            'movimientos_maestro.user_id',
            '=',
            'users.id'
        )->join(
            'bodegas',
            'movimientos_maestro.bodega_origen_id',
            '=',
            'bodegas.id'
        )->join(
            'series',
            'movimientos_maestro.serie_id',
            '=',
            'series.id'
        )->join(
            'proveedores',
            'movimientos_maestro.proveedor_id',
            '=',
            'proveedores.id'
        )->join(
            'clientes',
            'movimientos_maestro.cliente_id',
            '=',
            'clientes.id'
        )->where(
            'movimientos_maestro.estado_id',
            '=',
            '1'
        )->where(
            'movimientos_maestro.id',
            '=',
            $movimientoMaestro->id
        )->get();


        $movimiento_detalle = Movimiento_Detalle::select(
            'movimientos_detalle.id',
            'movimientos_detalle.cantidad',
            'movimientos_detalle.precio_unitario',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'movimientos_detalle.desc_articulo',
            'movimientos_detalle.subtotal'
        )->join(
            'articulos',
            'movimientos_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'movimientos_detalle.movimiento_maestro_id',
            '=',
            $movimientoMaestro->id
        )->get();

        return view('admin.movimientos.show', compact('movimiento_maestro', 'movimiento_detalle'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movimiento_Maestro $movimientoMaestro, Request $request)
    {
        $movdetalle = Movimiento_Detalle::Where("movimiento_maestro_id",$movimientoMaestro->id)->get();

        if($movimientoMaestro->tipo_documento_id == 1)
        {
            for ($i=0; $i < count($movdetalle); $i++) {

                $movbodega = Movimiento_Bodega::Where("movimiento_detalle_id",$movdetalle[$i]->id)->get();
                $movbodega[0]->cantidad = $movbodega[0]->cantidad - $movdetalle[$i]->cantidad;
                $movbodega[0]->save();

                $arti = Articulo::where("id",$movdetalle[$i]->articulo_id)->get();
                $arti[0]->existencia = $arti[0]->existencia - $movdetalle[$i]->cantidad;
                $arti[0]->save();
            }
        }
        else if($movimientoMaestro->tipo_documento_id == 2)
        {
            for ($i=0; $i < count($movdetalle); $i++) {

                $movbodega = Movimiento_Bodega::Where("movimiento_detalle_id",$movdetalle[$i]->id)->get();
                $movbodega[0]->cantidad = $movbodega[0]->cantidad + $movdetalle[$i]->cantidad;
                $movbodega[0]->save();

                $arti = Articulo::where("id",$movdetalle[$i]->articulo_id)->get();
                $arti[0]->existencia = $arti[0]->existencia + $movdetalle[$i]->cantidad;
                $arti[0]->save();
            }
        }
        else if($movimientoMaestro->tipo_documento_id == 3)
        {
            for ($i=0; $i < count($movdetalle); $i++) {

                $movBodega1 = Movimiento_Bodega::WHERE("bodega_id",$movimientoMaestro->bodega_origen_id)->WHERE("cantidad",">",0)->WHERE("producto_id",$movdetalle[$i]->articulo_id)->orderBy("cantidad","desc")->get();
                $movBodega1[0]->cantidad = $movBodega1[0]->cantidad + $movdetalle[$i]->cantidad;
                $movBodega1[0]->save();

                $movBodega2 = Movimiento_Bodega::WHERE("bodega_id",$movimientoMaestro->bodega_destino_id)->WHERE("cantidad",">",0)->WHERE("producto_id",$movdetalle[$i]->articulo_id)->orderBy("cantidad","desc")->get();
                $movBodega2[0]->cantidad = $movBodega2[0]->cantidad - $movdetalle[$i]->cantidad;
                $movBodega2[0]->save();

            }
        }

        $movimientoMaestro->estado_id = 3;
        $movimientoMaestro->save();

        event(new ActualizacionBitacora($movimientoMaestro->id, Auth::user()->id, 'Eliminación', '', '', 'documentos'));

        return Response::json(['success' => 'Éxito']);
    }


    public function getArticulo($id){
        $api_result = Articulo::Where("id","=",$id)->Where("estado_id","=",1)->get();
          
        return Response::json($api_result);
    }

    public function getSerie($id){
        $api_result = Serie::Where("id","=",$id)->Where("estado_id","=",1)->get();
          
        return Response::json($api_result);
    }
}
