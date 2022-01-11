<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento_Maestro extends Model
{
    protected $table = 'movimientos_maestro';

    protected $fillable = [
        'id',
        'serie_id',
        'correlativo_documento',
        'fecha_documento',
        'tipo_documento_id',
        'bodega_origen_id',
        'bodega_destino_id',
        'aplicacion',
        'cliente_id',
        'proveedor_id',
        'observaciones',
        'total',
        'empresa_id',
        'estado_id',
        'user_id'
    ];
}
