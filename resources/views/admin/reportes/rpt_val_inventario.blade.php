<h1>SUPLIDORA INDUSTRIAL S.A.</h1>
<h3>Reporte de Valorización del Inventario</h3>
<br>

<table>

    <thead>
    
        <tr>
                        <th ><strong>CODIGO</strong></th>
                        <th ><strong>DESCRIPCIÓN</strong></th>
                        <th ><strong>EXISTENCIA</strong></th>
                        <th ><strong>COSTO PROMEDIO</strong></th>
                        <th ><strong>TOTAL</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($val_inventario as $vi)
                    <tr>
                        <td >{{ $vi->codigo }}</td>
                        <td >{{ $vi->descripcion }}</td>
                        <td > {{ $vi->existencia}}</td>
                        <td > {{ $vi->costo_promedio}}</td>
                        <td > {{ $vi->total}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            
            <table>
                <tbody>
                    
                    <tr>
                        <td > </td>
                        <td colspan=3> <h3><strong>Gran Total</strong></h3></td>
                        <td > {{ $totales[0]->total}}</td>
                    </tr>
                    
                </tbody>
            </table>
