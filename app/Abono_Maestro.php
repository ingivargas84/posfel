<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abono_Maestro extends Model
{
    protected $table = 'abono_maestro';

    protected $fillable = [
        'id',
        'tipo_abono_id',
        'serie_id',
        'correlativo_documento',
        'fecha_documento',
        'autorizacion_sat',
        'cliente_id',
        'concepto',
        'total',
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
        'estado_id',
        'user_id'
    ];
}