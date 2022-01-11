<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura_Detalle extends Model
{
    protected $table = 'factura_detalle';

    protected $fillable = [
        'id',
        'factura_maestro_id',
        'cantidad',
        'articulo_id',
        'desc_articulo',
        'precio_unitario',
        'subtotal'
    ];
}
