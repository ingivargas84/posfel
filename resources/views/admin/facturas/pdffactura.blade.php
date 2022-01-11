<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura</title>
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
        .footer {
            position: fixed;
            left: 0;
            bottom: 120;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
       <div class="row">
        <div class="col-md-12">
        <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:16px; text-align:left;" width="30%" rowspan="5"> <img width="175px" src="images/logo.jpeg">  </td>
                    <td style="font-size:10px; text-align:center;" width="40%"> <strong>SUPLIDORA INDUSTRIAL, SOCIEDAD ANÓNIMA</strong> </td>
                    <td style="font-size:14px; text-align:left;" width="30%"> <strong>FACTURA ELECTRÓNICA</strong> </td>
                </tr>
                <tr>
                    <td style="font-size:12px; text-align:center;" width="40%"> 10a. AVENIDA 21-13, ZONA 1</td>
                    <td style="font-size:12px; text-align:left;" width="30%"> Serie: {{{ $facturamaestro[0]->fel_serie }}} </td>
                </tr>
                <tr>
                    <td style="font-size:12px; text-align:center;" width="40%"> PBX: 2427-9999 </td>
                    <td style="font-size:12px; text-align:left;" width="30%"> Número: {{{ $facturamaestro[0]->fel_numero }}} </td>
                </tr>
                <tr>
                    <td style="font-size:12px; text-align:center;" width="40%"> GUATEMALA, GUATEMALA </td>
                    <td style="font-size:12px; text-align:left;" width="30%"> Orden de Compra: {{{ $facturamaestro[0]->orden_compra }}} </td>
                </tr>
                <tr>
                    <td style="font-size:12px; text-align:center;" width="40%"> <strong> NIT: 842754-2 </strong> </td>
                    <td style="font-size:12px; text-align:left;" width="30%"> </td>
                </tr>
            </table>
            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:13px; text-align:left;" width="80%"> <strong> Autorización: </strong>  {{{ $facturamaestro[0]->fel_uuid }}} </td>
                    <td style="font-size:13px; text-align:left;" width="20%"> <strong> Fecha: </strong> {{Carbon\Carbon::parse($facturamaestro[0]->fel_fecha_certificacion)->format('d-m-Y')}} </td>
                </tr>
            </table>
            <hr>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:13px; text-align:left;" width="80%"> <strong> Nombre: </strong> {{{ $facturamaestro[0]->nombre_comercial }}}  </td>
                    <td style="font-size:13px; text-align:left;" width="20%"> <strong> Código: </strong> {{{ $facturamaestro[0]->codigo_cliente }}}</td>
                </tr>
                <tr>
                    <td style="font-size:13px; text-align:left;" width="80%"> <strong>Dirección: </strong> {{{ $facturamaestro[0]->direccion_comercial }}}  </td>
                    <td style="font-size:13px; text-align:left;" width="20%"> <strong>NIT: </strong> {{{ $facturamaestro[0]->nit }}} </td>
                </tr>
                <tr>
                    <td style="font-size:13px; text-align:left;" width="80%"> <strong>Vendedor:</strong> {{{ $facturamaestro[0]->vendedor }}}  </td>
                    <td style="font-size:13px; text-align:right;" width="20%"> </td>
                </tr>
            </table>
            <hr>

            <table border="0" cellspacing=0 cellpadding=2 width=800  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="font-size:13px; text-align:left;" width=10%>CÓDIGO</th>
                        <th style="font-size:13px; text-align:left;" width=10%>CANTIDAD</th>
                        <th style="font-size:13px; text-align:center;" width=50%>DESCRIPCIÓN</th>
                        <th style="font-size:12px; text-align:right;" width=10%>PRECIO UNITARIO</th>
                        <th style="font-size:13px; text-align:right;" width=10%>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facturadetalle as $ocd)
                    <tr>
                        <td style="font-size:10px; text-align:left;">{{ $ocd->codigo_articulo }}</td>
                        <td style="font-size:11px; text-align:center;">{{ $ocd->cantidad }}</td>
                        <td style="font-size:11px; text-align:left;"> {{ $ocd->desc_articulo}}</td>
                        <td style="font-size:11px; text-align:right;">Q. {{{number_format((float) $ocd->precio_unitario, 2) }}}</td>
                        <td style="font-size:11px; text-align:right;">Q. {{{number_format((float) $ocd->subtotal, 2) }}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>




        </div>
    </div>
</div>
<div class="footer">
    <table cellspacing=0 cellpadding=0 width= 800 class="table table-striped table-bordered">
            <tr>
                    <td style="font-size:13px; text-align:right" width="80%"> <strong>SUB-TOTAL: </strong></td>
                    <td style="font-size:13px; text-align:right;" width="20%">  Q. {{{number_format((float) $facturamaestro[0]->total, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:13px; text-align:right" width="80%"> <strong>DESCUENTO {{{number_format((float) $facturamaestro[0]->porcentaje, 2) }}}%: </strong> </td>
                    <td style="font-size:13px; text-align:right;" width="20%"> Q. {{{number_format((float) $facturamaestro[0]->descuento_porcentaje, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:13px; text-align:right" width="80%"> <strong>DESCUENTO VALORES: </strong></td>
                    <td style="font-size:13px; text-align:right;" width="20%">  Q. {{{number_format((float) $facturamaestro[0]->descuento_valores, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:13px; text-align:right" width="80%"> <strong>TOTAL NETO: </strong></td>
                    <td style="font-size:13px; text-align:right;" width="20%">  <u>Q. {{{number_format((float) $facturamaestro[0]->total - $facturamaestro[0]->descuento_porcentaje - $facturamaestro[0]->descuento_valores, 2) }}}</u> </td>
                </tr>
                <tr>
                    <td style="font-size:13px; text-align:left" width="80%"> <strong>TOTAL EN LETRAS: </strong>{{ $nl }}</td>
                    <td style="font-size:13px; text-align:right;" width="20%"> </td>
                </tr>
    </table>
    <hr>
    <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
        <tr>
            <td style="font-size:15px;" width="50%"> <strong>Observaciones: </strong></td>
            <td style="font-size:15px; text-align:right;" width="50%"> </td>
        </tr>
    </table>
    <hr>
    <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
        <tr>
            <td style="font-size:10px; text-align:left;" width="35%"> Fecha y Hora: {{Carbon\Carbon::parse($facturamaestro[0]->created_at)->format('d-m-Y H:m:s')}}</td>
            <td style="font-size:10px; text-align:center;" width="25%"> <strong>SUJETO A PAGOS TRIMESTRALES</strong></td>
            <td style="font-size:10px; text-align:center;" width="25%"> Serie: {{{ $facturamaestro[0]->serie }}} Número: {{{ $facturamaestro[0]->num_fac }}} </td>
            <td style="font-size:10px; text-align:right;" width="15%"> <img width="50px" src="images/fel.png">  </td>
        </tr>
        <tr>
            <td style="font-size:12px; text-align:center;" colspan="5" width="100%"> <strong>Certificador:</strong> Infile, Sociedad Anónima  <strong>NIT:</strong> 1252133-7</td>
        </tr>
    </table>
</div>
</body>
</html>
