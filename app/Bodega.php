<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    protected $table = 'bodegas';

    protected $fillable = [
        'id',
        'codigo',
        'descripcion',
        'user_id',
        'empresa_id',
        'estado_id'
    ];
}
