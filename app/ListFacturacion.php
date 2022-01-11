<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListFacturacion extends Model
{
    protected $table = 'listfacturacion';

    protected $fillable = [
        'id',
        'tipo_factura',
        'ubicacion',
        'fecha',
        'estado_id',
        'user_id'
    ];
}
