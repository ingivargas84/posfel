<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoPago extends Model
{
    protected $table = 'estado_pago';

    protected $fillable = [
        'id',
        'estado_pago'
    ];
}
