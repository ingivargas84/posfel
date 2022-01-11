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
use App\CotizacionCliente;
use App\Cliente;
use App\Serie;
use App\Tipo_Documento_Importacion;
use App\Tipo_Pago;
use App\Vendedor;
use App\Cotizacion_Detalle;
use App\Cotizacion_Maestro;
use App\Events\ActualizacionBitacora;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade as PDF;
use Validator;

class CotizacionesController extends Controller
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
        return view('admin.cotizaciones.index');
    }


    public function getJson(Request $params)
    {
       $api_Result['data'] = Cotizacion_Maestro::select(
           'cotizacion_maestro.id',
           'cotizacion_maestro.serie_id',
           'series.serie',
           'cotizacion_maestro.correlativo_documento',
           'cotizacion_maestro.fecha_documento',
           'clientes.nombre_comercial as cliente',
           'cotizacion_maestro.estado_id',
           'estados.descripcion as estado',
           'cotizacion_maestro.total',
           'cotizacion_maestro.tipo_pago_id',
           'cotizacion_maestro.descuento_porcentaje',
           'cotizacion_maestro.descuento_valores',
           'tipo_pago.tipo_pago',
           'us1.name as crea',
           'cotizacion_maestro.created_at'
        )->join(
            'estados',
            'cotizacion_maestro.estado_id',
            '=',
            'estados.id'
        )->join(
            'series',
            'cotizacion_maestro.serie_id',
            '=',
            'series.id'
         )->join(
            'clientes',
            'cotizacion_maestro.cliente_id',
            '=',
            'clientes.id'
        )->join(
            'users as us1',
            'cotizacion_maestro.user_id',
            '=',
            'us1.id'
        )->join(
            'tipo_pago',
            'cotizacion_maestro.tipo_pago_id',
            '=',
            'tipo_pago.id'
        )->where(
           'cotizacion_maestro.estado_id',
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
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 4)->get();
        $clientes = Cliente::WHERE("estado_id","=", 1)->get();
        $tipo_pago = Tipo_Pago::all();
        $crea = Auth::user()->name;
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        
        return view('admin.cotizaciones.create', compact('clientes', 'articulos', 'crea', 'tipo_pago', 'series'));
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

        $series = Serie::WHERE("estado_id","=", 1)->WHERE("id","=", $arr[1]["value"])->get();

        if ($arr[14]["name"] == "vendedor")
        {
            $exenta                         = $arr[15]["value"];
            $tiempo_entrega                 = $arr[16]["value"];
            $validez_oferta                 = $arr[17]["value"];
            $transportado_por               = $arr[18]["value"];
            $anotaciones                    = $arr[19]["value"];
            $referencia                     = $arr[20]["value"];
            $observaciones                  = $arr[21]["value"];
            $total                          = $arr[26]["value"];
            $descuento_porcentaje           = ($total * $arr[10]["value"]) / 100;
            $num = 27;
        }
        else
        {
            $exenta                         = $arr[14]["value"];
            $tiempo_entrega                 = $arr[15]["value"]; 
            $validez_oferta                 = $arr[16]["value"];
            $transportado_por               = $arr[17]["value"];
            $anotaciones                    = $arr[18]["value"];
            $referencia                     = $arr[19]["value"];
            $observaciones                  = $arr[20]["value"];
            $total                          = $arr[25]["value"];
            $descuento_porcentaje           = ($total * $arr[10]["value"]) / 100;
            $num = 26;

        }

        $serie_id                       = $arr[1]["value"];
        $correlativo_documento          = $series[0]->correlativo + 1;
        $fecha_documento                = date_format(date_create($arr[2]["value"]), "Y/m/d");
        $tipo_pago_id                   = $arr[3]["value"];
        $cliente_id                     = $arr[4]["value"];
        $nit_cliente                    = $arr[5]["value"];
        $nombre_cliente                 = $arr[7]["value"];
        $direccion_cliente              = $arr[8]["value"];
        $lugar_entrega                  = $arr[9]["value"];
        $porcentaje                     = $arr[10]["value"];
        $descuento_valores              = $arr[11]["value"];
        $atencion_a                     = $arr[12]["value"];

        $empresa_id                     = $user_perfil[0]->empresa_id;
        $estado_id                      = 1;
        $user_id                        = Auth::user()->id;


        $oc = Cotizacion_Maestro::create([
            'serie_id'                      => $serie_id,
            'correlativo_documento'         => $correlativo_documento,
            'fecha_documento'               => $fecha_documento,
            'cliente_id'                    => $cliente_id,
            'anotaciones'                   => $anotaciones,
            'referencia'                    => $referencia,
            'observaciones'                 => $observaciones,
            'tipo_pago_id'                  => $tipo_pago_id,
            'exenta'                        => $exenta,
            'tiempo_entrega'                => $tiempo_entrega,
            'validez_oferta'                => $validez_oferta,
            'transportado_por'              => $transportado_por,
            'lugar_entrega'                 => $lugar_entrega,
            'atencion_a'                    => $atencion_a,
            'porcentaje'                    => $porcentaje,
            'descuento_porcentaje'          => $descuento_porcentaje,
            'descuento_valores'             => $descuento_valores,
            'total'                         => $total,
            'empresa_id'                    => $empresa_id,
            'estado_id'                     => $estado_id,
            'user_id'                       => $user_id,
            ]);


            if ($cliente_id == 0){

                $ecc = CotizacionCliente::create([
                    'nit'           => $nit_cliente,
                    'nombre'        => $nombre_cliente,
                    'direccion'     => $direccion_cliente,
                    'cotizacion_id'    => $oc->id
                ]);
            }

        for ($i=$num; $i < sizeof($arr) ; $i++) {
            $od = Cotizacion_Detalle::create([
                'cotizacion_maestro_id'   => $oc->id,
                'articulo_id'               => $arr[$i]["articulo_id"],
                'desc_articulo'             => $arr[$i]["articulo"],
                'cantidad'                  => $arr[$i]["cantidad"],
                'precio_unitario'           => $arr[$i]["precio_unitario"],
                'subtotal'                  => $arr[$i]["subtotal"],
            ]);

            
        }

        $series[0]->correlativo = $series[0]->correlativo + 1;
        $series[0]->save();

        //writes the new purchase to log
        event(new ActualizacionBitacora($oc->id, Auth::user()->id, 'Creación', '', $oc, 'cotización maestro'));

        return Response::json(['success' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cotizacion_Maestro  $cotizacion_maestro)
    {

        if ($cotizacion_maestro->cliente_id > 0){


        $cotizacionmaestro = Cotizacion_Maestro::select(
            'cotizacion_maestro.id',
            'cotizacion_maestro.serie_id',
            'series.serie',
            'cotizacion_maestro.correlativo_documento',
            'cotizacion_maestro.fecha_documento',
            'clientes.nombre_comercial as cliente',
            'clientes.nit',
            'clientes.direccion_comercial',
            'clientes.nombre_contacto',
            'cotizacion_maestro.lugar_entrega',
            'cotizacion_maestro.atencion_a',
            'clientes.dias_credito',
            'clientes.descuento_autorizado',
            'cotizacion_maestro.estado_id',
            DB::raw('CONCAT(vendedores.nombres," ",vendedores.apellidos) as vendedor'),
            'estados.descripcion as estado',
            'cotizacion_maestro.tiempo_entrega',
            'cotizacion_maestro.validez_oferta',
            'cotizacion_maestro.transportado_por',
            'cotizacion_maestro.anotaciones',
            'cotizacion_maestro.referencia',
            'cotizacion_maestro.observaciones',
            'cotizacion_maestro.total',
            'cotizacion_maestro.tipo_pago_id',
            'cotizacion_maestro.porcentaje',
            'cotizacion_maestro.descuento_porcentaje',
            'cotizacion_maestro.descuento_valores',
            'tipo_pago.tipo_pago',
            'users.name',
            'cotizacion_maestro.created_at'
         )->join(
             'estados',
             'cotizacion_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'series',
             'cotizacion_maestro.serie_id',
             '=',
             'series.id'
          )->join(
             'clientes',
             'cotizacion_maestro.cliente_id',
             '=',
             'clientes.id'
         )->join(
            'users',
            'cotizacion_maestro.user_id',
            '=',
            'users.id'
         )->join(
            'vendedores',
            'clientes.vendedor_id',
            '=',
            'vendedores.id'
         )->join(
             'tipo_pago',
             'cotizacion_maestro.tipo_pago_id',
             '=',
             'tipo_pago.id'
        )->where(
            'cotizacion_maestro.estado_id',
            '=',
            '1'
        )->where(
            'cotizacion_maestro.id',
            '=',
            $cotizacion_maestro->id
        )->get();

    }else{

        $cotizacionmaestro = Cotizacion_Maestro::select(
            'cotizacion_maestro.id',
            'cotizacion_maestro.serie_id',
            'series.serie',
            'cotizacion_maestro.correlativo_documento',
            'cotizacion_maestro.fecha_documento',
            'cotizacion_cliente.nombre as cliente',
            'cotizacion_cliente.nit',
            'cotizacion_cliente.direccion as direccion_comercial',
            'clientes.nombre_contacto',
            'cotizacion_maestro.lugar_entrega',
            'cotizacion_maestro.atencion_a',
            'clientes.dias_credito',
            'clientes.descuento_autorizado',
            'cotizacion_maestro.estado_id',
            DB::raw('CONCAT(vendedores.nombres," ",vendedores.apellidos) as vendedor'),
            'estados.descripcion as estado',
            'cotizacion_maestro.tiempo_entrega',
            'cotizacion_maestro.validez_oferta',
            'cotizacion_maestro.transportado_por',
            'cotizacion_maestro.anotaciones',
            'cotizacion_maestro.referencia',
            'cotizacion_maestro.observaciones',
            'cotizacion_maestro.total',
            'cotizacion_maestro.tipo_pago_id',
            'cotizacion_maestro.porcentaje',
            'cotizacion_maestro.descuento_porcentaje',
            'cotizacion_maestro.descuento_valores',
            'tipo_pago.tipo_pago',
            'users.name',
            'cotizacion_maestro.created_at'
         )->join(
             'estados',
             'cotizacion_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'series',
             'cotizacion_maestro.serie_id',
             '=',
             'series.id'
          )->join(
             'clientes',
             'cotizacion_maestro.cliente_id',
             '=',
             'clientes.id'
        )->join(
             'cotizacion_cliente',
             'cotizacion_maestro.id',
             '=',
             'cotizacion_cliente.cotizacion_id'
         )->join(
            'users',
            'cotizacion_maestro.user_id',
            '=',
            'users.id'
         )->join(
            'vendedores',
            'clientes.vendedor_id',
            '=',
            'vendedores.id'
         )->join(
             'tipo_pago',
             'cotizacion_maestro.tipo_pago_id',
             '=',
             'tipo_pago.id'
        )->where(
            'cotizacion_maestro.estado_id',
            '=',
            '1'
        )->where(
            'cotizacion_maestro.id',
            '=',
            $cotizacion_maestro->id
        )->get();



    }


        $cotizaciondetalle = Cotizacion_Detalle::select(
            'cotizacion_detalle.id',
            'cotizacion_detalle.cantidad',
            'cotizacion_detalle.precio_unitario',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'cotizacion_detalle.desc_articulo',
            'cotizacion_detalle.subtotal'
        )->join(
            'articulos',
            'cotizacion_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'cotizacion_detalle.cotizacion_maestro_id',
            '=',
            $cotizacion_maestro->id
        )->get();


        return view('admin.cotizaciones.show', compact('cotizacionmaestro', 'cotizaciondetalle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function pdfCotizacion(Cotizacion_Maestro $cotizacion_maestro)
    {

        if ($cotizacion_maestro->cliente_id > 0){
        
        $cotizacionmaestro = Cotizacion_Maestro::select(
            'cotizacion_maestro.id',
            'cotizacion_maestro.serie_id',
            'series.serie',
            'cotizacion_maestro.correlativo_documento',
            'cotizacion_maestro.fecha_documento',
            'clientes.nombre_comercial as cliente',
            'clientes.nit',
            'clientes.direccion_comercial',
            'clientes.nombre_contacto',
            'clientes.dias_credito',
            'clientes.descuento_autorizado',
            'cotizacion_maestro.estado_id',
            DB::raw('CONCAT(vendedores.nombres," ",vendedores.apellidos) as vendedor'),
            'vendedores.puesto',
            'estados.descripcion as estado',
            'cotizacion_maestro.tiempo_entrega',
            'cotizacion_maestro.validez_oferta',
            'cotizacion_maestro.transportado_por',
            'cotizacion_maestro.anotaciones',
            'cotizacion_maestro.referencia',
            'cotizacion_maestro.lugar_entrega',
            'cotizacion_maestro.atencion_a',
            'cotizacion_maestro.observaciones',
            'cotizacion_maestro.total',
            'cotizacion_maestro.tipo_pago_id',
            'cotizacion_maestro.porcentaje',
            'cotizacion_maestro.descuento_porcentaje',
            'cotizacion_maestro.descuento_valores',
            'tipo_pago.tipo_pago',
            'us1.name as crea',
            'cotizacion_maestro.created_at'
         )->join(
             'estados',
             'cotizacion_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'series',
             'cotizacion_maestro.serie_id',
             '=',
             'series.id'
          )->join(
             'clientes',
             'cotizacion_maestro.cliente_id',
             '=',
             'clientes.id'
         )->join(
            'users as us1',
            'cotizacion_maestro.user_id',
            '=',
            'us1.id'
         )->join(
            'vendedores',
            'clientes.vendedor_id',
            '=',
            'vendedores.id'
         )->join(
             'tipo_pago',
             'cotizacion_maestro.tipo_pago_id',
             '=',
             'tipo_pago.id'
        )->where(
            'cotizacion_maestro.estado_id',
            '=',
            '1'
        )->where(
            'cotizacion_maestro.id',
            '=',
            $cotizacion_maestro->id
        )->get();

    }else{

        
        $cotizacionmaestro = Cotizacion_Maestro::select(
            'cotizacion_maestro.id',
            'cotizacion_maestro.serie_id',
            'series.serie',
            'cotizacion_maestro.correlativo_documento',
            'cotizacion_maestro.fecha_documento',
            'cotizacion_cliente.nombre as cliente',
            'cotizacion_cliente.nit',
            'cotizacion_cliente.direccion as direccion_comercial',
            'clientes.nombre_contacto',
            'cotizacion_maestro.lugar_entrega',
            'cotizacion_maestro.atencion_a',
            'clientes.dias_credito',
            'clientes.descuento_autorizado',
            'cotizacion_maestro.estado_id',
            DB::raw('CONCAT(vendedores.nombres," ",vendedores.apellidos) as vendedor'),
            'estados.descripcion as estado',
            'cotizacion_maestro.tiempo_entrega',
            'cotizacion_maestro.validez_oferta',
            'cotizacion_maestro.transportado_por',
            'cotizacion_maestro.anotaciones',
            'cotizacion_maestro.referencia',
            'cotizacion_maestro.observaciones',
            'cotizacion_maestro.total',
            'cotizacion_maestro.tipo_pago_id',
            'cotizacion_maestro.porcentaje',
            'cotizacion_maestro.descuento_porcentaje',
            'cotizacion_maestro.descuento_valores',
            'tipo_pago.tipo_pago',
            'users.name',
            'cotizacion_maestro.created_at'
         )->join(
             'estados',
             'cotizacion_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'series',
             'cotizacion_maestro.serie_id',
             '=',
             'series.id'
          )->join(
             'clientes',
             'cotizacion_maestro.cliente_id',
             '=',
             'clientes.id'
        )->join(
             'cotizacion_cliente',
             'cotizacion_maestro.id',
             '=',
             'cotizacion_cliente.cotizacion_id'
         )->join(
            'users',
            'cotizacion_maestro.user_id',
            '=',
            'users.id'
         )->join(
            'vendedores',
            'clientes.vendedor_id',
            '=',
            'vendedores.id'
         )->join(
             'tipo_pago',
             'cotizacion_maestro.tipo_pago_id',
             '=',
             'tipo_pago.id'
        )->where(
            'cotizacion_maestro.estado_id',
            '=',
            '1'
        )->where(
            'cotizacion_maestro.id',
            '=',
            $cotizacion_maestro->id
        )->get();


    }

        

        $cotizaciondetalle = Cotizacion_Detalle::select(
            'cotizacion_detalle.id',
            'cotizacion_detalle.cantidad',
            'cotizacion_detalle.precio_unitario',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'cotizacion_detalle.desc_articulo',
            'cotizacion_detalle.subtotal'
        )->join(
            'articulos',
            'cotizacion_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'cotizacion_detalle.cotizacion_maestro_id',
            '=',
            $cotizacion_maestro->id
        )->get();


        $formatter = new NumeroALetras;
        $nl = $formatter->toMoney($cotizacionmaestro[0]->total - $cotizacionmaestro[0]->descuento_porcentaje - $cotizacionmaestro[0]->descuento_valores , 2, 'Quetzales', 'Centavos');

        $pdf = \PDF::loadView('admin.cotizaciones.pdfcotizacion', compact('cotizacionmaestro', 'cotizaciondetalle', 'nl'));
        return $pdf->stream('cotizacion.pdf');
    }



    public function edit(Cotizacion_Maestro $cotizacion_maestro)
    {
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 4)->get();
        $clientes = Cliente::WHERE("estado_id","=", 1)->get();
        $clientes_asig = Cliente::WHERE("estado_id","=", 1)->WHERE("id","=", $cotizacion_maestro->cliente_id)->get();
        $tipo_pago = Tipo_Pago::all();
        $crea = Auth::user()->name;
        $vendedor = Vendedor::WHERE("estado_id","=", 1)->WHERE("user_asignado_id","=", Auth::user()->id)->get();
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        $cotizacion_detalle = Cotizacion_Detalle::WHERE("cotizacion_maestro_id","=", $cotizacion_maestro->id)->get();
        
        return view('admin.cotizaciones.edit', compact('clientes', 'clientes_asig','articulos', 'crea', 'tipo_pago', 'series', 'vendedor', 'cotizacion_maestro', 'cotizacion_detalle'));
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cotizacion_Maestro $cotizacion_maestro)
    {
        $arr = json_decode($request->getContent(), true); 

        $serie_id               = $arr[1]["value"];
        $maestro_id             = $arr[2]["value"];
        $fecha_documento        = date_format(date_create($arr[3]["value"]), "Y/m/d");
        $tipo_pago_id           = $arr[4]["value"];
        $cliente_id             = $arr[5]["value"];
        $nit_cliente            = $arr[6]["value"];
        $dias_credito_cliente   = $arr[7]["value"];
        $nombre_cliente         = $arr[8]["value"];
        $direccion_cliente      = $arr[9]["value"];
        $lugar_entrega          = $arr[10]["value"];
        $porcentaje             = $arr[11]["value"];
        $descuento_porcentaje   = ($arr[26]["value"] * $arr[11]["value"]) / 100;
        $descuento_valores      = $arr[12]["value"];
        $atencion_a             = $arr[13]["value"];
        $exenta                 = $arr[15]["value"];
        $tiempo_entrega         = $arr[16]["value"];
        $validez_oferta         = $arr[17]["value"];
        $transportado_por       = $arr[18]["value"];
        $anotaciones            = $arr[19]["value"];
        $referencia             = $arr[20]["value"];
        $observaciones          = $arr[21]["value"];
        $total                  = $arr[26]["value"];

        $cot_maestro = Cotizacion_Maestro::Where("id",$maestro_id)->get();
        $cot_maestro[0]->serie_id = $serie_id;
        $cot_maestro[0]->fecha_documento = $fecha_documento;
        $cot_maestro[0]->cliente_id = $cliente_id;
        $cot_maestro[0]->anotaciones = $anotaciones;
        $cot_maestro[0]->referencia = $referencia;
        $cot_maestro[0]->observaciones = $observaciones;
        $cot_maestro[0]->tipo_pago_id = $tipo_pago_id;
        $cot_maestro[0]->exenta = $exenta;
        $cot_maestro[0]->tiempo_entrega = $tiempo_entrega;
        $cot_maestro[0]->validez_oferta = $validez_oferta;
        $cot_maestro[0]->transportado_por = $transportado_por;
        $cot_maestro[0]->lugar_entrega = $lugar_entrega;
        $cot_maestro[0]->atencion_a = $atencion_a;
        $cot_maestro[0]->descuento_porcentaje = $descuento_porcentaje;
        $cot_maestro[0]->porcentaje = $porcentaje;
        $cot_maestro[0]->descuento_valores = $descuento_valores;
        $cot_maestro[0]->total = $total;
        $cot_maestro[0]->save();

        if ($cliente_id == 0){

            $ecc = CotizacionCliente::create([
                'nit'           => $nit_cliente,
                'nombre'        => $nombre_cliente,
                'direccion'     => $direccion_cliente,
                'cotizacion_id'    => $maestro_id
            ]);
        }

        if ( sizeof($arr) >= 27 ){

            for ($i=27; $i < sizeof($arr) ; $i++) {
                $cd = Cotizacion_Detalle::create([
                    'cotizacion_maestro_id'   => $maestro_id,
                    'articulo_id'             => $arr[$i]["articulo_id"],
                    'desc_articulo'           => $arr[$i]["articulo"],
                    'cantidad'                => $arr[$i]["cantidad"],
                    'precio_unitario'         => $arr[$i]["precio_unitario"],
                    'subtotal'                => $arr[$i]["subtotal"],
                ]);
            }

        }
 
        event(new ActualizacionBitacora($cotizacion_maestro->id, Auth::user()->id,'Edición de Cotización Maestro',$cotizacion_maestro,'','cotizacion_maestro'));
      
        return Response::json(['success' => 'Éxito']);
    }


    public function editdetalle(Cotizacion_Detalle $cotizacion_detalle)
    {
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        
        return view('admin.cotizaciones.editdetalle', compact('articulos', 'cotizacion_detalle'));
    }


    public function updatedetalle(Request $request, Cotizacion_Detalle $cotizacion_detalle)
    {
        event(new ActualizacionBitacora($cotizacion_detalle->id, Auth::user()->id,'Edición del detalle de cotización',$cotizacion_detalle,'','cotizacion_detalle'));

        $cotizacion_detalle->subtotal = $request->cantidad * $request->precio_unitario;
        $cotizacion_detalle->update($request->all());

        $total = Cotizacion_Detalle::select(
            DB::raw('SUM(subtotal) as total')
        )->Where(
            "cotizacion_maestro_id",
            "=",
            $cotizacion_detalle->cotizacion_maestro_id
        )->get();

        $cotizacion_maestro = Cotizacion_Maestro::Where("id","=",$cotizacion_detalle->cotizacion_maestro_id)->get();
        $cotizacion_maestro[0]->total = $total[0]->total;
        $cotizacion_maestro[0]->save();
      
        return redirect()->route('cotizaciones.edit', $cotizacion_detalle->cotizacion_maestro_id)->with('flash','La Cotización Detalle ha sido actualizada!');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotizacion_Maestro $cotizacion_maestro, Request $request)
    {
        $cotizacion_maestro->estado_id = 3;
        $cotizacion_maestro->save();

        event(new ActualizacionBitacora($cotizacion_maestro->id, Auth::user()->id, 'Eliminación', '', '', 'Cotización'));

        return Response::json(['success' => 'Éxito']);
    }



    public function destroydetalle(Cotizacion_Detalle $cotizacion_detalle, Request $request)
    {
        $cotizacion_detalle->delete();

        $total = Cotizacion_Detalle::select(
            DB::raw('SUM(subtotal) as total')
        )->Where(
            "cotizacion_maestro_id",
            "=",
            $cotizacion_detalle->cotizacion_maestro_id
        )->get();

        $cotizacion_maestro = Cotizacion_Maestro::Where("id","=",$cotizacion_detalle->cotizacion_maestro_id)->get();
        $cotizacion_maestro[0]->total = $total[0]->total;
        $cotizacion_maestro[0]->save();

        event(new ActualizacionBitacora($cotizacion_detalle->id, Auth::user()->id, 'Eliminación', '', '', 'Cotización Detalle'));

        return redirect()->route('cotizaciones.edit', $cotizacion_detalle->cotizacion_maestro_id)->with('flash','La Cotización Detalle ha sido eliminada!');
    }




    public function getdetalle($id)
    {
        $api_result = Cotizacion_Detalle::Select(
            'cotizacion_detalle.id',
            'cotizacion_detalle.articulo_id',
            'cotizacion_detalle.cantidad',
            'cotizacion_detalle.desc_articulo',
            'cotizacion_detalle.precio_unitario',
            'cotizacion_detalle.subtotal'
        )->Where(
            'cotizacion_detalle.cotizacion_maestro_id',
            '=',
            $id
        )->get();  

        return Response::json($api_result);
    }


    public function getCliente($id){
        
        $api_result = Cliente::Select(
            'clientes.nit',
            'clientes.dias_credito',
            'clientes.nombre_comercial',
            'clientes.direccion_comercial',
            'clientes.lugar_entrega',
            'clientes.nombre_contacto',
            'clientes.vendedor_id',
            'clientes.descuento_autorizado',
            'vendedores.nombres',
            'vendedores.apellidos'
        )->join(
            'vendedores',
            'clientes.vendedor_id',
            '=',
            'vendedores.id'
        )->Where(
            'clientes.id',
            '=',
            $id
        )->Where(
            'clientes.estado_id',
            '=',
            1
        )->get();  
        return Response::json($api_result);
    }


    public function getArticulo($id){
        
        $api_result = Articulo::Select(
            'articulos.id',
            'articulos.descripcion',
            'articulos.precio_quetzales',
            'bodegas.descripcion as bodega',
            DB::raw('SUM(movimientos_bodegas.cantidad) as existencia')
        )->join(
            'movimientos_bodegas',
            'movimientos_bodegas.producto_id',
            '=',
            'articulos.id'
        )->join(
            'bodegas',
            'movimientos_bodegas.bodega_id',
            '=',
            'bodegas.id'
        )->groupBy(
            'articulos.id',
            'articulos.descripcion',
            'articulos.precio_quetzales',
            'bodegas.descripcion'
        )->where(
            'articulos.id',
            '=',
            $id
        )->where(
            'articulos.estado_id',
            '=',
            1
        )->get();  

        return Response::json($api_result);
    }

    public function getSerie($id){
        $api_result = Serie::Where("id","=",$id)->Where("estado_id","=",1)->get();
          
        return Response::json($api_result);
    }
}
