<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Proveedor extends Model
{
    protected $table = 'tipo_proveedor';

    protected $fillable = [
        'id',
        'tipo_proveedor'
    ];
}
