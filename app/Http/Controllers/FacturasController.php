<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\User_Perfil;
use App\Empresa;
use App\Articulo;
use App\Cliente;
use App\Serie;
use App\Tipo_Documento_Importacion;
use App\Tipo_Pago;
use App\TipoFactura;
use App\ListFacturacion;
use App\Vendedor;
use App\Factura_Detalle;
use App\FacturaCliente;
use App\Cotizacion_Detalle;
use App\Orden_Compra_Detalle;
use App\Factura_Maestro;
use App\Cotizacion_Maestro;
use App\EstadoCuentaCliente;
use App\Movimiento_Bodega;
use App\Orden_Compra_Maestro;
use App\Events\ActualizacionBitacora;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade as PDF;
use Validator;

 //INFILE
 use App\Infile\Fel;
 use App\Infile\Fcamel;

class FacturasController extends Controller
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
        return view('admin.facturas.index');
    }


    public function indexv()
    {
        return view('admin.facturas.indexv');
    }

    public function indexexport()
    {
        return view('admin.facturas.indexexport');
    }

    public function getJsonexport(Request $params)
    {
       $api_Result['data'] = ListFacturacion::select(
           'listfacturacion.id',
           'listfacturacion.tipo_factura',
           'listfacturacion.fecha',
           'listfacturacion.ubicacion',
           'users.name'
        )->join(
            'users',
            'listfacturacion.user_id',
            '=',
            'users.id'
        )->where(
           'listfacturacion.estado_id',
           '<',
           '3'
       )->get();

       return Response::json( $api_Result );
   }


    public function generatxt()
    {
        return view('admin.facturas.generatxt');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getJson(Request $params)
    {
       $api_Result['data'] = Factura_Maestro::select(
           'factura_maestro.id',
           'factura_maestro.serie_id',
           'series.serie',
           'factura_maestro.correlativo_documento',
           'factura_maestro.fecha_documento',
           'clientes.nombre_comercial as cliente',
           'factura_cliente.nombre as clientec',
           'factura_maestro.estado_id',
           'estados.descripcion as estado',
           'factura_maestro.cliente_id',
           'factura_maestro.total',
           'factura_maestro.fel_uuid',
           'factura_maestro.tipo_factura_id',
           'factura_maestro.descuento_valores',
           'factura_maestro.descuento_porcentaje',
           'tipo_factura.tipo_factura',
           'us1.name as crea',
           'factura_maestro.created_at'
        )->join(
            'estados',
            'factura_maestro.estado_id',
            '=',
            'estados.id'
        )->join(
            'series',
            'factura_maestro.serie_id',
            '=',
            'series.id'
         )->join(
            'clientes',
            'factura_maestro.cliente_id',
            '=',
            'clientes.id'
        )->leftJoin(
            'factura_cliente',
            'factura_maestro.id',
            '=',
            'factura_cliente.factura_id'    
        )->join(
            'users as us1',
            'factura_maestro.user_id',
            '=',
            'us1.id'
        )->join(
            'tipo_factura',
            'factura_maestro.tipo_factura_id',
            '=',
            'tipo_factura.id'
        )->where(
           'factura_maestro.estado_id',
           '<>',
           '3'
        )->get();


       return Response::json( $api_Result );
   }




   public function getJsonv(Request $params)
    {
       $api_Result['data'] = Factura_Maestro::select(
           'factura_maestro.id',
           'factura_maestro.serie_id',
           'series.serie',
           'factura_maestro.correlativo_documento',
           'factura_maestro.fecha_documento',
           'clientes.nombre_comercial as cliente',
           'factura_maestro.estado_id',
           'estados.descripcion as estado',
           'factura_maestro.total',
           'factura_maestro.saldo',
           'factura_maestro.tipo_factura_id',
           'factura_maestro.descuento_valores',
           'factura_maestro.descuento_porcentaje',
           'tipo_factura.tipo_factura',
           'us1.name as crea',
           'factura_maestro.created_at'
        )->join(
            'estados',
            'factura_maestro.estado_id',
            '=',
            'estados.id'
        )->join(
            'series',
            'factura_maestro.serie_id',
            '=',
            'series.id'
         )->join(
            'clientes',
            'factura_maestro.cliente_id',
            '=',
            'clientes.id'
        )->join(
            'users as us1',
            'factura_maestro.user_id',
            '=',
            'us1.id'
        )->join(
            'tipo_factura',
            'factura_maestro.tipo_factura_id',
            '=',
            'tipo_factura.id'
        )->where(
           'factura_maestro.estado_pago_id',
           '=',
           '4'
       )->get();

       return Response::json( $api_Result );
   }


    public function create()
    {
        $tipo_factura = TipoFactura::all();
        $series_cotizacion = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 4)->get();
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 3)->get();
        $clientes = Cliente::WHERE("estado_id","=", 1)->get();

        return view('admin.facturas.create', compact('series_cotizacion', 'tipo_factura', 'series', 'articulos', 'clientes'));
    }

    public function create2()
    {
        $tipo_factura = TipoFactura::all();
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();
        $clientes = Cliente::WHERE("estado_id","=", 1)->get();
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 3)->get();

        return view('admin.facturas.create2', compact('clientes', 'tipo_factura', 'series', 'articulos'));
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

        if ($arr[1]["value"] == 1){
            $ser = 2;
        }else{
            $ser = 3;
        }

        $series = Serie::WHERE("estado_id","=", 1)->WHERE("id","=", $ser)->get();
        

        $serie_id                       = $ser;
        $correlativo_documento          = $series[0]->correlativo + 1;
        $fecha_documento                = date_format(date_create($arr[6]["value"]), "Y/m/d");
        $tipo_factura_id                = $arr[1]["value"];

        if ($arr[10]["value"] == "")
        {
            $cliente_id = $arr[8]["value"];
        }
        else
        {
            $cliente_id = $arr[10]["value"];
        }

        $exenta                         = $arr[12]["value"];
        $orden_compra                   = $arr[5]["value"];
        $envios                         = $arr[15]["value"];
        $cotizacion_maestro_id          = $arr[4]["value"];
        $transportado_por               = $arr[7]["value"];
        $nit_cliente                    = $arr[9]["value"];
        $nombre_cliente                 = $arr[11]["value"];
        $porcentaje                     = $arr[13]["value"];
        $descuento_porcentaje           = ($arr[20]["value"] * $arr[13]["value"]) / 100;
        $descuento_valores              = $arr[14]["value"];
        $total                          = $arr[20]["value"];
        $total_pagado                   = 0;
        $saldo                          = $arr[20]["value"];
        $empresa_id                     = $user_perfil[0]->empresa_id;
        $estado_pago_id                 = 1;
        $estado_id                      = 1;
        $user_id                        = Auth::user()->id;


        $fc = Factura_Maestro::create([
            'serie_id'                      => $serie_id,
            'correlativo_documento'         => $correlativo_documento,
            'fecha_documento'               => $fecha_documento,
            'tipo_factura_id'               => $tipo_factura_id,
            'cliente_id'                    => $cliente_id,
            'exenta'                        => $exenta,
            'orden_compra'                  => $orden_compra,
            'envios'                        => $envios,
            'cotizacion_maestro_id'         => $cotizacion_maestro_id,
            'transportado_por'              => $transportado_por,
            'porcentaje'                    => $porcentaje,
            'descuento_porcentaje'          => $descuento_porcentaje,
            'descuento_valores'             => $descuento_valores,
            'total'                         => $total,
            'total_pagado'                  => $total_pagado,
            'saldo'                         => $saldo,
            'empresa_id'                    => $empresa_id,
            'estado_pago_id'                => $estado_pago_id,
            'estado_id'                     => $estado_id,
            'user_id'                       => $user_id,
            ]);


            if ($tipo_factura_id == 2){
                $ecc = EstadoCuentaCliente::create([
                    'cliente_id'            => $cliente_id,
                    'factura_maestro_id'    => $fc->id,
                    'monto'                 => $total,
                    'abono'                 => 0,
                    'saldo'                 => $total,
                ]);

                $cl = Cliente::WHERE("id","=",$cliente_id)->get();
                $cl[0]->saldo_actual = $cl[0]->saldo_actual + $total;
                $cl[0]->save();
            }


            if ($cliente_id == 0){

                $ecc = FacturaCliente::create([
                    'nit'           => $nit_cliente,
                    'nombre'        => $nombre_cliente,
                    'direccion'     => "Ciudad",
                    'factura_id'    => $fc->id
                ]);
            }

        for ($i=21; $i < sizeof($arr) ; $i++) {
            $od = Factura_Detalle::create([
                'factura_maestro_id'        => $fc->id,
                'articulo_id'               => $arr[$i]["articulo_id"],
                'desc_articulo'             => $arr[$i]["articulo"],
                'cantidad'                  => $arr[$i]["cantidad"],
                'precio_unitario'           => $arr[$i]["precio_unitario"],
                'subtotal'                  => $arr[$i]["subtotal"],
            ]);

            $mb = Movimiento_Bodega::WHERE("producto_id","=",$arr[$i]["articulo_id"])->get();
            $mb[0]->cantidad = $mb[0]->cantidad - ($arr[$i]["cantidad"]);
            $mb[0]->save();

            $ex = Movimiento_Bodega::SELECT(DB::raw('SUM(cantidad) as existencia'))->WHERE("producto_id","=",$arr[$i]["articulo_id"])->get();

            $art = Articulo::WHERE("id","=",$arr[$i]["articulo_id"])->get();
            $art[0]->existencia = $ex[0]->existencia;
            $art[0]->save();

        }

        $series[0]->correlativo = $series[0]->correlativo + 1;
        $series[0]->save();

        //writes the new purchase to log
        event(new ActualizacionBitacora($fc->id, Auth::user()->id, 'Creación', '', $fc, 'factura maestro'));

        
        //Factura FEL
        //   if (is_null($fc->fel_uuid)){
        //       if ($tipo_factura_id == 1){
        //           $fel = new Fel();
        //           if(!$fel->generarFEL($fc->id, $fc->cliente_id)){
        //               return Response::json(['success' => 'Error-FEL']);
        //           }
        //       }else{
        //           $fel = new Fcamel();
        //           if(!$fel->generarFEL($fc->id, $fc->cliente_id)){
        //               return Response::json(['success' => 'Error-FEL']);
        //           }
        //       }
        // }

        return Response::json(['success' => 'Éxito']);
    }


    public function store2(Request $request)
    {
        $arr = json_decode($request->getContent(), true);

        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();

        if ($arr[1]["value"] == 1){
            $ser = 2;
        }else{
            $ser = 3;
        }

        $series = Serie::WHERE("estado_id","=", 1)->WHERE("id","=", $ser)->get();


        $serie_id                       = $ser;
        $correlativo_documento          = $series[0]->correlativo + 1;
        $fecha_documento                = date_format(date_create($arr[3]["value"]), "Y/m/d");
        $tipo_factura_id                = $arr[1]["value"];
        $cliente_id                     = $arr[4]["value"];
        $exenta                         = $arr[8]["value"];
        $orden_compra                   = $arr[2]["value"];
        $envios                         = $arr[12]["value"];
        $cotizacion_maestro_id          = 1;
        $transportado_por               = $arr[11]["value"];
        $porcentaje                     = $arr[9]["value"];
        $descuento_porcentaje           = ($arr[17]["value"] * $arr[9]["value"]) / 100;
        $descuento_valores              = $arr[10]["value"];
        $total                          = $arr[17]["value"];
        $total_pagado                   = 0;
        $saldo                          = $arr[17]["value"];
        $empresa_id                     = $user_perfil[0]->empresa_id;
        $estado_pago_id                 = 1;
        $estado_id                      = 1;
        $user_id                        = Auth::user()->id;


        $fc = Factura_Maestro::create([
            'serie_id'                      => $serie_id,
            'correlativo_documento'         => $correlativo_documento,
            'fecha_documento'               => $fecha_documento,
            'tipo_factura_id'               => $tipo_factura_id,
            'cliente_id'                    => $cliente_id,
            'exenta'                        => $exenta,
            'orden_compra'                  => $orden_compra,
            'envios'                        => $envios,
            'cotizacion_maestro_id'         => $cotizacion_maestro_id,
            'transportado_por'              => $transportado_por,
            'porcentaje'                    => $porcentaje,
            'descuento_porcentaje'          => $descuento_porcentaje,
            'descuento_valores'             => $descuento_valores,
            'total'                         => $total,
            'total_pagado'                  => $total_pagado,
            'saldo'                         => $saldo,
            'empresa_id'                    => $empresa_id,
            'estado_pago_id'                => $estado_pago_id,
            'estado_id'                     => $estado_id,
            'user_id'                       => $user_id,
            ]);

            if ($tipo_factura_id == 2){
                $ecc = EstadoCuentaCliente::create([
                    'cliente_id'            => $cliente_id,
                    'factura_maestro_id'    => $fc->id,
                    'monto'                 => $total,
                    'abono'                 => 0,
                    'saldo'                 => $total,
                ]);

                $cl = Cliente::WHERE("id","=",$cliente_id)->get();
                $cl[0]->saldo_actual = $cl[0]->saldo_actual + $total;
                $cl[0]->save();
            }

            if ($cliente_id == 0){

                $ecc = FacturaCliente::create([
                    'nit'           => $arr[5]["value"],
                    'nombre'        => $arr[6]["value"],
                    'direccion'     => $arr[7]["value"],
                    'factura_id'    => $fc->id
                ]);

            }


        for ($i=18; $i < sizeof($arr) ; $i++) {
            $od = Factura_Detalle::create([
                'factura_maestro_id'        => $fc->id,
                'articulo_id'               => $arr[$i]["articulo_id"],
                'desc_articulo'             => $arr[$i]["articulo"],
                'cantidad'                  => $arr[$i]["cantidad"],
                'precio_unitario'           => $arr[$i]["precio_unitario"],
                'subtotal'                  => $arr[$i]["subtotal"],
            ]);

            $mb = Movimiento_Bodega::WHERE("producto_id","=",$arr[$i]["articulo_id"])->get();
            $mb[0]->cantidad = $mb[0]->cantidad - ($arr[$i]["cantidad"]);
            $mb[0]->save();

            $ex = Movimiento_Bodega::SELECT(DB::raw('SUM(cantidad) as existencia'))->WHERE("producto_id","=",$arr[$i]["articulo_id"])->get();

            $art = Articulo::WHERE("id","=",$arr[$i]["articulo_id"])->get();
            $art[0]->existencia = $ex[0]->existencia;
            $art[0]->save();

        }

        $series[0]->correlativo = $series[0]->correlativo + 1;
        $series[0]->save();

        //writes the new purchase to log
        event(new ActualizacionBitacora($fc->id, Auth::user()->id, 'Creación', '', $fc, 'factura maestro'));

        //Factura FEL
        // if (is_null($fc->fel_uuid)){
        //      if ($tipo_factura_id == 1){
        //          $fel = new Fel();
        //          if(!$fel->generarFEL($fc->id, $fc->cliente_id)){
        //              return Response::json(['success' => 'Error-FEL']);
        //          }
        //      }else{
        //          $fel = new Fcamel();
        //          if(!$fel->generarFEL($fc->id, $fc->cliente_id)){
        //              return Response::json(['success' => 'Error-FEL']);
        //          }
        //      }
        // }

        return Response::json(['success' => 'Éxito']);
    }




    public function storegeneratxt(Request $request)
    {

        $fecha = date_format(date_create($request->fecha_documento), "Y/m/d");

        $query = "SELECT CONCAT('01|',IF(fm.tipo_factura_id=1,'T','R'),'|',fm.correlativo_documento,'|',art.codigo_articulo,'|',fd.desc_articulo,'|',fd.cantidad,'|',fd.precio_unitario,'|') AS dato
        FROM factura_maestro fm
        INNER JOIN factura_detalle fd ON fm.id=fd.factura_maestro_id
        INNER JOIN articulos art ON fd.articulo_id=art.id
        WHERE DATE(fm.created_at) = '". $fecha ."' ";

        $detalles = DB::select($query);

        //$file=fopen('C:\Users\Public\facturasdetalle_'.$request->fecha_documento.'.txt','w');
        $file=fopen('facturasdetalle_'.$request->fecha_documento.'.txt','w');

        foreach($detalles as $det)
        {
            fwrite($file, $det->dato);
            fwrite($file,"\n");
        }

        fclose($file);

        $lf1 = ListFacturacion::create([
            'tipo_factura'        => "Factura Detalle",
            'ubicacion'           => "facturasdetalle_".$request->fecha_documento.".txt",
            'fecha'               => date_format(date_create($request->fecha_documento), "Y/m/d"),
            'estado_id'           => 1,
            'user_id'             => Auth::user()->id,
        ]);

        $query2 = "SELECT CONCAT('01|',IF(fm.tipo_factura_id=1,'T','R'),'|',fm.correlativo_documento,'|',IF(fm.tipo_factura_id=1,'C','R'),'|',cl.dias_credito,'|',
        DATE_FORMAT(fm.fecha_documento,'%d/%m/%Y'),'|',cl.codigo,'|',IF(fm.cliente_id=0,fc.nombre,cl.nombre_comercial),'|',IF(fm.cliente_id=0,fc.nit,cl.nit),'|',cl.direccion_comercial,'|',
        ven.codigo,'|',ven.codigo,'|',IF(fm.exenta='No','S','N'),'|',fm.orden_compra,'|',fm.envios,'|',fm.correlativo_documento,'|',
        fm.transportado_por,'|',cl.lugar_entrega,'|',fm.descuento_porcentaje,'|',fm.descuento_valores,'|',fm.total,'|',
        IF(fm.tipo_factura_id=1,0.00,fm.total),'|N|') AS dato 
        FROM factura_maestro fm 
        INNER JOIN clientes cl ON fm.cliente_id=cl.id 
        INNER JOIN vendedores ven ON ven.id=cl.vendedor_id 
        INNER JOIN cotizacion_maestro cm ON cm.id=fm.cotizacion_maestro_id 
        LEFT JOIN factura_cliente fc ON fc.factura_id=fm.id
        WHERE DATE(fm.created_at) = '". $fecha ."' ";

        $maestros = DB::select($query2);

        //$file2=fopen('C:\Users\Public\facturasmaestro_'.$request->fecha_documento.'.txt','w');
        $file2=fopen('facturasmaestro_'.$request->fecha_documento.'.txt','w');

        foreach($maestros as $mas)
        {
            fwrite($file2, $mas->dato);
            fwrite($file2,"\n");
        }

        fclose($file2);

        $lf1 = ListFacturacion::create([
            'tipo_factura'        => "Factura Maestro",
            'ubicacion'           => "facturasmaestro_".$request->fecha_documento.".txt",
            'fecha'               => date_format(date_create($request->fecha_documento), "Y/m/d"),
            'estado_id'           => 1,
            'user_id'             => Auth::user()->id,
        ]);

        return redirect()->route('facturas.indexexport')->withFlash('Se han generado los txt de la facturación del '. $request->fecha_documento.' de forma correcta, puede encontrarlo en C:\Users\Public');
    }



    public function getCliente($nit){

        $url = "https://consultareceptores.feel.com.gt/rest/action";

        $body = [
            "emisor_codigo" => "INFILEDEMOINTERNO",
            "emisor_clave" => "DF49C2CC2B9D9306896B71EB4B5A74D8",
            "nit_consulta" => $nit
        ];

        $json_body = json_encode( $body );

        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($json_body)
        ->send();

        return Response::json($response);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Factura_Maestro $factura_maestro)
    {
        if ($factura_maestro->cliente_id > 0){

        $facturamaestro = Factura_Maestro::select(
            'factura_maestro.id',
            'factura_maestro.serie_id',
            'series.serie',
            'factura_maestro.correlativo_documento',
            'factura_maestro.fecha_documento',
            'factura_maestro.cliente_id',
            'tipo_factura.tipo_factura',
            'clientes.nombre_comercial',
            'clientes.nit',
            'clientes.direccion_comercial',
            'clientes.descuento_autorizado',
            'factura_maestro.estado_id',
            'estados.descripcion as estado',
            'factura_maestro.exenta',
            'factura_maestro.envios',
            'factura_maestro.orden_compra',
            'factura_maestro.cotizacion_maestro_id',
            'cotizacion_maestro.correlativo_documento',
            'ser1.serie as serie_coti',
            'factura_maestro.transportado_por',
            'factura_maestro.total',
            'factura_maestro.porcentaje',
            'factura_maestro.descuento_porcentaje',
            'factura_maestro.descuento_valores',
            'factura_maestro.fel_numero',
            'factura_maestro.fel_serie',
            'factura_maestro.fel_uuid',
            'factura_maestro.fel_fecha_certificacion',
            'factura_maestro.fel_numero_anula',
            'factura_maestro.fel_serie_anula',
            'factura_maestro.fel_uuid_anula',
            'factura_maestro.fel_fecha_certificacion_anula',
            'us1.name as crea',
            'factura_maestro.created_at'
         )->join(
             'estados',
             'factura_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'series',
             'factura_maestro.serie_id',
             '=',
             'series.id'
        )->join(
             'clientes',
             'factura_maestro.cliente_id',
             '=',
             'clientes.id'
         )->join(
            'users as us1',
            'factura_maestro.user_id',
            '=',
            'us1.id'
         )->join(
            'cotizacion_maestro',
            'factura_maestro.cotizacion_maestro_id',
            '=',
            'cotizacion_maestro.id'
         )->join(
            'series as ser1',
            'cotizacion_maestro.serie_id',
            '=',
            'ser1.id'
         )->join(
             'tipo_factura',
             'factura_maestro.tipo_factura_id',
             '=',
             'tipo_factura.id'
        )->where(
            'factura_maestro.estado_id',
            '<>',
            '3'
        )->where(
            'factura_maestro.id',
            '=',
            $factura_maestro->id
        )->get();


        }else{

            $facturamaestro = Factura_Maestro::select(
                'factura_maestro.id',
                'factura_maestro.serie_id',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                'factura_maestro.cliente_id',
                'tipo_factura.tipo_factura',
                'clientes.descuento_autorizado',
                'factura_cliente.nombre as nombre_comercial',
                'factura_cliente.nit',
                'factura_cliente.direccion as direccion_comercial',
                'factura_maestro.estado_id',
                'estados.descripcion as estado',
                'factura_maestro.exenta',
                'factura_maestro.envios',
                'factura_maestro.orden_compra',
                'factura_maestro.cotizacion_maestro_id',
                'cotizacion_maestro.correlativo_documento',
                'ser1.serie as serie_coti',
                'factura_maestro.transportado_por',
                'factura_maestro.total',
                'factura_maestro.porcentaje',
                'factura_maestro.descuento_porcentaje',
                'factura_maestro.descuento_valores',
                'factura_maestro.fel_numero',
                'factura_maestro.fel_serie',
                'factura_maestro.fel_uuid',
                'factura_maestro.fel_fecha_certificacion',
                'factura_maestro.fel_numero_anula',
                'factura_maestro.fel_serie_anula',
                'factura_maestro.fel_uuid_anula',
                'factura_maestro.fel_fecha_certificacion_anula',
                'us1.name as crea',
                'factura_maestro.created_at'
             )->join(
                 'estados',
                 'factura_maestro.estado_id',
                 '=',
                 'estados.id'
             )->join(
                 'series',
                 'factura_maestro.serie_id',
                 '=',
                 'series.id'
            )->join(
                 'factura_cliente',
                 'factura_maestro.id',
                 '=',
                 'factura_cliente.factura_id'
            )->join(
                 'clientes',
                 'factura_maestro.cliente_id',
                 '=',
                 'clientes.id'
             )->join(
                'users as us1',
                'factura_maestro.user_id',
                '=',
                'us1.id'
             )->join(
                'cotizacion_maestro',
                'factura_maestro.cotizacion_maestro_id',
                '=',
                'cotizacion_maestro.id'
             )->join(
                'series as ser1',
                'cotizacion_maestro.serie_id',
                '=',
                'ser1.id'
             )->join(
                 'tipo_factura',
                 'factura_maestro.tipo_factura_id',
                 '=',
                 'tipo_factura.id'
            )->where(
                'factura_maestro.estado_id',
                '<>',
                '3'
            )->where(
                'factura_maestro.id',
                '=',
                $factura_maestro->id
            )->get();

        }


        $facturadetalle = Factura_Detalle::select(
            'factura_detalle.id',
            'factura_detalle.cantidad',
            'factura_detalle.precio_unitario',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'factura_detalle.desc_articulo',
            'factura_detalle.subtotal'
        )->join(
            'articulos',
            'factura_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'factura_detalle.factura_maestro_id',
            '=',
            $factura_maestro->id
        )->get();



        return view('admin.facturas.show', compact('facturamaestro', 'facturadetalle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function pdfFactura(Factura_Maestro $factura_maestro)
    {

        if ($factura_maestro->cliente_id > 0){


        $facturamaestro = Factura_Maestro::select(
            'factura_maestro.id',
            'factura_maestro.serie_id',
            'series.serie',
            'factura_maestro.correlativo_documento as num_fac',
            'factura_maestro.fecha_documento',
            'tipo_factura.tipo_factura',
            'factura_maestro.cliente_id',
            'clientes.nombre_comercial',
            'clientes.razon_social',
            'clientes.nit',
            'clientes.codigo as codigo_cliente',
            'clientes.descuento_autorizado',
            'clientes.direccion_comercial',
            'factura_maestro.estado_id',
            'estados.descripcion as estado',
            'factura_maestro.exenta',
            'factura_maestro.envios',
            'factura_maestro.orden_compra',
            'factura_maestro.cotizacion_maestro_id',
            'cotizacion_maestro.correlativo_documento as num_coti',
            'ser1.serie as serie_coti',
            'factura_maestro.transportado_por',
            'factura_maestro.total',
            'factura_maestro.porcentaje',
            'factura_maestro.descuento_porcentaje',
            'factura_maestro.descuento_valores',
            'factura_maestro.fel_uuid',
            'factura_maestro.fel_serie',
            'factura_maestro.fel_numero',
            'factura_maestro.fel_fecha_certificacion',
            DB::raw('CONCAT(vendedores.nombres," ",vendedores.apellidos) as vendedor'),
            'us1.name as crea',
            'factura_maestro.created_at'
         )->join(
             'estados',
             'factura_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'series',
             'factura_maestro.serie_id',
             '=',
             'series.id'
        )->join(
             'clientes',
             'factura_maestro.cliente_id',
             '=',
             'clientes.id'
         )->join(
            'users as us1',
            'factura_maestro.user_id',
            '=',
            'us1.id'
         )->join(
            'vendedores',
            'clientes.vendedor_id',
            '=',
            'vendedores.id'
         )->join(
            'cotizacion_maestro',
            'factura_maestro.cotizacion_maestro_id',
            '=',
            'cotizacion_maestro.id'
         )->join(
            'series as ser1',
            'cotizacion_maestro.serie_id',
            '=',
            'ser1.id'
         )->join(
             'tipo_factura',
             'factura_maestro.tipo_factura_id',
             '=',
             'tipo_factura.id'
        )->where(
            'factura_maestro.estado_id',
            '<>',
            '3'
        )->where(
            'factura_maestro.id',
            '=',
            $factura_maestro->id
        )->get();


        }else{

            $facturamaestro = Factura_Maestro::select(
                'factura_maestro.id',
                'factura_maestro.serie_id',
                'series.serie',
                'factura_maestro.correlativo_documento as num_fac',
                'factura_maestro.fecha_documento',
                'tipo_factura.tipo_factura',
                'factura_maestro.cliente_id',
                'clientes.codigo as codigo_cliente',
                'clientes.descuento_autorizado',
                'factura_cliente.nombre as nombre_comercial',
                'factura_cliente.nit',
                'factura_cliente.direccion as direccion_comercial',
                'factura_maestro.estado_id',
                'estados.descripcion as estado',
                'factura_maestro.exenta',
                'factura_maestro.envios',
                'factura_maestro.orden_compra',
                'factura_maestro.cotizacion_maestro_id',
                'cotizacion_maestro.correlativo_documento as num_coti',
                'ser1.serie as serie_coti',
                'factura_maestro.transportado_por',
                'factura_maestro.total',
                'factura_maestro.porcentaje',
                'factura_maestro.descuento_porcentaje',
                'factura_maestro.descuento_valores',
                'factura_maestro.fel_uuid',
                'factura_maestro.fel_serie',
                'factura_maestro.fel_numero',
                'factura_maestro.fel_fecha_certificacion',
                DB::raw('CONCAT(vendedores.nombres," ",vendedores.apellidos) as vendedor'),
                'us1.name as crea',
                'factura_maestro.created_at'
             )->join(
                 'estados',
                 'factura_maestro.estado_id',
                 '=',
                 'estados.id'
             )->join(
                 'series',
                 'factura_maestro.serie_id',
                 '=',
                 'series.id'
            )->join(
                'factura_cliente',
                'factura_maestro.id',
                '=',
                'factura_cliente.factura_id'
            )->join(
                'clientes',
                'factura_maestro.cliente_id',
                '=',
                'clientes.id'
             )->join(
                'users as us1',
                'factura_maestro.user_id',
                '=',
                'us1.id'
             )->join(
                'vendedores',
                'clientes.vendedor_id',
                '=',
                'vendedores.id'
             )->join(
                'cotizacion_maestro',
                'factura_maestro.cotizacion_maestro_id',
                '=',
                'cotizacion_maestro.id'
             )->join(
                'series as ser1',
                'cotizacion_maestro.serie_id',
                '=',
                'ser1.id'
             )->join(
                 'tipo_factura',
                 'factura_maestro.tipo_factura_id',
                 '=',
                 'tipo_factura.id'
            )->where(
                'factura_maestro.estado_id',
                '<>',
                '3'
            )->where(
                'factura_maestro.id',
                '=',
                $factura_maestro->id
            )->get();

        }



        $facturadetalle = Factura_Detalle::select(
            'factura_detalle.id',
            'factura_detalle.cantidad',
            'factura_detalle.precio_unitario',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'factura_detalle.desc_articulo',
            'factura_detalle.subtotal'
        )->join(
            'articulos',
            'factura_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'factura_detalle.factura_maestro_id',
            '=',
            $factura_maestro->id
        )->get();

        $formatter = new NumeroALetras;
        $nl = $formatter->toMoney($facturamaestro[0]->total - $facturamaestro[0]->descuento_porcentaje - $facturamaestro[0]->descuento_valores , 2, 'Quetzales', 'Centavos');

        $pdf = \PDF::loadView('admin.facturas.pdffactura', compact('facturamaestro', 'facturadetalle', 'nl'));
        return $pdf->stream('factura.pdf');
    }



    public function pdfFacturaCambiaria(Factura_Maestro $factura_maestro)
    {

        if ($factura_maestro->cliente_id > 0){


        $facturamaestro = Factura_Maestro::select(
            'factura_maestro.id',
            'factura_maestro.serie_id',
            'series.serie',
            'factura_maestro.correlativo_documento as num_fac',
            'factura_maestro.fecha_documento',
            'tipo_factura.tipo_factura',
            'clientes.nombre_comercial',
            'clientes.razon_social',
            'clientes.nit',
            'clientes.codigo as codigo_cliente',
            'clientes.direccion_comercial',
            'factura_maestro.estado_id',
            'estados.descripcion as estado',
            'factura_maestro.exenta',
            'factura_maestro.envios',
            'factura_maestro.orden_compra',
            'factura_maestro.cotizacion_maestro_id',
            'cotizacion_maestro.correlativo_documento as num_coti',
            'ser1.serie as serie_coti',
            'factura_maestro.transportado_por',
            'factura_maestro.total',
            'factura_maestro.porcentaje',
            'factura_maestro.descuento_porcentaje',
            'factura_maestro.descuento_valores',
            'factura_maestro.fel_uuid',
            'factura_maestro.fel_serie',
            'factura_maestro.fel_numero',
            'factura_maestro.fel_fecha_certificacion',
            DB::raw('CONCAT(vendedores.nombres," ",vendedores.apellidos) as vendedor'),
            'us1.name as crea',
            'factura_maestro.created_at'
         )->join(
             'estados',
             'factura_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'series',
             'factura_maestro.serie_id',
             '=',
             'series.id'
        )->join(
             'clientes',
             'factura_maestro.cliente_id',
             '=',
             'clientes.id'
         )->join(
            'users as us1',
            'factura_maestro.user_id',
            '=',
            'us1.id'
         )->join(
            'vendedores',
            'clientes.vendedor_id',
            '=',
            'vendedores.id'
         )->join(
            'cotizacion_maestro',
            'factura_maestro.cotizacion_maestro_id',
            '=',
            'cotizacion_maestro.id'
         )->join(
            'series as ser1',
            'cotizacion_maestro.serie_id',
            '=',
            'ser1.id'
         )->join(
             'tipo_factura',
             'factura_maestro.tipo_factura_id',
             '=',
             'tipo_factura.id'
        )->where(
            'factura_maestro.estado_id',
            '<>',
            '3'
        )->where(
            'factura_maestro.id',
            '=',
            $factura_maestro->id
        )->get();

    }else{

        $facturamaestro = Factura_Maestro::select(
            'factura_maestro.id',
            'factura_maestro.serie_id',
            'series.serie',
            'factura_maestro.correlativo_documento as num_fac',
            'factura_maestro.fecha_documento',
            'tipo_factura.tipo_factura',
            'factura_maestro.cliente_id',
            'clientes.codigo as codigo_cliente',
            'clientes.descuento_autorizado',
            'factura_cliente.nombre as nombre_comercial',
            'factura_cliente.nit',
            'factura_cliente.direccion as direccion_comercial',
            'factura_maestro.estado_id',
            'estados.descripcion as estado',
            'factura_maestro.exenta',
            'factura_maestro.envios',
            'factura_maestro.orden_compra',
            'factura_maestro.cotizacion_maestro_id',
            'cotizacion_maestro.correlativo_documento as num_coti',
            'ser1.serie as serie_coti',
            'factura_maestro.transportado_por',
            'factura_maestro.total',
            'factura_maestro.porcentaje',
            'factura_maestro.descuento_porcentaje',
            'factura_maestro.descuento_valores',
            'factura_maestro.fel_uuid',
            'factura_maestro.fel_serie',
            'factura_maestro.fel_numero',
            'factura_maestro.fel_fecha_certificacion',
            DB::raw('CONCAT(vendedores.nombres," ",vendedores.apellidos) as vendedor'),
            'us1.name as crea',
            'factura_maestro.created_at'
         )->join(
             'estados',
             'factura_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'series',
             'factura_maestro.serie_id',
             '=',
             'series.id'
        )->join(
            'factura_cliente',
            'factura_maestro.id',
            '=',
            'factura_cliente.factura_id'
        )->join(
             'clientes',
             'factura_maestro.cliente_id',
             '=',
             'clientes.id'
         )->join(
            'users as us1',
            'factura_maestro.user_id',
            '=',
            'us1.id'
         )->join(
            'vendedores',
            'clientes.vendedor_id',
            '=',
            'vendedores.id'
         )->join(
            'cotizacion_maestro',
            'factura_maestro.cotizacion_maestro_id',
            '=',
            'cotizacion_maestro.id'
         )->join(
            'series as ser1',
            'cotizacion_maestro.serie_id',
            '=',
            'ser1.id'
         )->join(
             'tipo_factura',
             'factura_maestro.tipo_factura_id',
             '=',
             'tipo_factura.id'
        )->where(
            'factura_maestro.estado_id',
            '<>',
            '3'
        )->where(
            'factura_maestro.id',
            '=',
            $factura_maestro->id
        )->get();


    }



        $facturadetalle = Factura_Detalle::select(
            'factura_detalle.id',
            'factura_detalle.cantidad',
            'factura_detalle.precio_unitario',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'factura_detalle.desc_articulo',
            'factura_detalle.subtotal'
        )->join(
            'articulos',
            'factura_detalle.articulo_id',
            '=',
            'articulos.id'
        )->where(
            'factura_detalle.factura_maestro_id',
            '=',
            $factura_maestro->id
        )->get();

        $formatter = new NumeroALetras;
        $nl = $formatter->toMoney($facturamaestro[0]->total - $facturamaestro[0]->descuento_porcentaje - $facturamaestro[0]->descuento_valores, 2, 'Quetzales', 'Centavos');

        $pdf = \PDF::loadView('admin.facturas.pdffacturacambiaria', compact('facturamaestro', 'facturadetalle', 'nl'));
        return $pdf->stream('facturacambiaria.pdf');
    }




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
    public function destroy(Factura_Maestro $factura_maestro, Request $request)
    {
        // $factura_maestro->estado_id = 4; TODO: Preguntar a Iver
        $factura_maestro->estado_id = 4;
        $fd = Factura_Detalle::Where('factura_maestro_id','=',$factura_maestro->id)->get();

        $filas = Count($fd);

        if($factura_maestro->tipo_factura_id == 2){
            $cl = Cliente::WHERE("id","=",$factura_maestro->cliente_id)->get();
            $cl[0]->saldo_actual = $cl[0]->saldo_actual - $factura_maestro->total ;
            $cl[0]->save();
        }

        for ($i=0; $i<$filas; $i++){

            $mb = Movimiento_Bodega::WHERE("producto_id","=",$fd[$i]->articulo_id)->get();
            $mb[0]->cantidad = $mb[0]->cantidad + $fd[$i]->cantidad;
            $mb[0]->save();

            $ex = Movimiento_Bodega::SELECT(DB::raw('SUM(cantidad) as existencia'))->WHERE("producto_id","=",$fd[$i]->articulo_id)->get();

            $art = Articulo::WHERE("id","=",$fd[$i]->articulo_id)->get();
            $art[0]->existencia = $ex[0]->existencia;
            $art[0]->save();

        }

        $factura_maestro->save();
        
        //Anular FEL
        if (is_null($factura_maestro->fel_uuid_anula)){
            $fel = new Fel();
            if(!$fel->anularFEL($factura_maestro->id, $factura_maestro->cliente_id)){
                return Response::json(['success' => 'Error-FEL']);
            }
        }

        event(new ActualizacionBitacora($factura_maestro->id, Auth::user()->id, 'Anulación', '', '', 'Factura'));

        return Response::json(['success' => 'Éxito']);
    }



    public function eliminar(Factura_Maestro $factura_maestro, Request $request)
    {

        $fd = Factura_Detalle::Where('factura_maestro_id','=',$factura_maestro->id)->get();

        $filas = Count($fd);

        if($factura_maestro->tipo_factura_id == 2){
            $cl = Cliente::WHERE("id","=",$factura_maestro->cliente_id)->get();
            $cl[0]->saldo_actual = $cl[0]->saldo_actual - $factura_maestro->total ;
            $cl[0]->save();
        }

        for ($i=0; $i<$filas; $i++){

            $mb = Movimiento_Bodega::WHERE("producto_id","=",$fd[$i]->articulo_id)->get();
            $mb[0]->cantidad = $mb[0]->cantidad + $fd[$i]->cantidad;
            $mb[0]->save();

            $ex = Movimiento_Bodega::SELECT(DB::raw('SUM(cantidad) as existencia'))->WHERE("producto_id","=",$fd[$i]->articulo_id)->get();

            $art = Articulo::WHERE("id","=",$fd[$i]->articulo_id)->get();
            $art[0]->existencia = $ex[0]->existencia;
            $art[0]->save();

        }

        event(new ActualizacionBitacora($factura_maestro->id, Auth::user()->id, 'Eliminación', '', '', 'Factura'));

        $factura_maestro->delete();

        return Response::json(['success' => 'Éxito']);
    }





    public function autorizar(Factura_Maestro $factura_maestro)
    {

        if ($factura_maestro->total = $factura_maestro->saldo){
            $factura_maestro->estado_pago_id = 1;
        }else{
            $factura_maestro->estado_pago_id = 2;
        }

        $factura_maestro->save();

        event(new ActualizacionBitacora($factura_maestro->id, Auth::user()->id, 'Autorizacion', '', '', 'Factura'));

        return Response::json(['success' => 'Éxito']);
    }


    public function getSerie($id){
        $api_result = Serie::Where("id","=",$id)->Where("estado_id","=",1)->get();

        return Response::json($api_result);
    }


    public function getCotizacion($serie_id, $num_coti){

        $api_result = Cotizacion_Maestro::select(
            'cotizacion_maestro.id',
            'cotizacion_maestro.cliente_id',
            'clientes.nombre_comercial',
            'clientes.nit',
            'clientes.descuento_autorizado',
            'cotizacion_maestro.transportado_por',
            'cotizacion_maestro.porcentaje',
            'cotizacion_maestro.descuento_valores',
            'cotizacion_maestro.total',
            'cotizacion_detalle.cantidad',
            'cotizacion_detalle.articulo_id',
            'cotizacion_detalle.desc_articulo',
            'cotizacion_detalle.precio_unitario',
            'cotizacion_detalle.subtotal'
        )->join(
            'clientes',
            'cotizacion_maestro.cliente_id',
            '=',
            'clientes.id'
        )->join(
            'cotizacion_detalle',
            'cotizacion_detalle.cotizacion_maestro_id',
            '=',
            'cotizacion_maestro.id'
        )->where(
            'cotizacion_maestro.estado_id',
            '=',
            '1'
        )->where(
            'cotizacion_maestro.serie_id',
            '=',
            $serie_id
        )->where(
            'cotizacion_maestro.correlativo_documento',
            '=',
            $num_coti
        )->get();

        return Response::json($api_result);
    }




}
