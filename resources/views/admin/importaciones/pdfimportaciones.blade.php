<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Importaciones</title>
    <link rel="stylesheet" type="text/css" href="/public/style.css">
    <style>
        .table {
            width: 700px;
            height: auto;
        }
        th {
            background-color: gray;
            color: white;
        }
        table {
            border-collapse: collapse;
            border: 0px solid black;
        }
                
    </style>
</head>
<body>
    <div class="container">
       <div class="row">
        <div class="col-md-12">
        <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:20px; text-align:left;" width="50%"> <strong>SUPLISA</strong> </td>
                    <td style="font-size:20px; text-align:right;" width="50%"> <strong>IMPORTACIÓN</strong> </td>
                </tr>
                <tr>
                    <td style="font-size:13px; text-align:center;" colspan=2> <strong>HOJA DE GASTOS SOBRE COMPRAS DE IMPORTACIÓN</strong> </td>
                </tr>
            </table>
            <hr>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> CORRELATIVO No: </strong> {{{ $imp_maestro[0]->no_hoja }}} </td>
                    <td style="font-size:15px;" width="50%"> <strong> PEDIDO NUMERO: </strong> {{{ $imp_maestro[0]->no_pedido }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> ORDEN DE COMPRA: </strong> {{{ $imp_maestro[0]->orden_compra_id }}} </td>
                    <td style="font-size:15px;" width="50%"> <strong> FECHA DE INGRESO: </strong> {{{ $imp_maestro[0]->fecha }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> POLIZA NUMERO: </strong> {{{ $imp_maestro[0]->poliza }}} </td>
                    <td style="font-size:15px;" width="50%"> <strong> FACTURA NÚMERO: </strong> {{{ $imp_maestro[0]->no_factura }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> PROVEEDOR: </strong> {{{ $imp_maestro[0]->proveedor }}} </td>
                    <td style="font-size:15px; text-align:right;" width="50%">  </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> TIPO DE MERCADERIA: </strong> {{{ $imp_maestro[0]->tipo_mercaderia }}} </td>
                    <td style="font-size:15px; text-align:right;" width="50%">  </td>
                </tr>
            </table>
            <hr>
            <h3>DESCRIPCIÓN DE LOS GASTOS CIF</h3>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> VALOR FOB: </strong>$ {{{number_format((float) $imp_maestro[0]->valor_fob, 2) }}} </td>
                    <td style="font-size:15px;" width="50%"> <strong> INSURANCE: </strong>$ {{{number_format((float) $imp_maestro[0]->insurance, 2) }}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> INLAND FREIGHT: </strong>$ {{{number_format((float) $imp_maestro[0]->costo_transporte, 2) }}} </td>
                    <td style="font-size:15px;" width="50%"> <strong> OTHERS: </strong>$ {{{number_format((float) $imp_maestro[0]->others, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> CONSULAR FEES: </strong>$ {{{number_format((float) $imp_maestro[0]->consular_fees, 2) }}}</td>
                    <td style="font-size:15px;" width="50%"> <strong> HANDLING AND PO: </strong>$ {{{number_format((float) $imp_maestro[0]->handling_and_po, 2) }}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> BL/PC: </strong>$ {{{number_format((float) $imp_maestro[0]->bl_pc, 2) }}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%">  </td>
                </tr>
            </table>
            <hr>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> TOTAL CIF: </strong>$ {{{number_format((float) $imp_maestro[0]->total_cif, 2) }}} </td>
                    <td style="font-size:15px; text-align:right;" width="50%">  </td>
                </tr>
            </table>
            <hr>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> TASA DE CAMBIO: </strong>Q {{{number_format((float) $imp_maestro[0]->tasa_cambio, 2) }}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> QUETZALIZACIÓN: </strong>Q {{{number_format((float) $imp_maestro[0]->quetzalizacion, 2) }}}</td>
                </tr>
            </table>
           <hr>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> DERECHOS ARANCELARIOS: </strong>Q. {{{number_format((float) $imp_maestro[0]->d_arancelarios_imp, 2) }}} </td>
                    <td style="font-size:15px;" width="50%"> <strong> HONORARIOS AGENTE DE ADUANA: </strong>Q. {{{number_format((float) $imp_maestro[0]->hono_aa, 2) }}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> MULTAS: </strong>Q. {{{number_format((float) $imp_maestro[0]->multas, 2) }}}</td>
                    <td style="font-size:15px;" width="50%"> <strong> FORMULARIOS: </strong>Q. {{{number_format((float) $imp_maestro[0]->formulario, 2) }}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> ALMACENAJE: </strong>Q. {{{number_format((float) $imp_maestro[0]->almacenaje, 2) }}}</td>
                    <td style="font-size:15px;" width="50%"> <strong> FLETE INTERNO: </strong>Q. {{{number_format((float) $imp_maestro[0]->fl_i_av, 2) }}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> MARCHAMO: </strong>Q. {{{number_format((float) $imp_maestro[0]->bl_pc, 2) }}}</td>
                    <td style="font-size:15px;" width="50%"> <strong> FLETE C. HIDALGO: </strong>Q. {{{number_format((float) $imp_maestro[0]->fl_ch_bv, 2) }}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> MUELLAJE: </strong>Q. {{{number_format((float) $imp_maestro[0]->muellaje, 2) }}}</td>
                    <td style="font-size:15px;" width="50%"> <strong> FLETE INTERNO COMBEX: </strong>Q. {{{number_format((float) $imp_maestro[0]->fl_i_c_v, 2) }}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> FUMIGACIÓN: </strong>Q. {{{number_format((float) $imp_maestro[0]->fumigacion, 2) }}} </td>
                    <td style="font-size:15px;" width="50%"> <strong> DESCARGA MONTACARGAS: </strong>Q. {{{number_format((float) $imp_maestro[0]->d_monta, 2) }}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> MANEJO DOCUMENTACIÓN: </strong>Q. {{{number_format((float) $imp_maestro[0]->m_documentacion, 2) }}}</td>
                    <td style="font-size:15px;" width="50%"> <strong> VIATICOS: </strong>Q. {{{number_format((float) $imp_maestro[0]->viaticos, 2) }}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> TRAMITES ALMACENADORA: </strong>Q. {{{number_format((float) $imp_maestro[0]->almacenaje_algesa, 2) }}}</td>
                    <td style="font-size:15px;" width="50%"> <strong> OTROS: </strong>Q. {{{number_format((float) $imp_maestro[0]->otros, 2) }}}</td>
                </tr>
            </table>
            <hr>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="70%"> <strong> COSTO TOTAL PUESTO EN BODEGA: </strong>Q. {{{number_format((float) $imp_maestro[0]->costo_pbod, 2) }}}</td>
                    <td style="font-size:15px; text-align:right;" width="30%">  </td>
                </tr>
            </table>
            <hr>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> FACTOR DE COSTEO: </strong>Q. {{{number_format((float) $imp_maestro[0]->fac_costeo, 2) }}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%">  </td>
                </tr>
            </table>

            <hr>
            <br>

            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=15%>CÓDIGO</th>
                        <th width=10%>CANTIDAD</th>
                        <th width=40%>DESCRIPCIÓN</th>
                        <th width=15%>FOB</th>
                        <th width=20%>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($imp_detalle as $id)
                    <tr>
                        <td style="font-size:12px; text-align:center;">{{ $id->codigo_articulo }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $id->cantidad }}</td>
                        <td style="font-size:12px; text-align:left;"> {{ $id->articulo}}</td>
                        <td style="font-size:12px; text-align:right;">$. {{{number_format((float) $id->fob, 2) }}}</td>
                        <td style="font-size:12px; text-align:right;">$. {{{number_format((float) $id->subtotal, 2) }}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            
        </div>
    </div>
</div>

</body>
</html>