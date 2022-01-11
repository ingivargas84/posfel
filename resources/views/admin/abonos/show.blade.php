@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Abono
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('abonos.index')}}"><i class="fa fa-list"></i> Abonos</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="AbonoForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Información del Abono</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Serie Documento:</strong> {{$abonomaestro[0]->serie}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Correlativo Documento:</strong> {{$abonomaestro[0]->correlativo_documento}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Documento:</strong>{{Carbon\Carbon::parse($abonomaestro[0]->fecha_documento)->format('d-m-Y')}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Tipo de Abono:</strong> {{$abonomaestro[0]->tipo_abono}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>NIT Cliente:</strong> {{$abonomaestro[0]->nit}} </h4>
                    </div> 
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Nombre Cliente:</strong> {{$abonomaestro[0]->nombre_comercial}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Concepto:</strong> {{$abonomaestro[0]->concepto}} </h4>
                    </div>
                </div>
                <br>
                <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width=15% style="font-size:15px; text-align:left;">Serie</th>
                                <th width=15% style="font-size:15px; text-align:center;">Documento</th>
                                <th width=15% style="font-size:15px; text-align:right;">Fecha</th>
                                <th width=15% style="font-size:15px; text-align:right;">Monto</th>
                                <th width=15% style="font-size:15px; text-align:right;">Saldo</th>
                                <th width=15% style="font-size:15px; text-align:right;">Abono</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($abonodetalle as $md)
                            <tr>
                                <td style="font-size:13px; text-align:left;">{{$md->serie}}</td>
                                <td style="font-size:13px; text-align:center;">{{ $md->correlativo_documento }}</td>
                                <td style="font-size:13px; text-align:center;">{{Carbon\Carbon::parse($md->fecha_documento)->format('d-m-Y')}}</td>
                                <td style="font-size:13px; text-align:right;">Q. {{{number_format((float) $md->total-$md->descuento_valores-$md->descuento_porcentaje, 2) }}}</td>
                                <td style="font-size:13px; text-align:right;">Q. {{{number_format((float) $md->saldo, 2) }}}</td>
                                <td style="font-size:13px; text-align:right;">Q. {{{number_format((float) $md->total_pagado, 2) }}}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <br>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 text-left">
                                <h4><strong>Usuario que Creó:</strong> {{$abonomaestro[0]->name}} </h4>
                            </div>
                            <div class="col-md-6 col-sm-6 text-right">
                                <h3><strong>Total:</strong> Q. {{{number_format((float) $abonomaestro[0]->total, 2) }}}</h3>
                            </div>
                    </div>
                    <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('abonos.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
