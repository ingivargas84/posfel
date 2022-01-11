<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'id',
        'codigo',
        'descripcion',
        'tipo_documento_id',
        'aplicacion',
        'costea',
        'imprime',
        'empresa_id',
        'user_id',
        'estado_id'
    ];
}