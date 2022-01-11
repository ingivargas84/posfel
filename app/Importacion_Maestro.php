<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Importacion_Maestro extends Model
{
    protected $table = 'importaciones_maestro';

    protected $fillable = [
        'id',
        'no_hoja',
        'no_pedido',
        'orden_compra_id',
        'proveedor_id',
        'fecha',
        'poliza',
        'no_factura',
        'tipo_mercaderia',
        'tipo_transporte_id',
        'valor_fob',
        'costo_transporte',
        'consular_fees',
        'bl_pc',
        'insurance',
        'others',
        'handling_and_po',
        'total_cif',
        'tasa_cambio',
        'quetzalizacion',
        'd_arancelarios_imp',
        'multas',
        'almacenaje_algesa',
        'marchamo',
        'muellaje',
        'fumigacion',
        'm_documentacion',
        'tram_al',
        'hono_aa',
        'formulario',
        'fl_i_a_v',
        'fl_i_c_v',
        'fl_ch_bv',
        'd_monta',
        'viaticos',   
        'otros',
        'costo_pbod',
        'fac_costeo',
        'total',
        'empresa_id',
        'estado_id',
        'user_id'
    ];
}
