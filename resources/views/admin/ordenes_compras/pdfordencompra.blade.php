<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Orden de Compra</title>
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
                    <td style="font-size:20px; text-align:right;" width="50%"> <strong>ORDEN DE COMPRA</strong> </td>
                </tr>
            </table>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="50%"> Suplidora Industrial, S.A.: </td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> SERIE: </strong> {{{ $ordencompra_maestro[0]->serie }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> 10a. Avenida 21-13 Zona 1 </td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> No:</strong> {{{ $ordencompra_maestro[0]->correlativo_documento }}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> PBX (502) 2427-9999 </td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong>Nit 842754-2</strong> </td>
                </tr>
            </table>
            <hr>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:14px;" width="60%"> <strong>FECHA:</strong> {{{ $ordencompra_maestro[0]->fecha_documento }}} </td>
                    <td style="font-size:14px; text-align:right;" width="40%"> <strong>TIPO COMPRA: </strong> {{{ $ordencompra_maestro[0]->tipo_pago }}} </td>
                </tr>
                <tr>
                    <td style="font-size:14px;" width="60%"> <strong>NOMBRE: </strong> {{{ $ordencompra_maestro[0]->proveedor }}}</td>
                    <td style="font-size:14px; text-align:right;" width="40%"> <strong>SOLICITADO POR:</strong> {{{ $ordencompra_maestro[0]->solicito }}} </td>
                </tr>
                <tr>
                    <td style="font-size:14px;" width="60%"><strong> DIRECCIÓN: </strong>{{{ $ordencompra_maestro[0]->direccion_proveedor }}} </td>
                    <td style="font-size:14px; text-align:right;" width="40%"> <strong>LUGAR ENTREGA:</strong> {{{ $ordencompra_maestro[0]->lugar_entrega }}} </td>
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
                        <th width=15%>PRECIO UNITARIO</th>
                        <th width=20%>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordencompra_detalle as $ocd)
                    <tr>
                        <td style="font-size:12px; text-align:center;">{{ $ocd->codigo_articulo }}</td>
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
                    <td style="font-size:15px;" width="50%"></td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong>TOTAL: </strong> Q. {{{number_format((float) $ordencompra_maestro[0]->total, 2) }}} </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br>
<div>
    <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
        <tr>
            <td style="font-size:15px;" width="45%"><strong>AUTORIZADO POR: </strong> {{{ $ordencompra_maestro[0]->autoriza }}}</td>
            <td style="font-size:15px;" width="20%"><strong>FIRMA:____________</strong></td>
            <td style="font-size:15px;" width="25%"><strong>TOTAL:</strong> Q. {{{number_format((float) $ordencompra_maestro[0]->total, 2) }}}</td>
        </tr>
        
    </table>
    <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
        <tr>
            <td style="font-size:15px;" width="100%"><strong>OBSERVACIONES: </strong> {{{ $ordencompra_maestro[0]->observaciones }}}</td>    
        </tr>        
    </table>
    <h5><U>NO SE RECIBEN FACTURAS CON MÁS DE 12 DIAS DE EMISIÓN</U></h5>
    <h5><U>Y DEL MES ANTERIOR, SE RECIBEN EN LOS PRIMEROS 7 DÍAS CALENDARIOS</U></h5>
</div>
</body>
</html>