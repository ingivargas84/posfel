<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion_Maestro extends Model
{
    protected $table = 'cotizacion_maestro';

    protected $fillable = [
        'id',
        'serie_id',
        'correlativo_documento',
        'fecha_documento',
        'cliente_id',
        'anotaciones',
        'referencia',
        'observaciones',
        'tipo_pago_id',
        'exenta',
        'tiempo_entrega',
        'validez_oferta',
        'transportado_por',
        'lugar_entrega',
        'atencion_a',
        'porcentaje',
        'descuento_porcentaje',
        'descuento_valores',
        'total',
        'empresa_id',
        'estado_id',
        'user_id'
    ];
}