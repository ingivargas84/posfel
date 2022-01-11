<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';

    protected $fillable = [
        'id',
        'codigo',
        'tipo_persona_id',
        'nombre_comercial',
        'razon_social',
        'abreviatura',
        'nit',
        'num_patronal_igss',
        'direccion_comercial',
        'direccion_fiscal',
        'prop_replegal',
        'nit_prop_replegal',
        'nombre_contador',
        'nit_contador',
        'user_id',
        'estado_id'
    ];
}
