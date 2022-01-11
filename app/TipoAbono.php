<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAbono extends Model
{
    protected $table = 'tipo_abono';

    protected $fillable = [
        'id',
        'tipo_abono'
    ];
}
