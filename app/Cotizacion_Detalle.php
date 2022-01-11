<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion_Detalle extends Model
{
    protected $table = 'cotizacion_detalle';

    protected $fillable = [
        'id',
        'cotizacion_maestro_id',
        'cantidad',
        'articulo_id',
        'desc_articulo',
        'precio_unitario',
        'subtotal'
    ];
}
