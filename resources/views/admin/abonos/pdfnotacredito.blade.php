<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Nota de Crédito</title>
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
            bottom: 160;
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
                    <td style="font-size:14px; text-align:left;" width="30%"> <strong>NOTA DE CRÉDITO</strong> </td>
                </tr>
                <tr>
                    <td style="font-size:12px; text-align:center;" width="40%"> 10a. AVENIDA 21-13, ZONA 1</td>
                    <td style="font-size:14px; text-align:left;" width="30%"> <strong>ELECTRÓNICA</strong> </td>
                </tr>
                <tr>
                    <td style="font-size:12px; text-align:center;" width="40%"> PBX: 2427-9999 </td>
                    <td style="font-size:12px; text-align:left;" width="30%"> Serie: {{{ $abonomaestro[0]->fel_serie }}} </td>
                </tr>
                <tr>
                    <td style="font-size:12px; text-align:center;" width="40%"> GUATEMALA, GUATEMALA </td>
                    <td style="font-size:12px; text-align:left;" width="30%"> Número: {{{ $abonomaestro[0]->fel_numero }}} </td>
                </tr>
                <tr>
                    <td style="font-size:12px; text-align:center;" width="40%"> <strong> NIT: 842754-2 </strong> </td>
                    <td style="font-size:12px; text-align:left;" width="30%"> </td>
                </tr>
            </table>
            <br>
            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px; text-align:left;" width="80%"> Autorización: {{{ $abonomaestro[0]->fel_uuid }}} </td>
                    <td style="font-size:15px; text-align:left;" width="20%"> Fecha: {{Carbon\Carbon::parse($abonomaestro[0]->fel_fecha_certificacion)->format('d-m-Y')}} </td>
                </tr>
            </table>
            <hr>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px; text-align:left;" width="80%"> <strong> Nombre: </strong> {{{ $abonomaestro[0]->nombre_comercial }}}  </td>
                    <td style="font-size:15px; text-align:left;" width="20%"> <strong> </td>
                </tr>
                <tr>
                    <td style="font-size:15px; text-align:left;" width="80%"> <strong>Dirección: </strong> {{{ $abonomaestro[0]->direccion_comercial }}}  </td>
                    <td style="font-size:15px; text-align:left;" width="20%"> <strong>NIT: </strong> {{{ $abonomaestro[0]->nit }}} </td>
                </tr>
            </table>
            <hr>
           
            <table border="0" cellspacing=0 cellpadding=2 width=800  class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=15%>SERIE</th>
                        <th width=15%>DOCUMENTO</th>
                        <th width=15%>FECHA</th>
                        <th width=15%>MONTO</th>
                        <th width=15%>ABONO</th>
                        <th width=15%>SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($abonodetalle as $ocd)
                    <tr>
                        <td style="font-size:12px; text-align:left;">{{ $ocd->serie }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ocd->correlativo_documento }}</td>
                        <td style="font-size:12px; text-align:left;"> {{Carbon\Carbon::parse($abonomaestro[0]->fecha_documento)->format('d-m-Y')}}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{{number_format((float) $ocd->total_factura, 2) }}}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{{number_format((float) $ocd->abono, 2) }}}
                        <td style="font-size:12px; text-align:right;">Q. {{{number_format((float) $ocd->saldo, 2) }}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            
            
            
        </div>
    </div>
</div>
<div class="footer">
    <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
        <tr>
            <td style="font-size:13px; text-align:left;" width="70%"> <strong>TOTAL EN LETRAS: </strong>{{ $nl }}</td>
            <td style="font-size:15px; text-align:right;" width="30%"> <strong>TOTAL: </strong> Q. {{{number_format((float) $abonomaestro[0]->total, 2) }}} </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <hr>
    <table cellspacing=0 cellpadding=2 width=800 class="table table-striped table-bordered">
        <tr>
            <td style="font-size:10px; text-align:left;" width="30%"> Fecha y Hora: {{Carbon\Carbon::parse($abonomaestro[0]->created_at)->format('d-m-Y H:m:s')}}</td>
            <td style="font-size:10px; text-align:center;" width="40%"> Serie: {{{ $abonomaestro[0]->fel_serie }}} Num: {{{ $abonomaestro[0]->fel_numero }}} </td>
            <td style="font-size:10px; text-align:right;" width="30%"> <img width="60px" src="images/fel.png">  </td>
        </tr>
        <tr>
            <td style="font-size:12px; text-align:center;" colspan="5" width="100%"> <strong>Certificador:</strong> Infile, Sociedad Anónima  <strong>NIT:</strong> 1252133-7</td>
        </tr>
    </table>
</div>
</body>
</html>