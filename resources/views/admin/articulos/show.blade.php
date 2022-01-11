@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        ARTICULOS
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('articulos.index')}}"><i class="fa fa-list"></i> Artículos</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form id="ArticuloShowForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Artículo</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Descripción:</strong> {{$art[0]->articulo}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Codigo Artículo:</strong> {{$art[0]->codigo_articulo}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Codigo Alterno:</strong> {{$art[0]->codigo_alterno}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Costos</strong></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Proveedor:</strong> {{$art[0]->proveedor}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Costo FOB:</strong> $. {{{number_format((float) $art[0]->costo_fob, 2) }}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Costo Dolares:</strong> $ {{{number_format((float) $art[0]->costo_dolares, 2) }}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Costo Quetzales:</strong> Q. {{{number_format((float) $art[0]->costo_quetzales, 2) }}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Costo Promedio Quetzales:</strong> Q. {{{number_format((float) $art[0]->costo_promedio_quetzales, 2) }}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Ultimo Costo:</strong> Q. {{{number_format((float) $art[0]->ultimo_costo, 2) }}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Primer Costo:</strong> Q. {{{number_format((float) $art[0]->primer_costo, 2) }}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Precios</strong></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Precio Quetzales:</strong> Q. {{{number_format((float) $art[0]->precio_quetzales, 2) }}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Precio Dolares:</strong> $ {{{number_format((float) $art[0]->precio_dolares, 2) }}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Ultimo Precio:</strong> Q. {{{number_format((float) $art[0]->ultimo_precio, 2) }}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Cantidades</strong></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Cantidad Pedida:</strong> {{ $art[0]->cantidad_pedida}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Cantidad Máxima:</strong> {{ $art[0]->cantidad_maxima }} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Cantidad Mínima:</strong> {{ $art[0]->cantidad_minima }} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Existencias:</strong> {{ $art[0]->existencia }} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Ultima Compra:</strong> {{Carbon\Carbon::parse($art[0]->fecha_ultima_compra)->format('d-m-Y')}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Ultima Venta:</strong> {{Carbon\Carbon::parse($art[0]->fecha_ultima_venta)->format('d-m-Y')}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Almacenamiento</strong></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Localización:</strong> {{ $art[0]->localizacion}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Bodega:</strong> {{ $art[0]->bodega }} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Almacenadora:</strong> {{ $art[0]->almacenadora }} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Observaciones:</strong> {{ $art[0]->observaciones}} </h4>
                    </div>
                </div>
                
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6 text-left">
                        <h4><strong>Usuario que Creó:</strong> {{$art[0]->name}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6 text-right">
                        <h4><strong>Fecha Creación:</strong> {{Carbon\Carbon::parse($art[0]->created_at)->format('d-m-Y H:m:s')}}</h4>
                    </div>
                </div>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('articulos.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
