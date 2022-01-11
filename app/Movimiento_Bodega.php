<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento_Bodega extends Model
{
    protected $table = 'movimientos_bodegas';

    protected $fillable = [
        'id',
        'producto_id',
        'bodega_id',
        'tipo_movimiento',
        'cantidad',
        'movimiento_detalle_id'
    ];
}
