@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Proveedores
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('proveedores.index')}}"><i class="fa fa-list"></i> Proveedores</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="ProveedorShowForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Proveedor</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Código:</strong> {{$proveedor[0]->codigo}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Tipo Proveedor:</strong> {{$proveedor[0]->tipo_proveedor}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Abreviatura:</strong> {{$proveedor[0]->abreviatura}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>NIT:</strong> {{$proveedor[0]->nit}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Nombre Comercial:</strong> {{$proveedor[0]->nombre_comercial}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Razón Social:</strong> {{$proveedor[0]->razon_social}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Propietario o Rep Legal:</strong> {{$proveedor[0]->prop_replegal}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Dirección Comercial:</strong> {{$proveedor[0]->direccion_comercial}} </h4>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Teléfono:</strong> {{$proveedor[0]->telefono}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Correo Electrónico:</strong> {{$proveedor[0]->correo_electronico}} </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <h4><strong>Cuenta Contable:</strong> {{$proveedor[0]->cuenta_contable}} </h4>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h4><strong>Nombre Contacto:</strong> {{$proveedor[0]->contacto}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Teléfono Contacto:</strong> {{$proveedor[0]->telefono_contacto}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>ISR:</strong> {{$proveedor[0]->isr}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Ultima Compra:</strong> {{Carbon\Carbon::parse($proveedor[0]->fecha_ultima_compra)->format('d-m-Y')}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Días de Crédito:</strong> {{$proveedor[0]->dias_credito}} </h4>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Observaciones:</strong> {{$proveedor[0]->observaciones}} </h4>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 col-sm-6 text-left">
                        <h4><strong>Usuario que Creó:</strong> {{$proveedor[0]->name}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6 text-right">
                        <h4><strong>Fecha Creación:</strong> {{Carbon\Carbon::parse($proveedor[0]->created_at)->format('d-m-Y H:m:s')}}</h4>
                    </div>
                </div>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('proveedores.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
