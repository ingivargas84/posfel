<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento_Detalle extends Model
{
    protected $table = 'movimientos_detalle';

    protected $fillable = [
        'id',
        'movimiento_maestro_id',
        'cantidad',
        'articulo_id',
        'desc_articulo',
        'precio_unitario',
        'subtotal',
        'estado_id',
        'user_id'
    ];
}
