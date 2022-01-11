<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'id',
        'codigo',
        'tipo_proveedor_id',
        'nombre_comercial',
        'razon_social',
        'abreviatura',
        'prop_replegal',
        'nit',
        'direccion_comercial',
        'telefono',
        'correo_electronico',
        'dias_credito',
        'cuenta_contable',
        'contacto',
        'telefono_contacto',
        'isr',
        'fecha_ultima_compra',
        'observaciones',
        'empresa_id',
        'estado_id',
        'user_id'
    ];
}
