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
use App\Articulo;
use App\Proveedor;
use App\Serie;
use App\Tipo_Documento_Importacion;
use App\Tipo_Pago;
use App\Orden_Compra_Detalle;
use App\Orden_Compra_Maestro;
use App\Events\ActualizacionBitacora;
use Barryvdh\DomPDF\Facade as PDF;
use Validator;

class OrdenesComprasController extends Controller
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
        return view('admin.ordenes_compras.index');
    }


    public function getJson(Request $params)
    {
       $api_Result['data'] = Orden_Compra_Maestro::select(
           'orden_compra_maestro.id',
           'orden_compra_maestro.serie_id',
           'series.serie',
           'orden_compra_maestro.correlativo_documento',
           'orden_compra_maestro.fecha_documento',
           'tipo_documento_importacion.tipo_documento_importacion',
           'proveedores.nombre_comercial as proveedor',
           'orden_compra_maestro.estado_id',
           'estados.descripcion as estado',
           'orden_compra_maestro.total',
           'us1.name as crea',
           'us2.name as autoriza',
           'orden_compra_maestro.created_at'
        )->join(
            'estados',
            'orden_compra_maestro.estado_id',
            '=',
            'estados.id'
        )->join(
           'tipo_documento_importacion',
           'orden_compra_maestro.tipo_documento_importacion_id',
           '=',
           'tipo_documento_importacion.id'
        )->join(
            'series',
            'orden_compra_maestro.serie_id',
            '=',
            'series.id'
         )->join(
            'proveedores',
            'orden_compra_maestro.proveedor_id',
            '=',
            'proveedores.id'
        )->join(
            'users as us1',
            'orden_compra_maestro.user_id',
            '=',
            'us1.id'
        )->join(
            'users as us2',
            'orden_compra_maestro.autoriza_id',
            '=',
            'us2.id'
        )->where(
           'orden_compra_maestro.estado_id',
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
        $tipo_documento_importacion = Tipo_Documento_Importacion::all();
        $proveedores = Proveedor::WHERE("estado_id","=", 1)->get();
        $autoriza = User::WHERE("estado","=", 1)->WHERE("id",">", 1)->get();
        $crea = Auth::user()->name;
        $tipo_pago = Tipo_Pago::all();
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 2)->get();
        
        return view('admin.ordenes_compras.create', compact('tipo_documento_importacion', 'proveedores', 'articulos', 'crea', 'autoriza', 'tipo_pago', 'series'));
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

        $serie_id                       = $arr[1]["value"];
        $correlativo_documento          = $arr[2]["value"];
        $fecha_documento                = date_format(date_create($arr[3]["value"]), "Y/m/d");
        $tipo_documento_importacion_id  = $arr[4]["value"];
        $proveedor_id                   = $arr[5]["value"];
        $atencion_a                     = $arr[6]["value"];
        $solicito                       = $arr[7]["value"];
        $lugar_entrega                  = $arr[8]["value"];
        $tipo_pago_id                   = $arr[9]["value"];
        $fecha_entrega                  = date_format(date_create($arr[10]["value"]), "Y/m/d");     
        $autoriza_id                    = $arr[11]["value"];     
        $observaciones                  = $arr[12]["value"];
        $total                          = $arr[17]["value"];
        $empresa_id                     = $user_perfil[0]->empresa_id;
        $estado_id                      = 1;
        $user_id                        = Auth::user()->id;

        $series = Serie::WHERE("estado_id","=", 1)->WHERE("id","=", $serie_id)->get();
        $series[0]->correlativo = $correlativo_documento + 1;
        $series[0]->save();

        $oc = Orden_Compra_Maestro::create([
            'serie_id'                      => $serie_id,
            'correlativo_documento'         => $correlativo_documento,
            'fecha_documento'               => $fecha_documento,
            'tipo_documento_importacion_id' => $tipo_documento_importacion_id,
            'proveedor_id'                  => $proveedor_id,
            'atencion_a'                    => $atencion_a,
            'tipo_pago_id'                  => $tipo_pago_id,
            'solicito'                      => $solicito,
            'lugar_entrega'                 => $lugar_entrega,
            'fecha_entrega'                 => $fecha_entrega,
            'observaciones'                 => $observaciones,
            'autoriza_id'                   => $autoriza_id,
            'total'                         => $total,
            'empresa_id'                    => $empresa_id,
            'estado_id'                     => $estado_id,
            'user_id'                       => $user_id,
            ]);

        for ($i=18; $i < sizeof($arr) ; $i++) {
            $od = Orden_Compra_Detalle::create([
                'orden_compra_maestro_id'   => $oc->id,
                'articulo_id'               => $arr[$i]["articulo_id"],
                'desc_articulo'             => $arr[$i]["articulo"],
                'cantidad'                  => $arr[$i]["cantidad"],
                'precio_unitario'           => $arr[$i]["precio_unitario"],
                'subtotal'                  => $arr[$i]["subtotal"],
            ]);

            
        }

        //writes the new purchase to log
        event(new ActualizacionBitacora($oc->id, Auth::user()->id, 'Creación', '', $oc, 'orden compra maestro'));

        return Response::json(['success' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Orden_Compra_Maestro $orden_compra_maestro)
    {
        $ordencompra_maestro = Orden_Compra_Maestro::select(
            'orden_compra_maestro.id',
            'orden_compra_maestro.serie_id',
            's.serie',
            'orden_compra_maestro.correlativo_documento',
            'orden_compra_maestro.fecha_documento',
            'tipo_documento_importacion.tipo_documento_importacion',
            'pr.nombre_comercial as proveedor',
            'pr.nombre_comercial as nit_proveedor',
            'pr.dias_credito as dias_credito',
            'pr.direccion_comercial as direccion_proveedor',
            'orden_compra_maestro.atencion_a',
            'orden_compra_maestro.solicito',
            'orden_compra_maestro.lugar_entrega',
            'orden_compra_maestro.tipo_pago_id',
            'tp.tipo_pago',
            'orden_compra_maestro.fecha_entrega',
            'orden_compra_maestro.observaciones',
            'orden_compra_maestro.total',
            'us2.name as autoriza',
            'us1.name as crea'
        )->join(
            'tipo_documento_importacion',
            'orden_compra_maestro.tipo_documento_importacion_id',
            '=',
            'tipo_documento_importacion.id'
        )->join(
            'proveedores as pr',
            'orden_compra_maestro.proveedor_id',
            '=',
            'pr.id'
        )->join(
            'series as s',
            'orden_compra_maestro.serie_id',
            '=',
            's.id'
        )->join(
            'tipo_pago as tp',
            'orden_compra_maestro.tipo_pago_id',
            '=',
            'tp.id'
        )->join(
            'users as us1',
            'orden_compra_maestro.user_id',
            '=',
            'us1.id'
        )->join(
            'users as us2',
            'orden_compra_maestro.autoriza_id',
            '=',
            'us2.id'
        )->where(
            'orden_compra_maestro.estado_id',
            '=',
            '1'
        )->where(
            'orden_compra_maestro.id',
            '=',
            $orden_compra_maestro->id
        )->get();



        $ordencompra_detalle = Orden_Compra_Detalle::select(
            'orden_compra_detalle.id',
            'orden_compra_detalle.cantidad',
            'orden_compra_detalle.precio_unitario',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'orden_compra_detalle.desc_articulo',
            'orden_compra_detalle.subtotal'
        )->join(
            'articulos',
            'orden_compra_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'orden_compra_detalle.orden_compra_maestro_id',
            '=',
            $orden_compra_maestro->id
        )->get();



        return view('admin.ordenes_compras.show', compact('ordencompra_maestro', 'ordencompra_detalle'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Orden_Compra_Maestro $orden_compra_maestro)
    {
        $tipo_documento_importacion = Tipo_Documento_Importacion::all();
        $proveedores = Proveedor::WHERE("estado_id","=", 1)->WHERE("id","=", $orden_compra_maestro->proveedor_id)->get();
        $autoriza = User::WHERE("estado","=", 1)->WHERE("id",">", 1)->get();
        $crea = Auth::user()->name;
        $tipo_pago = Tipo_Pago::all();
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 2)->get();
        $oc_detalle = Orden_Compra_Detalle::WHERE("orden_compra_maestro_id","=", $orden_compra_maestro->id)->get();
        
        return view('admin.ordenes_compras.edit', compact('tipo_documento_importacion', 'proveedores','autoriza', 'crea', 'tipo_pago', 'articulos', 'series', 'oc_detalle', 'orden_compra_maestro'));
    }



    public function update(Request $request, Orden_Compra_Maestro $orden_compra_maestro)
    {
        $arr = json_decode($request->getContent(), true); 

        $serie_id                       = $arr[1]["value"];
        $maestro_id                     = $arr[2]["value"];
        $fecha_documento                = date_format(date_create($arr[4]["value"]), "Y/m/d");
        $tipo_documento_importacion_id  = $arr[5]["value"];
        $proveedor_id                   = $arr[6]["value"];
        $atencion_a                     = $arr[7]["value"];
        $solicito                       = $arr[8]["value"];
        $lugar_entrega                  = $arr[9]["value"];
        $tipo_pago_id                   = $arr[10]["value"];
        $fecha_entrega                  = date_format(date_create($arr[11]["value"]), "Y/m/d");
        $autoriza_id                    = $arr[12]["value"];
        $observaciones                  = $arr[13]["value"];
        $total                          = $arr[18]["value"];

        $oc_maestro = Orden_Compra_Maestro::Where("id",$maestro_id)->get();
        $oc_maestro[0]->serie_id = $serie_id;
        $oc_maestro[0]->fecha_documento = $fecha_documento;
        $oc_maestro[0]->tipo_documento_importacion_id = $tipo_documento_importacion_id;
        $oc_maestro[0]->proveedor_id = $proveedor_id;
        $oc_maestro[0]->atencion_a = $atencion_a;
        $oc_maestro[0]->tipo_pago_id = $tipo_pago_id;
        $oc_maestro[0]->solicito = $solicito;
        $oc_maestro[0]->lugar_entrega = $lugar_entrega;
        $oc_maestro[0]->fecha_entrega = $fecha_entrega;
        $oc_maestro[0]->observaciones = $observaciones;
        $oc_maestro[0]->autoriza_id = $autoriza_id;
        $oc_maestro[0]->total = $total;
        $oc_maestro[0]->save();


        if ( sizeof($arr) >= 19 ){

            for ($i=19; $i < sizeof($arr) ; $i++) {
                $cd = Orden_Compra_Detalle::create([
                    'orden_compra_maestro_id'   => $maestro_id,
                    'articulo_id'               => $arr[$i]["articulo_id"],
                    'desc_articulo'             => $arr[$i]["articulo"],
                    'cantidad'                  => $arr[$i]["cantidad"],
                    'precio_unitario'           => $arr[$i]["precio_unitario"],
                    'subtotal'                  => $arr[$i]["subtotal"],
                ]);
            }

        }
 
        event(new ActualizacionBitacora($orden_compra_maestro->id, Auth::user()->id,'Edición de Orden de Compra',$orden_compra_maestro,'','orden_compra_maestro'));
      
        return Response::json(['success' => 'Éxito']);
    }



    public function editdetalle(Orden_Compra_Detalle $orden_compra_detalle)
    {
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        
        return view('admin.ordenes_compras.editdetalle', compact('articulos', 'orden_compra_detalle'));
    }


    public function updatedetalle(Request $request, Orden_Compra_Detalle $orden_compra_detalle)
    {
        
        event(new ActualizacionBitacora($orden_compra_detalle->id, Auth::user()->id,'Edición del detalle de la orden de compra',$orden_compra_detalle,'','orden_compra_detalle'));


        $orden_compra_detalle->subtotal = $request->cantidad * $request->precio_unitario;
        $orden_compra_detalle->update($request->all());

        $total = Orden_Compra_Detalle::select(
            DB::raw('SUM(subtotal) as total')
        )->Where(
            "orden_compra_maestro_id",
            "=",
            $orden_compra_detalle->orden_compra_maestro_id
        )->get();

        $orden_compra_maestro = Orden_Compra_Maestro::Where("id","=",$orden_compra_detalle->orden_compra_maestro_id)->get();
        $orden_compra_maestro[0]->total = $total[0]->total;
        $orden_compra_maestro[0]->save();

      
        return redirect()->route('ordenes_compras.edit', $orden_compra_detalle->orden_compra_maestro_id)->with('flash','La Orden de Compra Detalle ha sido actualizada!');
    }


    public function getdetalle($id)
    {
        $api_result = Orden_Compra_Detalle::Select(
            'orden_compra_detalle.id',
            'orden_compra_detalle.articulo_id',
            'orden_compra_detalle.cantidad',
            'orden_compra_detalle.desc_articulo',
            'orden_compra_detalle.precio_unitario',
            'orden_compra_detalle.subtotal'
        )->Where(
            'orden_compra_detalle.orden_compra_maestro_id',
            '=',
            $id
        )->get();  

        return Response::json($api_result);
    }


    public function pdfOrdenCompra(Orden_Compra_Maestro $orden_compra_maestro)
    {
        $ordencompra_maestro = Orden_Compra_Maestro::select(
            'orden_compra_maestro.id',
            'orden_compra_maestro.serie_id',
            's.serie',
            'orden_compra_maestro.correlativo_documento',
            'orden_compra_maestro.fecha_documento',
            'tipo_documento_importacion.tipo_documento_importacion',
            'pr.nombre_comercial as proveedor',
            'pr.nombre_comercial as nit_proveedor',
            'pr.dias_credito as dias_credito',
            'pr.direccion_comercial as direccion_proveedor',
            'orden_compra_maestro.atencion_a',
            'orden_compra_maestro.solicito',
            'orden_compra_maestro.lugar_entrega',
            'orden_compra_maestro.tipo_pago_id',
            'tp.tipo_pago',
            'orden_compra_maestro.fecha_entrega',
            'orden_compra_maestro.observaciones',
            'orden_compra_maestro.total',
            'us2.name as autoriza',
            'us1.name as crea'
        )->join(
            'tipo_documento_importacion',
            'orden_compra_maestro.tipo_documento_importacion_id',
            '=',
            'tipo_documento_importacion.id'
        )->join(
            'proveedores as pr',
            'orden_compra_maestro.proveedor_id',
            '=',
            'pr.id'
        )->join(
            'series as s',
            'orden_compra_maestro.serie_id',
            '=',
            's.id'
        )->join(
            'tipo_pago as tp',
            'orden_compra_maestro.tipo_pago_id',
            '=',
            'tp.id'
        )->join(
            'users as us1',
            'orden_compra_maestro.user_id',
            '=',
            'us1.id'
        )->join(
            'users as us2',
            'orden_compra_maestro.autoriza_id',
            '=',
            'us2.id'
        )->where(
            'orden_compra_maestro.estado_id',
            '=',
            '1'
        )->where(
            'orden_compra_maestro.id',
            '=',
            $orden_compra_maestro->id
        )->get();

        $ordencompra_detalle = Orden_Compra_Detalle::select(
            'orden_compra_detalle.id',
            'orden_compra_detalle.cantidad',
            'orden_compra_detalle.precio_unitario',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'orden_compra_detalle.desc_articulo',
            'orden_compra_detalle.subtotal'
        )->join(
            'articulos',
            'orden_compra_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'orden_compra_detalle.orden_compra_maestro_id',
            '=',
            $orden_compra_maestro->id
        )->get();


        $pdf = \PDF::loadView('admin.ordenes_compras.pdfordencompra', compact('ordencompra_maestro', 'ordencompra_detalle'));
        return $pdf->stream('orden_compra.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orden_Compra_Maestro $orden_compra_maestro, Request $request)
    {
        $orden_compra_maestro->estado_id = 3;
        $orden_compra_maestro->save();

        event(new ActualizacionBitacora($orden_compra_maestro->id, Auth::user()->id, 'Eliminación', '', '', 'Orden Compra'));

        return Response::json(['success' => 'Éxito']);
    }

    public function destroydetalle(Orden_Compra_Detalle $orden_compra_detalle, Request $request)
    {
        $orden_compra_detalle->delete();

        $total = Orden_Compra_Detalle::select(
            DB::raw('SUM(subtotal) as total')
        )->Where(
            "orden_compra_maestro_id",
            "=",
            $orden_compra_detalle->orden_compra_maestro_id
        )->get();



        $orden_compra_maestro = Orden_Compra_Maestro::Where("id","=",$orden_compra_detalle->orden_compra_maestro_id)->get();
        $orden_compra_maestro[0]->total = $total[0]->total;
        $orden_compra_maestro[0]->save();

        event(new ActualizacionBitacora($orden_compra_detalle->id, Auth::user()->id, 'Eliminación', '', '', 'Orden Compra Detalle'));

        return redirect()->route('ordenes_compras.edit', $orden_compra_detalle->orden_compra_maestro_id)->with('flash','La Orden Compra Detalle ha sido eliminada!');
    }


    public function getProveedor($id){
        
        $api_result = Proveedor::Where("id","=",$id)->Where("estado_id","=",1)->get();  
        return Response::json($api_result);
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
