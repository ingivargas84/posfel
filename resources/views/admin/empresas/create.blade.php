@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          EMPRESAS
          <small>Crear Empresa</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('empresas.index')}}"><i class="fa fa-list"></i> Empresas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="EmpresaForm"  action="{{route('empresas.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" placeholder="Código" name="codigo" >
                            </div>
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <label for="tipo_persona_id">Tipo Persona</label>
                                <select name="tipo_persona_id" class="form-control">
                                    @foreach ($tipo_persona as $tp)
                                        <option value="{{$tp->id}}">{{$tp->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nombre_comercial">Nombre Comercial</label>
                                <input type="text" class="form-control" name="nombre_comercial" placeholder="Nombre Comercial">
                            </div>
                            <div class="col-sm-6">
                                <label for="razon_social">Razón Social:</label>
                                <input type="text" class="form-control" name="razon_social" placeholder="Razón Social:">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="abreviatura">Abreviatura:</label>
                                <input type="text" class="form-control" placeholder="Abreviatura:" name="abreviatura" >
                            </div>
                            <div class="col-sm-4">
                                <label for="nit">NIT:</label>
                                <input type="text" class="form-control" placeholder="NIT:" name="nit" >
                            </div>
                            <div class="col-sm-4">
                                <label for="num_patronal_igss">Num Patronal IGSS:</label>
                                <input type="text" class="form-control" placeholder="Num Patronal IGSS:" name="num_patronal_igss" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="direccion_comercial">Dirección Comercial:</label>
                                <input type="text" class="form-control" placeholder="Dirección Comercial:" name="direccion_comercial" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="direccion_fiscal">Dirección Fiscal:</label>
                                <input type="text" class="form-control" placeholder="Dirección Fiscal:" name="direccion_fiscal" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <label for="prop_replegal">Propietario o Representante Legal:</label>
                                <input type="text" class="form-control" placeholder="Propietario o Representante Legal:" name="prop_replegal" >
                            </div>
                            <div class="col-sm-4">
                                <label for="nit_prop_replegal">NIT Propietario o Representante Legal:</label>
                                <input type="text" class="form-control" placeholder="NIT Propietario o Rep Legal:" name="nit_prop_replegal" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <label for="nombre_contador">Nombre Contador:</label>
                                <input type="text" class="form-control" placeholder="Nombre Contador:" name="nombre_contador" >
                            </div>
                            <div class="col-sm-4">
                                <label for="nit_contador">NIT Contador:</label>
                                <input type="text" class="form-control" placeholder="NIT Contador:" name="nit_contador" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('empresas.index') }}">Regresar</a>
                            <button id="ButtonEmpresa" class="btn btn-success form-button">Guardar</button>
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



<script src="{{asset('js/empresas/create.js')}}"></script>
@endpush
