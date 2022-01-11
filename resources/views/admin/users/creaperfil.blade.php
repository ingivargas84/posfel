@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Asignar Perfil y Empresa a Usuario
          <small>Asignar Perfil y Empresa</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('users.index')}}"><i class="fa fa-list"></i> Usuarios</a></li>
          <li class="active">Asignar Perfil y Empresa</li>
        </ol>
    </section>
@stop

@section('content')
@include('admin.users.confirmarAccionModal')
    <form method="POST" id="AsignaPerfilForm"  action="{{route('users.agregaperfil')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="user_id">Id Usuario:</label>
                                <input type="text" class="form-control" placeholder="Id" name="user_id" value="{{$user->id}}" >
                            </div>
                            <div class="col-sm-4">
                                <label for="name">Usuario:</label>
                                <input type="text" class="form-control" placeholder="Name" name="name" value="{{$user->name}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="perfil_id">Perfil</label>
                                <select name="perfil_id" class="form-control">
                                        <option value="0">Seleccione una opción</option>
                                    @foreach ($perfil as $per)
                                        <option value="{{$per->id}}">{{$per->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="empresa_id">Empresa</label>
                                <select name="empresa_id" class="form-control">
                                        <option value="0">Seleccione una opción</option>
                                    @foreach ($empresas as $emp)
                                        <option value="{{$emp->id}}">{{$emp->nombre_comercial}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('users.index') }}">Regresar</a>
                            <button id="ButtonAsignaPerfil" class="btn btn-success form-button">Guardar</button>
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

  <script src="{{asset('js/users/creaperfil.js')}}"></script>
@endpush
