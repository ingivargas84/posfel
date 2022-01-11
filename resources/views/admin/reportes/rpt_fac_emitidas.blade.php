<h1>SUPLIDORA INDUSTRIAL S.A.</h1>
<h3>Reporte de Facturas Emitidas</h3>
<br>
<h3>Del: {{{Carbon\Carbon::parse($fecha_inicial)->format('d-m-Y')}}} Al {{{Carbon\Carbon::parse($fecha_final)->format('d-m-Y')}}}</h3>
<br>
<br>

<table>

    <thead>
    
        <tr>
                        <th ><strong>SERIE FAC</strong></th>
                        <th ><strong>NÚMERO FAC</strong></th>
                        <th ><strong>FECHA FAC</strong></th>
                        <th ><strong>CÓDIGO CLIENTE</strong></th>
                        <th ><strong>CLIENTE</strong></th>
                        <th ><strong>UUID   (AUTORIZACION SAT)</strong></th>
                        <th ><strong>SUB-TOTAL</strong></th>
                        <th ><strong>IVA</strong></th>
                        <th ><strong>TOTAL</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fac_emitidas as $fe)
                    <tr>
                        <td >{{ $fe->serie }}</td>
                        <td >{{ $fe->correlativo_documento }}</td>
                        <td > {{Carbon\Carbon::parse($fe->fecha_documento)->format('d-m-Y')}}</td>
                        <td > {{ $fe->cod_cliente}}</td>
                        <td > {{ $fe->cliente}}</td>
                        <td > {{ $fe->fel_uuid}}</td>
                        <td > {{ $fe->subtotal}}</td>
                        <td > {{ $fe->iva}}</td>
                        <td > {{ $fe->total}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <table>
                <tbody>
                    
                    <tr>
                        <td > </td>
                        <td > </td>
                        <td > </td>
                        <td colspan=3> <h3><strong>Total Facturación</strong></h3></td>
                        <td > {{ $totales[0]->subtotal - $anuladas_subtotal[0]->subtotal}}</td>
                        <td > {{ $totales[0]->iva - $anuladas_iva[0]->iva}}</td>
                        <td > {{ $totales[0]->total - $anuladas_total[0]->total}}</td>
                    </tr>
                    
                </tbody>
            </table>
