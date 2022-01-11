<h1>SUPLIDORA INDUSTRIAL S.A.</h1>
<h3>Reporte de Ventas de Productos</h3>
<br>
<h3>Del: {{{Carbon\Carbon::parse($fecha_inicial)->format('d-m-Y')}}} Al {{{Carbon\Carbon::parse($fecha_final)->format('d-m-Y')}}}</h3>
<br>


<table>

    <thead>
    
        <tr>
                        <th ><strong>SERIE</strong></th>
                        <th ><strong>NÚMERO</strong></th>
                        <th ><strong>FECHA</strong></th>
                        <th ><strong>PRODUCTO</strong></th>
                        <th ><strong>CANTIDAD</strong></th>
                        <th ><strong>PRECIO UNITARIO</strong></th>
                        <th ><strong>TOTAL</strong></th>
                    </tr>
                </thead>

                
                <tbody>
                @foreach ($ventas_prods as $vi)
                    
                    <tr>
                        <td >{{ $vi->serie }}</td>
                        <td >{{ $vi->correlativo_documento }}</td>
                        <td > {{Carbon\Carbon::parse($vi->fecha_documento)->format('d-m-Y')}}</td>
                        <td > {{ $vi->descripcion}}</td>
                        <td > {{ $vi->cantidad}}</td>
                        <td > {{ $vi->precio_unitario}}</td>
                        <td > {{ $vi->subtotal}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            


            