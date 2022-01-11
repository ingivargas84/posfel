@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Asignar Roles a Perfiles
          <small>Asignar Rol</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('perfiles.index')}}"><i class="fa fa-list"></i> Perfiles</a></li>
          <li class="active">Asignar Roles</li>
        </ol>
    </section>
@stop

@section('content')
@include('admin.users.confirmarAccionModal')
    <form method="POST" id="GuardaRolForm"  action="{{route('perfiles.guardarol')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="perfil_id">Id Perfil:</label>
                                <input type="text" class="form-control" placeholder="Id" name="perfil_id" value="{{$perfil->id}}" >
                            </div>
                            <div class="col-sm-4">
                                <label for="descripcion">Perfil:</label>
                                <input type="text" class="form-control" placeholder="Rol" name="descripcion" value="{{$perfil->descripcion}}">
                            </div>
                            <div class="col-sm-6">
                                <label for="rol_id">Rol</label>
                                <select name="rol_id" class="form-control">
                                        <option value="0">Seleccione una opción</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{$rol->id}}">{{$rol->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>

                        <h3>
                        Roles Asignados al Perfil: <strong><u>{{$perfil->descripcion}}</u></strong>
                        </h3>
                        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width=20%>Código Rol</th>
                                <th width=35%>Rol</th>
                                <th width=25%>Fecha Asignación</th>
                                <th width=25% style="text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($api_Result as $ap)
                            <tr>
                                <td style="font-size:13px; text-align:left;">{{ $ap->codigo }}</td>
                                <td style="font-size:13px; text-align:left;">{{ $ap->rol }}</td>
                                <td style="font-size:13px; text-align:left;">{{ $ap->created_at }}</td>
                                <td style="font-size:13px; text-align:center;">
                                
                                <a href='#' class='remove-perfil_rol' data-method='delete' data-id='{{ $ap->id }}' data-target='#modalConfirmarAccion' data-toggle='modal'>
                	            <i class='fas fa-trash-alt' title='Eliminar Rol'></i>
                	            </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>

                        <br>
                            
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('perfiles.index') }}">Regresar</a>
                            <button id="ButtonGuardaRol" class="btn btn-success form-button">Guardar</button>
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

  <script src="{{asset('js/perfiles/asignaperfil.js')}}"></script>
@endpush
