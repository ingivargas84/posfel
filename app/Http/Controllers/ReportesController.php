<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Serie;
use App\Vendedor;
use App\Cliente;
use App\Bodega;
use App\Articulo;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Exports\FacEmitidasExport;
use App\Exports\LibroVentasExport;
use App\Exports\ValInventarioExport;
use App\Exports\VentasProdsExport;
use App\Exports\AntSaldos;
use Illuminate\Support\Facades\Auth;

class REportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        //
    }


    public function fac_emitidas()
    {
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 3)->get();
        $clientes = Cliente::WHERE("estado_id","=", 1)->get();
        $vendedores = Vendedor::WHERE("id",">",1)->get();

        return view('admin.reportes.fac_emitidas', compact('series','clientes','vendedores'));
    }


    public function rpt_fac_emitidas(Request $request)
    {
        $clientes = $request->cliente_id;
        $vendedores = $request->vendedor_id;
        $series = $request->serie_id;
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");


        return Excel::download(new FacEmitidasExport($clientes, $vendedores, $series, $fecha_inicial, $fecha_final), 'Facturas_Emitidas.xlsx');
    }

    
    
    public function lib_ventas()
    {
        $series = Serie::WHERE("estado_id","=", 1)->WHERE("documento_id","=", 3)->get();

        return view('admin.reportes.lib_ventas', compact('series'));
    }


    public function rpt_lib_ventas(Request $request)
    {
        $series = $request->serie_id;
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");
        $folios = $request->folio;

        return Excel::download(new LibroVentasExport($folios, $series, $fecha_inicial, $fecha_final), 'Libro_Ventas.xlsx');
    }


    public function val_inventario()
    {
        $bodegas = Bodega::WHERE("estado_id","=", 1)->get();
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();

        return view('admin.reportes.val_inventario', compact('bodegas','articulos'));
    }


    public function rpt_val_inventario(Request $request)
    {
        $bodegas = $request->bodega_id;
        $articulo_inicial = $request->articulo_inicial;
        $articulo_final = $request->articulo_final;

        return Excel::download(new ValInventarioExport($bodegas, $articulo_inicial, $articulo_final), 'Val_Inventario.xlsx');
    }



    public function ventas_prods()
    {
        $articulos = Articulo::WHERE("estado_id","=", 1)->get();

        return view('admin.reportes.ventas_prods', compact('articulos'));
    }



    public function rpt_ventas_prods(Request $request)
    {
        
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");
        $articulo_inicial = $request->articulo_inicial;
        $articulo_final = $request->articulo_final;

        return Excel::download(new VentasProdsExport($fecha_inicial, $fecha_final, $articulo_inicial, $articulo_final), 'Ventas_Productos.xlsx');
    }



    public function ant_saldos()
    {
        $clientes = Cliente::WHERE("estado_id","=", 1)->Where("id",">",0)->get();
        $vendedores = Vendedor::WHERE("id",">",1)->get();

        return view('admin.reportes.ant_saldos', compact('clientes','vendedores'));
    }


    public function rpt_ant_saldos(Request $request)
    {
        
        $fecha_inicial = date_format(date_create($request->fecha_inicial), "Y/m/d");
        $fecha_final = date_format(date_create($request->fecha_final), "Y/m/d");
        $clientes = $request->cliente_id;
        $vendedores = $request->vendedor_id;

        return Excel::download(new AntSaldos($fecha_inicial, $fecha_final, $clientes, $vendedores), 'Antiguedad_Saldos.xlsx');
    }



    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
