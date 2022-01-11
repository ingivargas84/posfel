@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          PROVEEDORES
          <small>Editar Proveedor</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('proveedores.index')}}"><i class="fa fa-list"></i> Proveedores</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ProveedorUpdateForm"  action="{{route('proveedores.update', $proveedor)}}">
            {{csrf_field()}} {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" placeholder="Código:" name="codigo" value="{{old('codigo', $proveedor->codigo)}}"  >
                            </div>
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <label for="tipo_proveedor_id">Tipo Proveedor</label>
                                <select name="tipo_proveedor_id" class="form-control">
                                    @foreach ($tipo_proveedor as $tp)
                                        @if ($tp->id == $proveedor->tipo_proveedor_id)
                                            <option value="{{$tp->id}}" selected >{{$tp->tipo_proveedor}}</option>
                                        @else
                                            <option value="{{$tp->id}}">{{$tp->tipo_proveedor}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div> 
                        </div>
                        <br>                
                        <div class="row">
                        <div class="col-sm-6">
                                <label for="nombre_comercial">Nombre Comercial:</label>
                                <input type="text" class="form-control" placeholder="Nombre Comercial:" name="nombre_comercial" value="{{old('nombre_comercial', $proveedor->nombre_comercial)}}" >
                            </div>
                            <div class="col-sm-6">
                                <label for="razon_social">Razón Social:</label>
                                <input type="text" class="form-control" placeholder="Razón Social:" name="razon_social" value="{{old('razon_social', $proveedor->razon_social)}}" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="abreviatura">Abreviatura:</label>
                                <input type="text" class="form-control" placeholder="Abreviatura:" name="abreviatura"  value="{{old('abreviatura', $proveedor->abreviatura)}}" >
                            </div>
                            <div class="col-sm-6">
                                <label for="prop_replegal">Propietario o Representante Legal:</label>
                                <input type="text" class="form-control" placeholder="Propietario o Representante Legal:" name="prop_replegal"  value="{{old('prop_replegal', $proveedor->prop_replegal)}}" >
                            </div>
                            <div class="col-sm-3">
                                <label for="nit">Número Identificación Tributaria:</label>
                                <input type="text" class="form-control" placeholder="NIT:" name="nit"  value="{{old('nit', $proveedor->nit)}}" >
                            </div>                                
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-9">
                                <label for="direccion_comercial">Dirección Comercial:</label>
                                <input type="text" class="form-control" placeholder="Dirección Comercial:" name="direccion_comercial" value="{{old('direccion_comercial', $proveedor->direccion_comercial)}}" >
                            </div>
                            <div class="col-sm-3">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" placeholder="Teléfono" name="telefono" value="{{old('telefono', $proveedor->telefono)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="dias_credito">Días de Crédito:</label>
                                <input type="text" class="form-control" placeholder="Dias de Crédito" name="dias_credito" value="{{old('dias_credito', $proveedor->dias_credito)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="correo_electronico">Correo Electrónico:</label>
                                <input type="text" class="form-control" placeholder="Correo Electrónico" name="correo_electronico" value="{{old('correo_electronico', $proveedor->correo_electronico)}}">
                            </div>
                            <div class="col-sm-6">
                                <label for="cuenta_contable">Cuenta Contable:</label>
                                <input type="text" class="form-control" placeholder="Cuenta Contable" name="cuenta_contable" value="{{old('cuenta_contable', $proveedor->cuenta_contable)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="contacto">Contacto:</label>
                                <input type="text" class="form-control" placeholder="Contacto" name="contacto" value="{{old('contacto', $proveedor->contacto)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="telefono_contacto">Teléfono Contacto:</label>
                                <input type="text" class="form-control" placeholder="Teléfono Contacto" name="telefono_contacto" value="{{old('telefono_contacto', $proveedor->telefono_contacto)}}">
                            </div>
                            <div class="col-sm-3">
                            <label for="isr">Sujeto a Retención ISR</label>
                                <select name="isr" class="form-control">
                                    <option value="{{$proveedor->isr}}" selected >{{$proveedor->isr}}</option>
                                    <option value="0">Seleccione una opción</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="observaciones">Observaciones:</label>
                                <input type="text" class="form-control" placeholder="Observaciones" name="observaciones" value="{{old('observaciones', $proveedor->observaciones)}}">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('proveedores.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonProveedorUpdate">Guardar</button>
                        </div>
                                    
                    </div>
                </div>                
            </div>
    </form>
    <div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush


@push('scripts')

<script src="{{asset('js/proveedores/edit.js')}}"></script>
@endpush