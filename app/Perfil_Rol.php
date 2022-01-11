<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil_Rol extends Model
{
    protected $table = 'perfil_roles';

    protected $fillable = [
        'id',
        'perfil_id',
        'rol_id',
        'user_asigna_id',
        'estado_id'
    ];
}
