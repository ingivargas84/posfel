<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Documento extends Model
{
    protected $table = 'tipo_documento';

    protected $fillable = [
        'id',
        'tipo_documento'
    ];
}
