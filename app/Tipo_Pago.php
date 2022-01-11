<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Pago extends Model
{
    protected $table = 'tipo_pago';

    protected $fillable = [
        'id',
        'tipo_pago'
    ];
}
