<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';

    protected $fillable = [
        'id',
        'codigo',
        'nombres',
        'apellidos',
        'dpi',
        'puesto',
        'direccion',
        'fecha_ingreso',
        'porcentaje_comision',
        'user_asignado_id',
        'empresa_id',
        'estado_id',
        'user_id'
    ];
}