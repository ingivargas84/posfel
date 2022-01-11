<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulos';

    protected $fillable = [
        'id',
        'codigo_articulo',
        'codigo_alterno',
        'descripcion',
        'proveedor_id',
        'costo_fob',
        'costo_dolares',
        'costo_quetzales',
        'costo_promedio_quetzales',
        'ultimo_costo',
        'primer_costo',
        'precio_quetzales',
        'precio_dolares',
        'ultimo_precio',
        'existencia',
        'cantidad_pedida',
        'cantidad_minima',
        'cantidad_maxima',
        'fecha_ultima_compra',
        'fecha_ultima_venta',
        'localizacion',
        'bodega_id',
        'almacenadora',
        'observaciones',
        'empresa_id',
        'user_id',
        'estado_id'
    ];
}