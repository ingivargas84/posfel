<h1>SUPLIDORA INDUSTRIAL S.A.</h1>
<h3>Reporte de Libro Ventas y Servicios Prestados</h3>
<br>
<h3>Del: {{{Carbon\Carbon::parse($fecha_inicial)->format('d-m-Y')}}} Al {{{Carbon\Carbon::parse($fecha_final)->format('d-m-Y')}}}</h3>
<h3>Folio No: {{{$folios}}}</h3>
<br>
<br>
<table>

    <thead>
    
        <tr>
                        <th ><strong>SERIE FAC</strong></th>
                        <th ><strong>NUM INCIAL</strong></th>
                        <th ><strong>NUM FINAL</strong></th>
                        <th ><strong>FECHA</strong></th>
                        <th ><strong>SUB-TOTAL</strong></th>
                        <th ><strong>IVA</strong></th>
                        <th ><strong>TOTAL</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lib_ventas as $lv)
                    <tr>
                        <td >{{ $lv->serie }}</td>
                        <td >{{ $lv->num_inicial }}</td>
                        <td > {{ $lv->num_final}}</td>
                        <td > {{Carbon\Carbon::parse($lv->fecha_documento)->format('d-m-Y')}}</td>
                        <td > {{ $lv->subtotal}}</td>
                        <td > {{ $lv->iva}}</td>
                        <td > {{ $lv->total}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
<br>
<br>
            <table>
                <tbody>
                    <tr>
                        <td > </td>
                        <td colspan=3> <h3><strong>Totales</strong></h3></td>
                        <td > {{ $totales[0]->subtotal}}</td>
                        <td > {{ $totales[0]->iva}}</td>
                        <td > {{ $totales[0]->total}}</td>
                    </tr>
                </tbody>
            </table>

            <h3>Total de Documentos</h3>
            <table>
                <tbody>
                    @foreach ($documentos as $doc)
                    <tr>
                        <td >Serie {{ $doc->serie }}</td>
                        <td >{{ $doc->tot_serie }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td >Total</td>
                        <td >{{ $tot_serie[0]->total }}</td>
                    </tr>
                </tbody>
            </table>
