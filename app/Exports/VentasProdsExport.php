<?php

namespace App\Exports;

use App\Factura_Detalle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use DB;

class VentasProdsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */


    use Exportable;

    protected $fecha_inicial;
    protected $fecha_final;
    protected $articulo_inicial;
    protected $articulo_final;
    

    public function __construct($fecha_inicial = null, $fecha_final = null, $articulo_inicial = null, $articulo_final = null )
    {
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
        $this->articulo_inicial = $articulo_inicial;
        $this->articulo_final = $articulo_final;
    }



    public function view(): View
    {
        $fecha_inicial = $this->fecha_inicial;
        $fecha_final = $this->fecha_final;
        $articulo_inicial = $this->articulo_inicial;
        $articulo_final = $this->articulo_final;
    

        if (($articulo_inicial == "default") && ($articulo_final == "default"))
        {
            $ventas_prods = Factura_Detalle::select(
                'articulos.codigo_articulo',
                'articulos.descripcion',
                'articulos.codigo_articulo',
                'articulos.descripcion',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                'factura_detalle.cantidad',
                'factura_detalle.precio_unitario',
                'factura_detalle.subtotal',
                DB::raw('(factura_detalle.subtotal) as total')
            )->join(
                'factura_maestro',
                'factura_detalle.factura_maestro_id',
                '=',
                'factura_maestro.id'
            )->join(
                'articulos',
                'factura_detalle.articulo_id',
                '=',
                'articulos.id'
            )->join(
                 'series',
                 'factura_maestro.serie_id',
                 '=',
                 'series.id'
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc'
            )->orderBy(
                'articulos.codigo_articulo',
                'asc'            
            )->get();

           
        }
        elseif (($articulo_inicial !== "default") && ($articulo_final !== "default"))
        {
            $ventas_prods = Factura_Detalle::select(
                'articulos.codigo_articulo',
                'articulos.descripcion',
                'articulos.codigo_articulo',
                'articulos.descripcion',
                'series.serie',
                'factura_maestro.correlativo_documento',
                'factura_maestro.fecha_documento',
                'factura_detalle.cantidad',
                'factura_detalle.precio_unitario',
                'factura_detalle.subtotal',
                DB::raw('(factura_detalle.subtotal) as total')
            )->join(
                'factura_maestro',
                'factura_detalle.factura_maestro_id',
                '=',
                'factura_maestro.id'
            )->join(
                'articulos',
                'factura_detalle.articulo_id',
                '=',
                'articulos.id'
            )->join(
                 'series',
                 'factura_maestro.serie_id',
                 '=',
                 'series.id'
            )->whereBetween(
                 'factura_maestro.fecha_documento',
                 [ $fecha_inicial, $fecha_final ]  
            )->orderBy(
                 'factura_maestro.fecha_documento',
                 'asc'    
            )->orderBy(
                 'articulos.codigo_articulo',
                 'asc'        
            )->get();

           
        }

        
        return view('admin.reportes.rpt_ventas_prods', compact('ventas_prods','fecha_inicial','fecha_final'));

    }
}
