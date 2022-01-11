<?php

namespace App\Exports;

use App\Factura_Maestro;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use DB;

class LibroVentasExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */


    use Exportable;

    protected $folios;
    protected $series;
    protected $fecha_inicial;
    protected $fecha_final;

    public function __construct($folios = null, $series = null, $fecha_inicial = null, $fecha_final = null)
    {
        $this->folios = $folios;
        $this->series = $series;
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
    }



    public function view(): View
    {
        $folios = $this->folios;
        $series = $this->series;
        $fecha_inicial = $this->fecha_inicial;
        $fecha_final = $this->fecha_final;


        if ($series == "default")
        {
            $lib_ventas = Factura_Maestro::select(
                'series.serie',
                DB::raw('MIN(factura_maestro.correlativo_documento) as num_inicial'),
                DB::raw('MAX(factura_maestro.correlativo_documento) as num_final'),
                'factura_maestro.fecha_documento',
                DB::raw('SUM(factura_maestro.total / 1.12) as subtotal'),
                DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
                DB::raw('SUM(factura_maestro.total) as total')
            )->join(
                 'series',
                 'factura_maestro.serie_id',
                 '=',
                 'series.id'
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->groupBy(
                 'series.serie',
                 'factura_maestro.fecha_documento'
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc' 
            )->orderBy(
                 'series.serie',
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


            $documentos = Factura_Maestro::select(
                'series.serie',
                DB::raw('COUNT(factura_maestro.serie_id) as tot_serie')
            )->join(
                'series',
                'factura_maestro.serie_id',
                '=',
                'series.id'
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->groupBy(
                 'series.serie',
            )->get();



            $tot_serie = Factura_Maestro::select(
                DB::raw('COUNT(factura_maestro.serie_id) as total')
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->get();


        }
        elseif ($series !== "default")
        {
            
            $lib_ventas = Factura_Maestro::select(
                'series.serie',
                DB::raw('MIN(factura_maestro.correlativo_documento) as num_inicial'),
                DB::raw('MAX(factura_maestro.correlativo_documento) as num_final'),
                'factura_maestro.fecha_documento',
                DB::raw('SUM(factura_maestro.total / 1.12) as subtotal'),
                DB::raw('SUM(factura_maestro.total - (factura_maestro.total / 1.12)) as iva'),
                DB::raw('SUM(factura_maestro.total) as total')
            )->join(
                 'series',
                 'factura_maestro.serie_id',
                 '=',
                 'series.id'
            )->where(
                 'factura_maestro.serie_id',
                 '=',
                 $series
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->groupBy(
                 'series.serie',
                 'factura_maestro.fecha_documento'
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc' 
            )->orderBy(
                 'series.serie',
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



            $documentos = Factura_Maestro::select(
                'series.serie',
                DB::raw('COUNT(factura_maestro.serie_id) as tot_serie')
            )->join(
                'series',
                'factura_maestro.serie_id',
                '=',
                'series.id'
            )->where(
                'factura_maestro.serie_id',
                '=',
                $series
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->groupBy(
                 'series.serie',
            )->get();


            $tot_serie = Factura_Maestro::select(
                DB::raw('COUNT(factura_maestro.serie_id) as total')
            )->where(
                'factura_maestro.serie_id',
                '=',
                $series
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->get();


        }


        return view('admin.reportes.rpt_lib_ventas', compact('lib_ventas','fecha_inicial','fecha_final','totales','folios','documentos','tot_serie'));



    }
}
