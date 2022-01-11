<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaCliente extends Model
{
    protected $table = 'factura_cliente';

    protected $fillable = [
        'id',
        'nit',
        'nombre',
        'direccion',
        'factura_id'
    ];
}
