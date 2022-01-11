@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Factura
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('facturas.index')}}"><i class="fa fa-list"></i> Factura</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="FacturaForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Información de Factura</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Tipo de Factura:</strong> {{$facturamaestro[0]->tipo_factura}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Orden de Compra:</strong> {{$facturamaestro[0]->orden_compra}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Cotización Asociada:</strong>{{$facturamaestro[0]->serie_coti}} - {{$facturamaestro[0]->correlativo_documento}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Serie Factura:</strong> {{$facturamaestro[0]->fel_serie}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Correlativo Factura:</strong> {{$facturamaestro[0]->fel_numero}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Factura:</strong>{{Carbon\Carbon::parse($facturamaestro[0]->fecha_documento)->format('d-m-Y')}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        <h4><strong>Fecha Certificación:</strong> {{$facturamaestro[0]->fel_fecha_certificacion}} </h4>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <h4><strong>Código Autorización:</strong> {{$facturamaestro[0]->fel_uuid}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>NIT Cliente:</strong> {{$facturamaestro[0]->nit}} </h4>
                    </div> 
                    <div class="col-md-8 col-sm-8">
                        <h4><strong>Nombre Cliente:</strong> {{$facturamaestro[0]->nombre_comercial}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Exenta:</strong> {{$facturamaestro[0]->exenta}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Descuento (Porcentaje {{$facturamaestro[0]->porcentaje}}%):</strong>Q. {{{number_format((float) $facturamaestro[0]->descuento_porcentaje, 2) }}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Descuento (Valores):</strong>Q. {{{number_format((float) $facturamaestro[0]->descuento_valores, 2) }}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Envios:</strong> {{$facturamaestro[0]->envios}} </h4>
                    </div> 
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Transportado por:</strong> {{$facturamaestro[0]->transportado_por}} </h4>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        @if ($facturamaestro[0]->estado == 'Anulado')
                            <h3 style="color:red"><strong>Estado: {{$facturamaestro[0]->estado}} </strong> </h3>
                        @elseif ($facturamaestro[0]->estado == 'Activo')
                            <h3 style="color:green"><strong>Estado: {{$facturamaestro[0]->estado}} </strong> </h3>
                        @elseif ($facturamaestro[0]->estado == 'Inactivo')
                            <h3 style="color:orange"><strong>Estado: {{$facturamaestro[0]->estado}} </strong> </h3>
                        @elseif ($facturamaestro[0]->estado == 'Eliminado')
                            <h3 style="color:red"><strong>Estado: {{$facturamaestro[0]->estado}} </strong> </h3>
                        @endif
                    </div> 
                    <div class="col-md-6 col-sm-6">
                    </div>
                </div>
                @if ($facturamaestro[0]->estado == 'Anulado')
                <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <h4><strong>Fecha Anulación:</strong>{{$facturamaestro[0]->fel_fecha_certificacion_anula}} </h4>
                        </div> 
                        <div class="col-md-3 col-sm-3">
                            <h4><strong>Serie Anulación:</strong> {{$facturamaestro[0]->fel_serie_anula}} </h4>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h4><strong>Correlativo Anulación:</strong> {{$facturamaestro[0]->fel_numero_anula}} </h4>
                        </div>
                           
                </div>
                <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h4><strong>Codigo Autorización de Anulación:</strong> {{$facturamaestro[0]->fel_uuid_anula}} </h4>
                        </div>
                </div>
                @endif
                <br>
                <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width=40% style="font-size:15px; text-align:left;">Artículo</th>
                                <th width=20% style="font-size:15px; text-align:center;">Cantidad</th>
                                <th width=20% style="font-size:15px; text-align:right;">Precio Unitario</th>
                                <th width=20% style="font-size:15px; text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facturadetalle as $md)
                            <tr>
                                <td style="font-size:13px; text-align:left;">{{$md->codigo_articulo}}-{{$md->codigo_alterno}}-{{$md->desc_articulo}}</td>
                                <td style="font-size:13px; text-align:center;">{{ $md->cantidad }}</td>
                                <td style="font-size:13px; text-align:right;">Q. {{{number_format((float) $md->precio_unitario, 2) }}}</td>
                                <td style="font-size:13px; text-align:right;">Q. {{{number_format((float) $md->subtotal, 2) }}}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <br>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 text-left">
                                <h4><strong>Usuario que Creó:</strong> {{$facturamaestro[0]->crea}} </h4>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center">
                                <h3><strong>Total:</strong> Q. {{{number_format((float) $facturamaestro[0]->total, 2) }}}</h3>
                            </div>
                            <div class="col-md-4 col-sm-4 text-right">
                                <h3><strong>Total Neto:</strong> Q. {{{number_format((float) $facturamaestro[0]->total - $facturamaestro[0]->descuento_porcentaje - $facturamaestro[0]->descuento_valores  , 2) }}}</h3>
                            </div>
                    </div>
                    <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('facturas.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
