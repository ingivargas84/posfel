<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden_Compra_Detalle extends Model
{
    protected $table = 'orden_compra_detalle';

    protected $fillable = [
        'id',
        'orden_compra_maestro_id',
        'cantidad',
        'articulo_id',
        'desc_articulo',
        'precio_unitario',
        'subtotal'
    ];
}
