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
use App\Cliente;
use App\Serie;
use App\TipoAbono;
use App\Factura_Maestro;
use App\Vendedor;
use App\Abono_Detalle;
use App\Abono_Maestro;
use App\EstadoCuentaCliente;
use App\Events\ActualizacionBitacora;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade as PDF;
use Validator;


use App\Infile\notacreditoel;


class AbonosController extends Controller
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
        return view('admin.abonos.index');
    }

    public function getJson(Request $params)
    {
       $api_Result['data'] = Abono_Maestro::select(
           'abono_maestro.id',
           'abono_maestro.serie_id',
           'series.serie',
           'abono_maestro.correlativo_documento',
           'abono_maestro.fecha_documento',
           'clientes.nombre_comercial as cliente',
           'abono_maestro.estado_id',
           'estados.descripcion as estado',
           'abono_maestro.total',
           'abono_maestro.tipo_abono_id',
           'tipo_abono.tipo_abono',
           'users.name as crea',
           'abono_maestro.created_at'
        )->join(
            'estados',
            'abono_maestro.estado_id',
            '=',
            'estados.id'
        )->join(
            'series',
            'abono_maestro.serie_id',
            '=',
            'series.id'
         )->join(
            'clientes',
            'abono_maestro.cliente_id',
            '=',
            'clientes.id'
        )->join(
            'users',
            'abono_maestro.user_id',
            '=',
            'users.id'
        )->join(
            'tipo_abono',
            'abono_maestro.tipo_abono_id',
            '=',
            'tipo_abono.id'
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
        $tipo_abono = TipoAbono::all();
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 5)->get();
        $clientes = Cliente::WHERE("estado_id","=", 1)->WHERE("id",">",0)->get();

        return view('admin.abonos.create', compact('tipo_abono', 'series', 'articulos','clientes'));
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

        $tipo_abono_id                  = $arr[1]["value"];
        $serie_id                       = $arr[2]["value"];
        $correlativo_documento          = $arr[3]["value"];
        $fecha_documento                = date_format(date_create($arr[4]["value"]), "Y/m/d");
        $autorizacion_sat               = "";
        $cliente_id                     = $arr[5]["value"];
        $concepto                       = $arr[6]["value"];
        $total                          = $arr[10]["value"];
        $empresa_id                     = $user_perfil[0]->empresa_id;
        $estado_id                      = 1;
        $user_id                        = Auth::user()->id;
        

        $series = Serie::WHERE("estado_id","=", 1)->WHERE("id","=", $serie_id)->get();
        $series[0]->correlativo = $correlativo_documento + 1;
        $series[0]->save();

        $ac = Abono_Maestro::create([
            'tipo_abono_id'                 => $tipo_abono_id,
            'serie_id'                      => $serie_id,
            'correlativo_documento'         => $correlativo_documento,
            'fecha_documento'               => $fecha_documento,
            'autorizacion_sat'              => $autorizacion_sat,
            'cliente_id'                    => $cliente_id,
            'concepto'                      => $concepto,
            'total'                         => $total,
            'empresa_id'                    => $empresa_id,
            'estado_id'                     => $estado_id,
            'user_id'                       => $user_id,
            ]);

            
        $cl = Cliente::WHERE("id","=",$cliente_id)->get();
        $cl[0]->saldo_actual = $cl[0]->saldo_actual - $total;
        $cl[0]->save();


        for ($i=11; $i < sizeof($arr) ; $i++) {
            $ad = Abono_Detalle::create([
                'abono_maestro_id'          => $ac->id,
                'factura_maestro_id'        => $arr[$i]["factura_id"],
                'descripcion'               => "Abono a Factura " . $arr[$i]["serie"] . "-" . $arr[$i]["documento"],
                'total_factura'             => $arr[$i]["monto"],
                'abono'                     => $arr[$i]["abono"],
                'saldo'                     => $arr[$i]["saldo"],
            ]);



            $ecc = EstadoCuentaCliente::WHERE("factura_maestro_id","=",$arr[$i]["factura_id"] )->get();
            $ecc[0]->abono = $ecc[0]->abono + $arr[$i]["abono"];
            $ecc[0]->saldo = $arr[$i]["saldo"];
            $ecc[0]->save();


            $ecc = Factura_Maestro::WHERE("id","=",$arr[$i]["factura_id"] )->get();
            $ecc[0]->total_pagado = $ecc[0]->total_pagado + $arr[$i]["abono"];
            $ecc[0]->saldo = $arr[$i]["saldo"];
            
            

            if ($arr[$i]["saldo"] == 0){
                $ecc[0]->estado_pago_id = 3;
            }else{
                $ecc[0]->estado_pago_id = 2;
            }
            
            $ecc[0]->save();
            
        }

        //writes the new purchase to log
        event(new ActualizacionBitacora($ac->id, Auth::user()->id, 'Creacion', '', $ac, 'abono maestro'));


        // if ($tipo_abono_id == 2){
        //     if (is_null($ac->fel_uuid)){
        //         $fel = new notacreditoel();
        //         if(!$fel->generarFEL($ac->id, $ac->cliente_id)){
        //             return Response::json(['success' => 'Error-FEL']);
        //         }
    
        //     }
        // }
        
        return Response::json(['success' => 'Éxito']);
    }



    public function pdfnotacredito(Abono_Maestro $abono_maestro)
    {
        $abonomaestro = Abono_Maestro::select(
            'abono_maestro.id',
            'abono_maestro.serie_id',
            'series.serie',
            'abono_maestro.correlativo_documento',
            'abono_maestro.fecha_documento',
            'tipo_abono.tipo_abono',
            'clientes.nombre_comercial',
            'clientes.nit',
            'clientes.direccion_comercial',
            'abono_maestro.estado_id',
            'estados.descripcion as estado',
            'abono_maestro.concepto',
            'abono_maestro.total',
            'abono_maestro.fel_uuid',
            'abono_maestro.fel_serie',
            'abono_maestro.fel_numero',
            'abono_maestro.fel_fecha_certificacion',
            'users.name',
            'abono_maestro.created_at'
         )->join(
             'estados',
             'abono_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'series',
             'abono_maestro.serie_id',
             '=',
             'series.id'
        )->join(
             'clientes',
             'abono_maestro.cliente_id',
             '=',
             'clientes.id'
         )->join(
            'users',
            'abono_maestro.user_id',
            '=',
            'users.id'
         )->join(
             'tipo_abono',
             'abono_maestro.tipo_abono_id',
             '=',
             'tipo_abono.id'
        )->where(
            'abono_maestro.estado_id',
            '<>',
            '3'
        )->where(
            'abono_maestro.id',
            '=',
            $abono_maestro->id
        )->get();

        $abonodetalle = Abono_Detalle::select(
            'abono_detalle.id',
            'factura_maestro.correlativo_documento',
            'factura_maestro.fecha_documento',
            'factura_maestro.total',
            'factura_maestro.total_pagado',
            'factura_maestro.descuento_valores',
            'factura_maestro.descuento_porcentaje',
            'abono_detalle.total_factura',
            'abono_detalle.abono',
            'abono_detalle.saldo',
            'series.serie'
        )->join(
            'factura_maestro',
            'abono_detalle.factura_maestro_id',
            '=',
            'factura_maestro.id'
        )->join(
            'series',
            'factura_maestro.serie_id',
            '=',
            'series.id'
        )->where(
            'abono_detalle.abono_maestro_id',
            '=',
            $abono_maestro->id
        )->get();

        $formatter = new NumeroALetras;
        $nl = $formatter->toMoney($abonomaestro[0]->total, 2, 'Quetzales', 'Centavos');


        $pdf = \PDF::loadView('admin.abonos.pdfnotacredito', compact('abonomaestro', 'abonodetalle', 'nl'));
        return $pdf->stream('nota_credito.pdf');
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
            'factura_maestro.id as fac_id',
            'factura_maestro.serie_id',
            'factura_maestro.correlativo_documento',
            'factura_maestro.total',
            'factura_maestro.saldo',
            'factura_maestro.descuento_porcentaje',
            'factura_maestro.descuento_valores',
            'series.serie'
        )->join(
            'factura_maestro',
            'clientes.id',
            '=',
            'factura_maestro.cliente_id'
        )->join(
            'series',
            'factura_maestro.serie_id',
            '=',
            'series.id'
        )->Where(
            'clientes.id',
            '=',
            $id
        )->Where(
            'clientes.estado_id',
            '=',
            1
        )->Where(
            'factura_maestro.estado_pago_id',
            '<',
            3
        )->get();  
        return Response::json($api_result);
    }



    public function getFacturas($id){
        
        $api_result = Factura_Maestro::Select(
            'factura_maestro.id',
            'factura_maestro.serie_id',
            'factura_maestro.correlativo_documento',
            'factura_maestro.fecha_documento',
            'factura_maestro.total',
            'factura_maestro.descuento_porcentaje',
            'factura_maestro.descuento_valores',
            'factura_maestro.total_pagado',
            'factura_maestro.saldo',
            'series.serie'
        )->join(
            'series',
            'factura_maestro.serie_id',
            '=',
            'series.id'
        )->Where(
            'factura_maestro.id',
            '=',
            $id
        )->get();  

        return Response::json($api_result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Abono_Maestro $abono_maestro)
    {
        $abonomaestro = Abono_Maestro::select(
            'abono_maestro.id',
            'abono_maestro.serie_id',
            'series.serie',
            'abono_maestro.correlativo_documento',
            'abono_maestro.fecha_documento',
            'tipo_abono.tipo_abono',
            'clientes.nombre_comercial',
            'clientes.nit',
            'abono_maestro.estado_id',
            'estados.descripcion as estado',
            'abono_maestro.concepto',
            'abono_maestro.total',
            'users.name',
            'abono_maestro.created_at'
         )->join(
             'estados',
             'abono_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'series',
             'abono_maestro.serie_id',
             '=',
             'series.id'
        )->join(
             'clientes',
             'abono_maestro.cliente_id',
             '=',
             'clientes.id'
         )->join(
            'users',
            'abono_maestro.user_id',
            '=',
            'users.id'
         )->join(
             'tipo_abono',
             'abono_maestro.tipo_abono_id',
             '=',
             'tipo_abono.id'
        )->where(
            'abono_maestro.estado_id',
            '<>',
            '3'
        )->where(
            'abono_maestro.id',
            '=',
            $abono_maestro->id
        )->get();



        $abonodetalle = Abono_Detalle::select(
            'abono_detalle.id',
            'factura_maestro.correlativo_documento',
            'factura_maestro.fecha_documento',
            'factura_maestro.total',
            'factura_maestro.total_pagado',
            'factura_maestro.saldo',
            'factura_maestro.descuento_valores',
            'factura_maestro.descuento_porcentaje',
            'series.serie'
        )->join(
            'factura_maestro',
            'abono_detalle.factura_maestro_id',
            '=',
            'factura_maestro.id'
        )->join(
            'series',
            'factura_maestro.serie_id',
            '=',
            'series.id'
        )->where(
            'abono_detalle.abono_maestro_id',
            '=',
            $abono_maestro->id
        )->get();

        return view('admin.abonos.show', compact('abonomaestro', 'abonodetalle'));
    }


    public function getSerie($id){
        $api_result = Serie::Where("id","=",$id)->Where("estado_id","=",1)->get();
          
        return Response::json($api_result);
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
    public function destroy(Abono_Maestro $abono_maestro, Request $request)
    {
        $abono_maestro->estado_id = 4;

        $cl = Cliente::WHERE("id","=",$abono_maestro->cliente_id)->get();
        $cl[0]->saldo_actual = $cl[0]->saldo_actual + $abono_maestro->total;
        $cl[0]->save();

        $abono_detalle = Abono_Detalle::Where("abono_maestro_id",$abono_maestro->id)->get();

        for ($i=0; $i < count($abono_detalle) ; $i++) {

            $ecc = EstadoCuentaCliente::WHERE("factura_maestro_id","=",$abono_detalle[$i]->factura_maestro_id)->get();
            $ecc[0]->abono = $ecc[0]->abono - $abono_detalle[$i]->abono;
            $ecc[0]->saldo = $ecc[0]->saldo + $abono_detalle[$i]->abono;
            $ecc[0]->save();


            $ecc2 = Factura_Maestro::WHERE("id","=",$abono_detalle[$i]->factura_maestro_id )->get();
            $ecc2[0]->total_pagado = $ecc2[0]->total_pagado - $abono_detalle[$i]->abono;
            $ecc2[0]->saldo = $ecc2[0]->saldo + $abono_detalle[$i]->abono;
            $ecc2[0]->estado_pago_id = 2;
            $ecc2[0]->save();
        }

        $abono_maestro->save();

        event(new ActualizacionBitacora($abono_maestro->id, Auth::user()->id, 'Anulación', '', '', 'Abonos'));

        return Response::json(['success' => 'Éxito']);
    }
}
