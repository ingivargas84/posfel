<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Transporte extends Model
{
    protected $table = 'tipo_transporte';

    protected $fillable = [
        'id',
        'tipo_transporte'
    ];
}
