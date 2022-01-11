@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Cotización
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('cotizaciones.index')}}"><i class="fa fa-list"></i> Cotizaciones</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="CotizacionForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Información de Cotización</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Serie Documento:</strong> {{$cotizacionmaestro[0]->serie}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Correlativo Documento:</strong> {{$cotizacionmaestro[0]->correlativo_documento}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Documento:</strong>{{Carbon\Carbon::parse($cotizacionmaestro[0]->fecha_documento)->format('d-m-Y')}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Condición de Pago:</strong> {{$cotizacionmaestro[0]->tipo_pago}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Exenta:</strong> {{$cotizacionmaestro[0]->exenta}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>NIT Cliente:</strong> {{$cotizacionmaestro[0]->nit}} </h4>
                    </div> 
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Nombre Cliente:</strong> {{$cotizacionmaestro[0]->cliente}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Días de Crédito:</strong> {{$cotizacionmaestro[0]->dias_credito}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Dirección:</strong> {{$cotizacionmaestro[0]->direccion_comercial}} </h4>
                    </div> 
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Atención A:</strong> {{$cotizacionmaestro[0]->atencion_a}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Lugar de Entrega:</strong> {{$cotizacionmaestro[0]->lugar_entrega}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Vendedor:</strong> {{$cotizacionmaestro[0]->vendedor}} </h4>
                    </div> 
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Descuento (Porcentaje {{$cotizacionmaestro[0]->porcentaje}}%):</strong> Q. {{{number_format((float) $cotizacionmaestro[0]->descuento_porcentaje, 2) }}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Descuento (Valores):</strong> Q. {{{number_format((float) $cotizacionmaestro[0]->descuento_valores, 2) }}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Tiempo de Entrega:</strong> {{$cotizacionmaestro[0]->tiempo_entrega}} </h4>
                    </div> 
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Validez de la Oferta:</strong> {{$cotizacionmaestro[0]->validez_oferta}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Transportado por:</strong> {{$cotizacionmaestro[0]->transportado_por}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Anotaciones:</strong> {{$cotizacionmaestro[0]->anotaciones}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Referencia:</strong> {{$cotizacionmaestro[0]->referencia}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Observaciones:</strong> {{$cotizacionmaestro[0]->observaciones}} </h4>
                    </div>
                </div>
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
                            @foreach ($cotizaciondetalle as $md)
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
                                <h4><strong>Usuario que Creó:</strong> {{$cotizacionmaestro[0]->name}} </h4>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center">
                                <h3><strong>Total:</strong> Q. {{{number_format((float) $cotizacionmaestro[0]->total, 2) }}}</h3>
                            </div>
                            <div class="col-md-4 col-sm-4 text-right">
                                <h3><strong>Total Neto:</strong> Q. {{{number_format((float) $cotizacionmaestro[0]->total - $cotizacionmaestro[0]->descuento_porcentaje - $cotizacionmaestro[0]->descuento_valores  , 2) }}}</h3>
                            </div>
                    </div>
                    <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('cotizaciones.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
