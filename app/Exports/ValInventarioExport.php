<?php

namespace App\Exports;

use App\Articulo;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use DB;

class ValInventarioExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */


    use Exportable;

    protected $bodegas;
    protected $articulo_inicial;
    protected $articulo_final;

    public function __construct($bodegas = null, $articulo_inicial = null, $articulo_final = null)
    {
        $this->bodegas = $bodegas;
        $this->articulo_inicial = $articulo_inicial;
        $this->articulo_final = $articulo_final;

    }


    public function view(): View
    {
        $bodegas = $this->bodegas;
        $articulo_inicial = $this->articulo_inicial;
        $articulo_final = $this->articulo_final;

        if (($bodegas == "default") && ($articulo_inicial == "default") && ($articulo_final == "default"))
        {
            $val_inventario = Articulo::select(
                'articulos.id',
                'articulos.codigo_articulo as codigo',
                'articulos.descripcion',
                'articulos.existencia',
                'articulos.costo_promedio_quetzales as costo_promedio',
                DB::raw('(articulos.existencia * articulos.costo_promedio_quetzales) as total')
            )->orderBy(
                 'articulos.id',
                 'asc'            
            )->get();

            $totales = Articulo::select(
                DB::raw('SUM(articulos.existencia * articulos.costo_promedio_quetzales) as total')
            )->get();


        }
        elseif (($bodegas !== "default") && ($articulo_inicial == "default") && ($articulo_final == "default"))
        {
            $val_inventario = Articulo::select(
                'articulos.id',
                'articulos.codigo_articulo as codigo',
                'articulos.descripcion',
                'movimientos_bodegas.cantidad as existencia',
                'articulos.costo_promedio_quetzales as costo_promedio',
                DB::raw('(movimientos_bodegas.cantidad * articulos.costo_promedio_quetzales) as total')
            )->join(
                'movimientos_bodegas',
                'articulos.id',
                '=',
                'movimientos_bodegas.producto_id'
            )->where(
                'movimientos_bodegas.bodega_id',
                '=',
                $bodegas
            )->orderBy(
                 'articulos.id',
                 'asc'            
            )->get();

            $totales = Articulo::select(
                DB::raw('SUM(movimientos_bodegas.cantidad * articulos.costo_promedio_quetzales) as total')
            )->join(
                'movimientos_bodegas',
                'articulos.id',
                '=',
                'movimientos_bodegas.producto_id'
            )->where(
                'movimientos_bodegas.bodega_id',
                '=',
                $bodegas
            )->get();


        }
        elseif (($bodegas == "default") && ($articulo_inicial !== "default") && ($articulo_final !== "default"))
        {
            $val_inventario = Articulo::select(
                'articulos.id',
                'articulos.codigo_articulo as codigo',
                'articulos.descripcion',
                'articulos.existencia',
                'articulos.costo_promedio_quetzales as costo_promedio',
                DB::raw('(articulos.existencia * articulos.costo_promedio_quetzales) as total')
            )->whereBetween(
                'articulos.id',
                [ $articulo_inicial, $articulo_final ] 
            )->orderBy(
                 'articulos.id',
                 'asc'            
            )->get();


            $totales = Articulo::select(
                DB::raw('SUM(articulos.existencia * articulos.costo_promedio_quetzales) as total')
            )->whereBetween(
                'articulos.id',
                [ $articulo_inicial, $articulo_final ] 
            )->get();


        }
        elseif (($bodegas !== "default") && ($articulo_inicial !== "default") && ($articulo_final !== "default"))
        {
            $val_inventario = Articulo::select(
                'articulos.id',
                'articulos.codigo_articulo as codigo',
                'articulos.descripcion',
                'movimientos_bodegas.cantidad as existencia',
                'articulos.costo_promedio_quetzales as costo_promedio',
                DB::raw('(movimientos_bodegas.cantidad * articulos.costo_promedio_quetzales) as total')
            )->join(
                'movimientos_bodegas',
                'articulos.id',
                '=',
                'movimientos_bodegas.producto_id'
            )->whereBetween(
                'articulos.id',
                [ $articulo_inicial, $articulo_final ] 
            )->where(
                'movimientos_bodegas.bodega_id',
                '=',
                $bodegas
            )->orderBy(
                 'articulos.id',
                 'asc'            
            )->get();

            $totales = Articulo::select(
                DB::raw('SUM(movimientos_bodegas.cantidad * articulos.costo_promedio_quetzales) as total')
            )->join(
                'movimientos_bodegas',
                'articulos.id',
                '=',
                'movimientos_bodegas.producto_id'
            )->whereBetween(
                'articulos.id',
                [ $articulo_inicial, $articulo_final ] 
            )->where(
                'movimientos_bodegas.bodega_id',
                '=',
                $bodegas
            )->get();


        }



        return view('admin.reportes.rpt_val_inventario', compact('val_inventario', 'totales'));


    }
}
