<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'id',
        'codigo',
        'tipo_persona_id',
        'nombre_comercial',
        'razon_social',
        'abreviatura',
        'nit',
        'prop_replegal',
        'direccion_comercial',
        'telefono',
        'nombre_contacto',
        'telefono_contacto',
        'correo_electronico',
        'lugar_entrega',
        'vendedor_id',
        'limite_credito',
        'saldo_actual',
        'dias_credito',
        'descuento_autorizado',
        'cuenta_contable',
        'fecha_ultima_venta',
        'retenedor_iva',
        'observaciones',
        'empresa_id',
        'estado_id',
        'user_id'
    ];
}
