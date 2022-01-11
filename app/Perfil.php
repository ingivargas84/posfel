<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfiles';

    protected $fillable = [
        'id',
        'codigo',
        'descripcion',
        'user_id',
        'estado_id'
    ];
}
