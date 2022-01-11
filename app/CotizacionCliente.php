<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotizacionCliente extends Model
{
    protected $table = 'cotizacion_cliente';

    protected $fillable = [
        'id',
        'nit',
        'nombre',
        'direccion',
        'cotizacion_id'
    ];
}
