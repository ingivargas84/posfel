@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Clientes
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('clientes.index')}}"><i class="fa fa-list"></i> Clientes</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="ClienteShowForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Cliente</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Código:</strong> {{$cliente[0]->codigo}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Tipo Persona:</strong> {{$cliente[0]->tipo_persona}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Abreviatura:</strong> {{$cliente[0]->abreviatura}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>NIT:</strong> {{$cliente[0]->nit}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Nombre Comercial:</strong> {{$cliente[0]->nombre_comercial}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Razón Social:</strong> {{$cliente[0]->razon_social}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Propietario o Rep Legal:</strong> {{$cliente[0]->prop_replegal}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Dirección Comercial:</strong> {{$cliente[0]->direccion_comercial}} </h4>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Teléfono:</strong> {{$cliente[0]->telefono}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Correo Electrónico:</strong> {{$cliente[0]->correo_electronico}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Cuenta Contable:</strong> {{$cliente[0]->cuenta_contable}} </h4>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Nombre Contacto:</strong> {{$cliente[0]->nombre_contacto}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Teléfono Contacto:</strong> {{$cliente[0]->telefono_contacto}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Descuento Autorizado:</strong> {{$cliente[0]->descuento_autorizado}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Lugar Entrega:</strong> {{$cliente[0]->lugar_entrega}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Vendedor:</strong> {{$cliente[0]->nombres}} {{$cliente[0]->apellidos}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Retenedor IVA:</strong> {{$cliente[0]->iva}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Ultima Venta:</strong> {{Carbon\Carbon::parse($cliente[0]->fecha_ultima_venta)->format('d-m-Y')}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Días de Crédito:</strong> {{$cliente[0]->dias_credito}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Saldo Actual:</strong> Q. {{{number_format((float) $cliente[0]->saldo_actual, 2) }}} </h4>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Observaciones:</strong> {{$cliente[0]->observaciones}} </h4>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 col-sm-6 text-left">
                        <h4><strong>Usuario que Creó:</strong> {{$cliente[0]->name}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6 text-right">
                        <h4><strong>Fecha Creación:</strong> {{Carbon\Carbon::parse($cliente[0]->created_at)->format('d-m-Y H:m:s')}}</h4>
                    </div>
                </div>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('clientes.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
