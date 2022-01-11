<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden_Compra_Maestro extends Model
{
    protected $table = 'orden_compra_maestro';

    protected $fillable = [
        'id',
        'serie_id',
        'correlativo_documento',
        'fecha_documento',
        'tipo_documento_importacion_id',
        'proveedor_id',
        'atencion_a',
        'tipo_pago_id',
        'solicito',
        'lugar_entrega',
        'fecha_entrega',
        'observaciones',
        'autoriza_id',
        'total',
        'empresa_id',
        'estado_id',
        'user_id'
    ];
}
