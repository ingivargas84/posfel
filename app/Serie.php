<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'id',
        'serie',
        'fecha_vencimiento',
        'documento_id',
        'correlativo',
        'empresa_id',
        'estado_id',
        'user_id'
    ];
}
