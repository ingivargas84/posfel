<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFactura extends Model
{
    protected $table = 'tipo_factura';

    protected $fillable = [
        'id',
        'tipo_factura'
    ];
}
