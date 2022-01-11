@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        ORDEN DE COMPRA
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('ordenes_compras.index')}}"><i class="fa fa-list"></i> Ordenes de Compra</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="OrdenCompraForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Información de Orden de Compra</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Serie Documento:</strong> {{$ordencompra_maestro[0]->serie}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Correlativo Documento:</strong> {{$ordencompra_maestro[0]->correlativo_documento}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Documento:</strong>{{Carbon\Carbon::parse($ordencompra_maestro[0]->fecha_documento)->format('d-m-Y')}}</h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Tipo Documento:</strong> {{$ordencompra_maestro[0]->tipo_documento_importacion}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>NIT Proveedor:</strong> {{$ordencompra_maestro[0]->nit_proveedor}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Dias Crédito Proveedor:</strong> {{$ordencompra_maestro[0]->dias_credito}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Nombre Proveedor:</strong> {{$ordencompra_maestro[0]->proveedor}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Dirección Proveedor:</strong> {{$ordencompra_maestro[0]->direccion_proveedor}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Atención A:</strong> {{$ordencompra_maestro[0]->atencion_a}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Persona que Solicita:</strong> {{$ordencompra_maestro[0]->solicito}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Lugar de Entrega:</strong> {{$ordencompra_maestro[0]->lugar_entrega}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Tipo de Pago:</strong> {{$ordencompra_maestro[0]->tipo_pago}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Fecha de Entrega:</strong> {{Carbon\Carbon::parse($ordencompra_maestro[0]->fecha_entrega)->format('d-m-Y')}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Preparado por:</strong> {{$ordencompra_maestro[0]->crea}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Autorizado por:</strong> {{$ordencompra_maestro[0]->autoriza}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Observaciones:</strong> {{$ordencompra_maestro[0]->observaciones}} </h4>
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
                            @foreach ($ordencompra_detalle as $od)
                            <tr>
                                <td style="font-size:13px; text-align:left;">{{$od->codigo_articulo}}-{{$od->codigo_alterno}}-{{$od->desc_articulo}}</td>
                                <td style="font-size:13px; text-align:center;">{{ $od->cantidad }}</td>
                                <td style="font-size:13px; text-align:right;">Q. {{{number_format((float) $od->precio_unitario, 2) }}}</td>
                                <td style="font-size:13px; text-align:right;">Q. {{{number_format((float) $od->subtotal, 2) }}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <h3><strong>Total:</strong> Q. {{{number_format((float) $ordencompra_maestro[0]->total, 2) }}}</h3>
                    </div>
                </div>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('ordenes_compras.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
