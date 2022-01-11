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
use App\Tipo_Transporte;
use App\Importacion_Detalle;
use App\Importacion_Maestro;
use App\Movimiento_Bodega;
use App\Orden_Compra_Maestro;
use App\Events\ActualizacionBitacora;
use Validator;

class ImportacionesController extends Controller
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
        return view('admin.importaciones.index');
    }


    public function getJson(Request $params)
    {
       $api_Result['data'] = Importacion_Maestro::select(
           'importaciones_maestro.id',
           'importaciones_maestro.no_hoja',
           'importaciones_maestro.no_pedido',
           'proveedores.nombre_comercial as proveedor',
           'importaciones_maestro.fecha',
           'importaciones_maestro.poliza',
           'importaciones_maestro.no_factura',
           'importaciones_maestro.estado_id',
           'estados.descripcion as estado',
           'importaciones_maestro.total'
        )->join(
            'estados',
            'importaciones_maestro.estado_id',
            '=',
            'estados.id'
        )->join(
            'proveedores',
            'importaciones_maestro.proveedor_id',
            '=',
            'proveedores.id'
        )->where(
           'importaciones_maestro.estado_id',
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
        $proveedores = Proveedor::WHERE("estado_id","=", 1)->get();
        $tipo_transporte = Tipo_Transporte::all();
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 0)->get();
        
        return view('admin.importaciones.create', compact('proveedores', 'articulos', 'tipo_transporte','series'));
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

        $no_hoja            = $arr[1]["value"];
        $no_pedido          = $arr[2]["value"];
        $orden_compra_id    = $arr[3]["value"];
        $fecha              = date_format(date_create($arr[4]["value"]), "Y/m/d");
        $proveedor_id       = $arr[5]["value"];
        $poliza             = $arr[6]["value"];
        $no_factura         = $arr[7]["value"];
        $tipo_mercaderia    = $arr[8]["value"];
        $tipo_transporte_id = $arr[9]["value"];
        $valor_fob          = $arr[10]["value"];
        $costo_transporte   = $arr[11]["value"];     
        $consular_fees      = $arr[12]["value"];
        $bl_pc              = $arr[13]["value"];
        $insurance          = $arr[14]["value"];
        $others             = $arr[15]["value"];
        $handling_and_po    = $arr[16]["value"];
        $total_cif          = $arr[17]["value"];
        $tasa_cambio        = $arr[18]["value"];
        $quetzalizacion     = $arr[19]["value"];
        $d_arancelarios_imp = $arr[20]["value"];
        $multas             = $arr[21]["value"];
        $almacenaje_algesa  = $arr[22]["value"];
        $marchamo           = $arr[23]["value"];
        $muellaje           = $arr[24]["value"];
        $fumigacion         = $arr[25]["value"];
        $m_documentacion    = $arr[26]["value"];
        $tram_al            = $arr[27]["value"];
        $hono_aa            = $arr[28]["value"];
        $formulario         = $arr[29]["value"];
        $fl_i_c_v           = $arr[30]["value"];
        $fl_i_a_v           = $arr[31]["value"];
        $fl_ch_bv           = $arr[32]["value"];
        $d_monta            = $arr[33]["value"];
        $viaticos           = $arr[34]["value"];
        $otros              = $arr[35]["value"];
        $costo_pbod         = $arr[36]["value"];
        $fac_costeo         = $arr[37]["value"];
        $total              = $arr[42]["value"];
        $empresa_id         = $user_perfil[0]->empresa_id;
        $estado_id          = 1;
        $user_id            = Auth::user()->id;

        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 0)->get();
        $series[0]->correlativo = $no_hoja + 1;
        $series[0]->save();

        $im = Importacion_Maestro::create([
            'no_hoja'               => $no_hoja,
            'no_pedido'             => $no_pedido,
            'orden_compra_id'       => $orden_compra_id,
            'fecha'                 => $fecha,
            'proveedor_id'          => $proveedor_id,
            'poliza'                => $poliza,
            'no_factura'            => $no_factura,
            'tipo_mercaderia'       => $tipo_mercaderia,
            'tipo_transporte_id'    => $tipo_transporte_id,
            'valor_fob'             => $valor_fob,
            'tasa_cambio'           => $tasa_cambio,
            'costo_transporte'      => $costo_transporte,
            'total_cif'             => $total_cif,
            'consular_fees'         => $consular_fees,
            'insurance'             => $insurance,
            'handling_and_po'       => $handling_and_po,
            'quetzalizacion'        => $quetzalizacion,
            'bl_pc'                 => $bl_pc,
            'others'                => $others,
            'd_arancelarios_imp'    => $d_arancelarios_imp,
            'almacenaje_algesa'     => $almacenaje_algesa,
            'muellaje'              => $muellaje,
            'tram_al'               => $tram_al,
            'fl_i_a_v'              => $fl_i_a_v,
            'd_monta'               => $d_monta,
            'multas'                => $multas,
            'marchamo'              => $marchamo,
            'm_documentacion'       => $m_documentacion,
            'formulario'            => $formulario,
            'fl_i_c_v'              => $fl_i_c_v,
            'otros'                 => $otros,
            'fumigacion'            => $fumigacion,
            'hono_aa'               => $hono_aa,
            'fl_ch_bv'              => $fl_ch_bv,
            'viaticos'              => $viaticos,
            'costo_pbod'            => $costo_pbod,
            'fac_costeo'            => $fac_costeo,
            'total'                 => $total,
            'empresa_id'            => $empresa_id,
            'estado_id'             => $estado_id,
            'user_id'               => $user_id,
            ]);


        for ($i=43; $i < sizeof($arr) ; $i++) {
            $id = Importacion_Detalle::create([
                'importacion_maestro_id'    => $im->id,
                'articulo_id'               => $arr[$i]["articulo_id"],
                'cantidad'                  => $arr[$i]["cantidad"],
                'fob'                       => $arr[$i]["fob"],
                'subtotal'                  => $arr[$i]["subtotal"],
            ]);

            $mb = Movimiento_Bodega::create([
                'producto_id'       =>  $arr[$i]["articulo_id"],
                'bodega_id'         =>  1,
                'tipo_movimiento'   =>  "Importación",
                'cantidad'          =>  $arr[$i]["cantidad"],
            ]);
            
            $arti = Articulo::where("id","=",$arr[$i]["articulo_id"])->get()->first();
            $arti->costo_promedio_quetzales = (($arti->costo_promedio_quetzales * $arti->existencia) + $arr[$i]["subtotal"]) / ($arti->existencia + $arr[$i]["cantidad"]);
            $arti->costo_dolares = ((($arr[$i]["subtotal"] * $total_cif)/$valor_fob) + ($arr[$i]["subtotal"]))/$arr[$i]["cantidad"];
            $arti->existencia = $arti->existencia + $arr[$i]["cantidad"];
            $mvfactor = ($costo_pbod+($valor_fob*$tasa_cambio))/$valor_fob;
            $arti->costo_quetzales = $arr[$i]["fob"] * $mvfactor;
            $arti->ultimo_costo = $arti->costo_quetzales;
            $arti->precio_quetzales = ($arti->costo_quetzales/0.5225) * 1.12;
            $arti->precio_dolares = $arti->precio_quetzales / $tasa_cambio;
            $arti->ultimo_precio = $arti->precio_quetzales;
            $arti->proveedor_id = $proveedor_id;
            $arti->fecha_ultima_compra = $fecha;
            $arti->save();
        }

        //writes the new purchase to log
        event(new ActualizacionBitacora($im->id, Auth::user()->id, 'Creación', '', $im, 'importaciones maestro'));

        return Response::json(['success' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Importacion_Maestro $importacion_maestro)
    {
        $imp_maestro = Importacion_Maestro::select(
            'importaciones_maestro.*',
            'proveedores.nit',
            'proveedores.nombre_comercial as proveedor',
            'tipo_transporte.tipo_transporte',
            'users.name'
        )->join(
            'tipo_transporte',
            'importaciones_maestro.tipo_transporte_id',
            '=',
            'tipo_transporte.id'
        )->join(
            'users',
            'importaciones_maestro.user_id',
            '=',
            'users.id'
        )->join(
            'proveedores',
            'importaciones_maestro.proveedor_id',
            '=',
            'proveedores.id'
        )->where(
            'importaciones_maestro.estado_id',
            '=',
            '1'
        )->where(
            'importaciones_maestro.id',
            '=',
            $importacion_maestro->id
        )->get();


        $imp_detalle = Importacion_Detalle::select(
            'importaciones_detalle.id',
            'importaciones_detalle.cantidad',
            'importaciones_detalle.fob',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'importaciones_detalle.subtotal'
        )->join(
            'articulos',
            'importaciones_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'importaciones_detalle.importacion_maestro_id',
            '=',
            $importacion_maestro->id
        )->get();      


        return view('admin.importaciones.show', compact('imp_maestro', 'imp_detalle'));

    }


    public function pdfImportacion(Importacion_Maestro $importacion_maestro)
    {

        $imp_maestro = Importacion_Maestro::select(
            'importaciones_maestro.*',
            'proveedores.nit',
            'proveedores.nombre_comercial as proveedor',
            'tipo_transporte.tipo_transporte',
            'users.name'
        )->join(
            'tipo_transporte',
            'importaciones_maestro.tipo_transporte_id',
            '=',
            'tipo_transporte.id'
        )->join(
            'users',
            'importaciones_maestro.user_id',
            '=',
            'users.id'
        )->join(
            'proveedores',
            'importaciones_maestro.proveedor_id',
            '=',
            'proveedores.id'
        )->where(
            'importaciones_maestro.estado_id',
            '=',
            '1'
        )->where(
            'importaciones_maestro.id',
            '=',
            $importacion_maestro->id
        )->get();

        

        $imp_detalle = Importacion_Detalle::select(
            'importaciones_detalle.id',
            'importaciones_detalle.cantidad',
            'importaciones_detalle.fob',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'importaciones_detalle.subtotal'
        )->join(
            'articulos',
            'importaciones_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'importaciones_detalle.importacion_maestro_id',
            '=',
            $importacion_maestro->id
        )->get(); 


        $pdf = \PDF::loadView('admin.importaciones.pdfimportaciones', compact('imp_maestro', 'imp_detalle'));
        return $pdf->stream('importacion.pdf');
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
    public function destroy(Importacion_Maestro $importacion_maestro, Request $request)
    {
        $importacion_maestro->estado_id = 3;
        $importacion_maestro->save();

        event(new ActualizacionBitacora($importacion_maestro->id, Auth::user()->id, 'Eliminación', '', '', 'Importación Maestro'));

        return Response::json(['success' => 'Éxito']);
    }
}
