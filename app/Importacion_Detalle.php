<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Importacion_Detalle extends Model
{
    protected $table = 'importaciones_detalle';

    protected $fillable = [
        'id',
        'importacion_maestro_id',
        'cantidad',
        'articulo_id',
        'fob',
        'subtotal'
    ];
}
