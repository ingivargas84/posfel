@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        MOVIMIENTOS
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('movimientos.index')}}"><i class="fa fa-list"></i> Movimientos</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="MovimientoForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Información de Movimiento</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Serie Documento:</strong> {{$movimiento_maestro[0]->serie}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Correlativo Documento:</strong> {{$movimiento_maestro[0]->correlativo_documento}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Documento:</strong>{{Carbon\Carbon::parse($movimiento_maestro[0]->fecha_documento)->format('d-m-Y')}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Tipo Documento:</strong> {{$movimiento_maestro[0]->tipo_documento}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Aplicación:</strong> {{$movimiento_maestro[0]->aplicacion}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Bodega Origen:</strong> {{$movimiento_maestro[0]->bodega_origen}} </h4>
                    </div>
                </div>
                <div class="row">
                    @if ($movimiento_maestro[0]->tipo_documento == 'Entrada')
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Proveedor:</strong> {{$movimiento_maestro[0]->proveedor}} </h4>
                    </div> 
                    @else
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Cliente:</strong> {{$movimiento_maestro[0]->cliente}} </h4>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Observaciones:</strong> {{$movimiento_maestro[0]->observaciones}} </h4>
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
                            @foreach ($movimiento_detalle as $md)
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
                            <div class="col-md-6 col-sm-6 text-left">
                                <h4><strong>Usuario que Creó:</strong> {{$movimiento_maestro[0]->name}} </h4>
                            </div>
                            <div class="col-md-6 col-sm-6 text-right">
                                <h3><strong>Total:</strong> Q. {{{number_format((float) $movimiento_maestro[0]->total, 2) }}}</h3>
                            </div>
                    </div>
                    <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('movimientos.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
