<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnulaFactura extends Model
{
    protected $table = 'anula_factura';

    protected $fillable = [
        'id',
        'factura_maestro_id',
        'razon_anulacion',
        'user_id'
    ];
}
