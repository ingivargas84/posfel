@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Vendedores
          <small>Editar Vendedores</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('vendedores.index')}}"><i class="fa fa-list"></i> Vendedores</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="VendedorEditForm"  action="{{route('vendedores.update', $vendedor)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" placeholder="Código" name="codigo" value="{{old('codigo', $vendedor->codigo)}}" >
                            </div>
                            <div class="col-sm-4">
                                <label for="nombres">Nombres:</label>
                                <input type="text" class="form-control" placeholder="Nombres" name="nombres" value="{{old('nombres', $vendedor->nombres)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" placeholder="Apellidos" name="apellidos" value="{{old('apellidos', $vendedor->apellidos)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="dpi">DPI:</label>
                                <input type="text" class="form-control" placeholder="DPI" name="dpi" value="{{old('dpi', $vendedor->dpi)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="puesto">Puesto:</label>
                                <input type="text" class="form-control" placeholder="Puesto" name="puesto" value="{{old('puesto', $vendedor->puesto)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="fecha_ing">Fecha de Ingreso:</label>
                                <div class="input-group date" id="fecha_ing">
                                    <input class="form-control" name="fecha_ing" id="fecha_ing" placeholder="Fecha Ingreso" value="{{old('fecha_ingreso', $vendedor->fecha_ingreso)}}">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="porcentaje_comision">Porcentaje de Comisión:</label>
                                <input type="text" class="form-control" placeholder="% Comisión" name="porcentaje_comision" value="{{old('porcentaje_comision', $vendedor->porcentaje_comision)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" placeholder="Dirección" name="direccion" value="{{old('direccion', $vendedor->direccion)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="user_asignado_id">Asignar Usuario</label>
                                <select name="user_asignado_id" class="form-control">
                                        <option value="0">Seleccione una opción</option>
                                        @foreach ($users as $us)
                                            @if ($us->id == $vendedor->user_asignado_id)
                                                <option value="{{$us->id}}" selected >{{$us->name}}</option>
                                            @else
                                                <option value="{{$us->id}}">{{$us->name}}</option>
                                            @endif
                                        @endforeach
                                </select>

                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('vendedores.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonSerieUpdate">Actualizar</button>
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

<script>
    
    $('#fecha_ing').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    });



</script>

<script src="{{asset('js/vendedores/edit.js')}}"></script>
@endpush
