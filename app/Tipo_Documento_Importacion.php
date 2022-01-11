<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Documento_Importacion extends Model
{
    protected $table = 'tipo_documento_importacion';

    protected $fillable = [
        'id',
        'tipo_documento_importacion'
    ];
}
