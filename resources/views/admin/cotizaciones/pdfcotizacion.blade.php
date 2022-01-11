<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cotización</title>
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
            bottom: 30;
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
                    <td style="font-size:16px; text-align:left;" width="50%" rowspan="3"> <img width="250px" src="images/logo.jpeg">  </td>
                    <td style="font-size:16px; text-align:center;" width="50%"> <strong>SUPLIDORA INDUSTRIAL, S.A.</strong> </td>
                </tr>
                <tr>
                    <td style="font-size:16px; text-align:center;" width="50%"> 10a avenida 21-13, Zona 1 Guatemala, C.A. </td>
                </tr>
                <tr>
                    <td style="font-size:16px; text-align:center;" width="50%"> <strong>PBX:</strong> 2427-9999 <strong>FAX:</strong>2427-9901 </td>
                </tr>
            </table>
            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:20px; text-align:center;" width="100%"> <strong> Cotización: {{{ $cotizacionmaestro[0]->serie }}} {{{ $cotizacionmaestro[0]->correlativo_documento }}} </strong> </td>
                </tr>
            </table>
            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="20%"> <strong> Guatemala: </strong></td>
                    <td style="font-size:15px; text-align:left;" width="80%"> {{{Carbon\Carbon::parse($cotizacionmaestro[0]->fecha_documento)->format('d-m-Y')}}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="20%"> <strong> Cliente: </strong></td>
                    <td style="font-size:15px; text-align:left;" width="80%">{{{ $cotizacionmaestro[0]->cliente }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="20%"> <strong>Dirección: </strong></td>
                    <td style="font-size:15px; text-align:left;" width="80%"> {{{ $cotizacionmaestro[0]->direccion_comercial }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="20%"> <strong>Forma de Pago:</strong></td>
                    @if ($cotizacionmaestro[0]->tipo_pago == 'Contado')
                    <td style="font-size:15px; text-align:left;" width="80%">{{{ $cotizacionmaestro[0]->tipo_pago }}}</td>
                    @elseif ($cotizacionmaestro[0]->tipo_pago == 'Crédito')
                    <td style="font-size:15px; text-align:left;" width="80%">{{{ $cotizacionmaestro[0]->tipo_pago }}}  -  {{{ $cotizacionmaestro[0]->dias_credito }}} días</td>
                    @endif
                </tr>
                <tr>
                    <td style="font-size:15px;" width="20%"> <strong>Atención a: </strong></td>
                    <td style="font-size:15px; text-align:left;" width="80%">{{{ $cotizacionmaestro[0]->atencion_a }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="20%"> <strong>Transportado por: </strong></td>
                    <td style="font-size:15px; text-align:left;" width="80%">{{{ $cotizacionmaestro[0]->transportado_por }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="20%"> <strong>Referencia:</strong></td>
                    <td style="font-size:15px; text-align:left;" width="80%">{{{ $cotizacionmaestro[0]->referencia }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="20%"> <strong>Lugar de Entrega:</strong></td>
                    <td style="font-size:15px; text-align:left;" width="80%">{{{ $cotizacionmaestro[0]->lugar_entrega }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="20%"> <strong>Tiempo de Entrega:</strong></td>
                    <td style="font-size:15px; text-align:left;" width="80%">{{{ $cotizacionmaestro[0]->tiempo_entrega }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="20%"> <strong>Validez:</strong></td>
                    <td style="font-size:15px; text-align:left;" width="80%">{{{ $cotizacionmaestro[0]->validez_oferta }}} </td>
                </tr>
            </table>
            <hr>
           
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="text-align:left;" width=10%>CÓDIGO</th>
                        <th width=5%>CANT</th>
                        <th width=50%>DESCRIPCIÓN</th>
                        <th style="text-align:right;" width=15%>UNITARIO</th>
                        <th style="text-align:right;" width=20%>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cotizaciondetalle as $ocd)
                    <tr>
                        <td style="font-size:10px; text-align:left;">{{ $ocd->codigo_articulo }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ocd->cantidad }}</td>
                        <td style="font-size:12px; text-align:left;"> {{ $ocd->desc_articulo}}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{{number_format((float) $ocd->precio_unitario, 2) }}}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{{number_format((float) $ocd->subtotal, 2) }}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px; text-align:right" width="80%"> <strong>SUB-TOTAL: </strong></td>
                    <td style="font-size:17px; text-align:right;" width="20%">  Q. {{{number_format((float) $cotizacionmaestro[0]->total, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px; text-align:right" width="80%"> <strong>DESCUENTO {{{number_format((float) $cotizacionmaestro[0]->porcentaje, 2) }}}%: </strong> </td>
                    <td style="font-size:17px; text-align:right;" width="20%"> Q. {{{number_format((float) $cotizacionmaestro[0]->descuento_porcentaje, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px; text-align:right" width="80%"> <strong>DESCUENTO: </strong></td>
                    <td style="font-size:17px; text-align:right;" width="20%">  Q. {{{number_format((float) $cotizacionmaestro[0]->descuento_valores, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px; text-align:right" width="80%"> <strong>TOTAL: </strong></td>
                    <td style="font-size:17px; text-align:right;" width="20%">  <u>Q. {{{number_format((float) $cotizacionmaestro[0]->total - $cotizacionmaestro[0]->descuento_porcentaje - $cotizacionmaestro[0]->descuento_valores, 2) }}}</u> </td>
                </tr>
                <tr>
                    <td style="font-size:15px; text-align:left" width="80%"> <strong>TOTAL EN LETRAS: </strong>{{ $nl }}</td>
                    <td style="font-size:17px; text-align:right;" width="20%">  </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="footer">
    <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
        <tr>
            <td style="font-size:15px; text-align:center;" width="100%"> Cotizado por: {{ $cotizacionmaestro[0]->vendedor }}, {{ $cotizacionmaestro[0]->puesto }} </td>
        </tr>
    </table>
</div>
</body>
</html>