<h1>SUPLIDORA INDUSTRIAL S.A.</h1>
<h3>Reporte de Antigüedad de Saldos</h3>
<br>
<h3>Del: {{{Carbon\Carbon::parse($fecha_inicial)->format('d-m-Y')}}} Al {{{Carbon\Carbon::parse($fecha_final)->format('d-m-Y')}}}</h3>
<br>
<h3>Cliente: {{{$cliente->codigo}}}      Nombre: {{{$cliente->nombre_comercial}}}   Vendedor: {{{$cliente->vendedor_id}}} </h3>
<br>

<table>

    <thead>
    
        <tr>
                        <th ><strong>SERIE FAC</strong></th>
                        <th ><strong>NÚMERO FAC</strong></th>
                        <th ><strong>FECHA FAC</strong></th>
                        <th ><strong>0-30</strong></th>
                        <th ><strong>31-60</strong></th>
                        <th ><strong>61-90</strong></th>
                        <th ><strong>91 +</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos as $d)
                    <tr>
                        <td >{{ $d->serie }}</td>
                        <td >{{ $d->num }}</td>
                        <td > {{Carbon\Carbon::parse($d->fecha)->format('d-m-Y')}}</td>
                        <td > {{ $d->N1}}</td>
                        <td > {{ $d->N2}}</td>
                        <td > {{ $d->N3}}</td>
                        <td > {{ $d->N4}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <table>
                <tbody>
                    
                    <tr>
                        <td colspan=3> <h3><strong>Totales:</strong></h3></td>
                        <td > {{ $total1[0]->N1}}</td>
                        <td > {{ $total2[0]->N2}}</td>
                        <td > {{ $total3[0]->N3}}</td>
                        <td > {{ $total4[0]->N4}}</td>
                    </tr>
                    
                </tbody>
            </table>

            
