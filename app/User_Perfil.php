<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Perfil extends Model
{
    protected $table = 'user_perfil';

    protected $fillable = [
        'id',
        'user_id',
        'perfil_id',
        'empresa_id',
        'user_asigna_id',
        'estado_id'
    ];
}
