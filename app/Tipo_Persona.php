<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Persona extends Model
{
    protected $table = 'tipo_persona';

    protected $fillable = [
        'id',
        'descripcion'
    ];
}
