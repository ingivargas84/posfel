<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abono_Detalle extends Model
{
    protected $table = 'abono_detalle';

    protected $fillable = [
        'id',
        'abono_maestro_id',
        'factura_maestro_id',
        'descripcion',
        'total_factura',
        'abono',
        'saldo'
    ];
}

