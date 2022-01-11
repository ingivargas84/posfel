<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura_Maestro extends Model
{
    protected $table = 'factura_maestro';

    protected $fillable = [
        'id',
        'serie_id',
        'correlativo_documento',
        'fecha_documento',
        'tipo_factura_id',
        'cliente_id',
        'exenta',
        'orden_compra',
        'envios',
        'cotizacion_maestro_id',
        'transportado_por',
        'porcentaje',
        'descuento_porcentaje',
        'descuento_valores',
        'total',
        'total_pagado',
        'saldo',
        'fel_errores',
        'fel_xml',
        'fel_numero',
        'fel_serie',
        'fel_uuid',
        'fel_fecha_certificacion',
        'fel_errores_anula',
        'fel_xml_anula',
        'fel_numero_anula',
        'fel_serie_anula',
        'fel_uuid_anula',
        'fel_fecha_certificacion_anula',
        'empresa_id',
        'estado_pago_id',
        'estado_id',
        'user_id'
    ];
}