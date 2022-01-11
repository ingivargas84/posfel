@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Roles
          <small>Editar Rol</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('roles.index')}}"><i class="fa fa-list"></i> Roles</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="RolEditForm"  action="{{route('roles.update', $rol)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" placeholder="Código" name="codigo" value="{{old('codigo', $rol->codigo)}}">
                            </div>
                            <div class="col-sm-8">
                                <label for="descripcion">Perfil:</label>
                                <input type="text" class="form-control" placeholder="Perfil" name="descripcion" value="{{old('descripcion', $rol->descripcion)}}">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('perfiles.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonRolUpdate">Actualizar</button>
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

<script src="{{asset('js/roles/edit.js')}}"></script>
@endpush
