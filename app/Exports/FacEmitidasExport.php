<?php

namespace App\Exports;

use App\Factura_Maestro;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use DB;


class FacEmitidasExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */


    use Exportable;

    protected $clientes;
    protected $vendedores;
    protected $series;
    protected $fecha_inicial;
    protected $fecha_final;

    public function __construct($clientes = null, $vendedores = null, $series = null, $fecha_inicial = null, $fecha_final = null)
    {
        $this->clientes = $clientes;
        $this->vendedores = $vendedores;
        $this->series = $series;
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;

    }


    public function view(): View
    {
        $clientes = $this->clientes;
        $vendedores = $this->vendedores;
        $series = $this->series;
        $fecha_inicial = $this->fecha_inicial;
        $fecha_final = $this->fecha_final;

        if (($clientes == "default") && ($vendedores == "default") && ($series == "default"))
        {
            $fac_emitidas = Factura_Maestro::select(
                'factura_maestro.id',
                'factura_maestro.serie_id',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nit,clientes.codigo) as cod_cliente'),
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nombre,clientes.nombre_comercial) as cliente'),
                'factura_maestro.fel_uuid',
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total / 1.12) as subtotal'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total) as total')
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
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc'            
            )->get();

            
            $totales = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal'),
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
               DB::raw('SUM(factura_maestro.total) as total')
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_subtotal = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_iva = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();


            $anuladas_total = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();

        }
        elseif(($clientes !== "default") && ($vendedores == "default") && ($series == "default"))
        {
            $fac_emitidas = Factura_Maestro::select(
                'factura_maestro.id',
                'factura_maestro.serie_id',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nit,clientes.codigo) as cod_cliente'),
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nombre,clientes.nombre_comercial) as cliente'),
                'factura_maestro.fel_uuid',
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total / 1.12) as subtotal'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total) as total')
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
            )->where(
                 'factura_maestro.cliente_id',
                 '=',
                 $clientes
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc'          
            )->get();



            $totales = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal'),
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_subtotal = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_iva = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_total = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();


        }
        elseif(($clientes == "default") && ($vendedores == "default") && ($series !== "default"))
        {

            $fac_emitidas = Factura_Maestro::select(
                'factura_maestro.id',
                'factura_maestro.serie_id',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nit,clientes.codigo) as cod_cliente'),
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nombre,clientes.nombre_comercial) as cliente'),
                'factura_maestro.fel_uuid',
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total / 1.12) as subtotal'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total) as total')
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
            )->where(
                 'factura_maestro.serie_id',
                 '=',
                 $series
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]       
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc'     
            )->get();

            
            

            $totales = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal'),
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_subtotal = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_iva = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_total = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();

        }
        elseif(($clientes !== "default") && ($vendedores == "default") && ($series !== "default"))
        {

            $fac_emitidas = Factura_Maestro::select(
                'factura_maestro.id',
                'factura_maestro.serie_id',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nit,clientes.codigo) as cod_cliente'),
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nombre,clientes.nombre_comercial) as cliente'),
                'factura_maestro.fel_uuid',
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total / 1.12) as subtotal'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total) as total')
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
            )->where(
                 'factura_maestro.serie_id',
                 '=',
                 $series
            )->where(
                 'factura_maestro.cliente_id',
                 '=',
                 $clientes
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]    
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc'        
            )->get();


            $totales = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal'),
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_subtotal = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
           )->where(
               'factura_maestro.serie_id',
               '=',
               $series
           )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_iva = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_total = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();

        }
        elseif(($clientes == "default") && ($vendedores !== "default") && ($series == "default"))
        {

            $fac_emitidas = Factura_Maestro::select(
                'factura_maestro.id',
                'factura_maestro.serie_id',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nit,clientes.codigo) as cod_cliente'),
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nombre,clientes.nombre_comercial) as cliente'),
                'factura_maestro.fel_uuid',
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total / 1.12) as subtotal'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total) as total')
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
            )->where(
                 'clientes.vendedor_id',
                 '=',
                 $vendedores
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc'          
            )->get();


            $totales = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal'),
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
               DB::raw('SUM(factura_maestro.total) as total')
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();


            $anuladas_subtotal = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_iva = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_total = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();

           

        }
        elseif(($clientes !== "default") && ($vendedores !== "default") && ($series == "default"))
        {

            $fac_emitidas = Factura_Maestro::select(
                'factura_maestro.id',
                'factura_maestro.serie_id',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nit,clientes.codigo) as cod_cliente'),
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nombre,clientes.nombre_comercial) as cliente'),
                'factura_maestro.fel_uuid',
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total / 1.12) as subtotal'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total) as total')
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
            )->where(
                 'clientes.vendedor_id',
                 '=',
                 $vendedores
            )->where(
                 'factura_maestro.cliente_id',
                 '=',
                 $clientes
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]     
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc'       
            )->get();


           

            $totales = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal'),
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
               DB::raw('SUM(factura_maestro.total) as total')
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();


            $anuladas_subtotal = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_iva = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_total = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();

        }
        elseif(($clientes == "default") && ($vendedores !== "default") && ($series !== "default"))
        {

            $fac_emitidas = Factura_Maestro::select(
                'factura_maestro.id',
                'factura_maestro.serie_id',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nit,clientes.codigo) as cod_cliente'),
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nombre,clientes.nombre_comercial) as cliente'),
                'factura_maestro.fel_uuid',
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total / 1.12) as subtotal'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total) as total')
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
            )->where(
                 'clientes.vendedor_id',
                 '=',
                 $vendedores
            )->where(
                 'factura_maestro.serie_id',
                 '=',
                 $series
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]   
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc'         
            )->get();


            $totales = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal'),
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
               DB::raw('SUM(factura_maestro.total) as total')
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();


            $anuladas_subtotal = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_iva = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_total = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();


        }
        elseif(($clientes !== "default") && ($vendedores !== "default") && ($series !== "default"))
        {

            $fac_emitidas = Factura_Maestro::select(
                'factura_maestro.id',
                'factura_maestro.serie_id',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nit,clientes.codigo) as cod_cliente'),
                DB::raw('if(factura_maestro.cliente_id = 0,factura_cliente.nombre,clientes.nombre_comercial) as cliente'),
                'factura_maestro.fel_uuid',
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total / 1.12) as subtotal'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
                DB::raw('if(factura_maestro.estado_id = 4,0,factura_maestro.total) as total')
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
            )->where(
                 'clientes.vendedor_id',
                 '=',
                 $vendedores
            )->where(
                 'factura_maestro.serie_id',
                 '=',
                 $series
            )->where(
                 'factura_maestro.cliente_id',
                 '=',
                 $clientes
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc'          
            )->get();


            $totales = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal'),
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
               DB::raw('SUM(factura_maestro.total) as total')
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();


            $anuladas_subtotal = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total / 1.12) as subtotal')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_iva = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();



            $anuladas_total = Factura_Maestro::select(
               DB::raw('SUM(factura_maestro.total) as total')
            )->where(
               'factura_maestro.estado_id',
               '=',
                4
            )->join(
               'clientes',
               'factura_maestro.cliente_id',
               '=',
               'clientes.id'
            )->where(
               'clientes.vendedor_id',
               '=',
               $vendedores
            )->where(
               'factura_maestro.serie_id',
               '=',
               $series
            )->where(
               'factura_maestro.cliente_id',
               '=',
               $clientes
            )->whereBetween(
               'factura_maestro.fecha_documento',
               [ $fecha_inicial, $fecha_final ]  
            )->get();

        }


        return view('admin.reportes.rpt_fac_emitidas', compact('fac_emitidas','fecha_inicial','fecha_final','totales','anuladas_subtotal','anuladas_iva','anuladas_total'));
    }
}
