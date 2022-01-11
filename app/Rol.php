<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';

    protected $fillable = [
        'id',
        'codigo',
        'descripcion',
        'user_id',
        'estado_id'
    ];
}
