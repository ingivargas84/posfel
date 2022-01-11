<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoCuentaCliente extends Model
{
    protected $table = 'estado_cuenta_cliente';

    protected $fillable = [
        'id',
        'cliente_id',
        'factura_maestro_id',
        'monto',
        'abono',
        'saldo'
    ];
}

