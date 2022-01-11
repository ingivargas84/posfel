@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Vendedores
          <small>Crear Vendedores</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('vendedores.index')}}"><i class="fa fa-list"></i> Vendedores</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="VendedorForm"  action="{{route('vendedores.save')}}">
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
                                <label for="nombres">Nombres:</label>
                                <input type="text" class="form-control" placeholder="Nombres" name="nombres" >
                            </div>
                            <div class="col-sm-4">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" placeholder="Apellidos" name="apellidos" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="dpi">DPI:</label>
                                <input type="text" class="form-control" placeholder="DPI" name="dpi" >
                            </div>
                            <div class="col-sm-3">
                                <label for="puesto">Puesto:</label>
                                <input type="text" class="form-control" placeholder="Puesto" name="puesto" >
                            </div>
                            <div class="col-sm-3">
                                <label for="fecha_ing">Fecha de Ingreso:</label>
                                <div class="input-group date" id="fecha_ing">
                                    <input class="form-control" name="fecha_ing" id="fecha_ing" placeholder="Fecha Ingreso">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="porcentaje_comision">Porcentaje de Comisión:</label>
                                <input type="text" class="form-control" placeholder="% Comisión" name="porcentaje_comision" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" placeholder="Dirección" name="direccion" >
                            </div>
                            <div class="col-sm-4">
                                <label for="user_asignado_id">Asignar Usuario</label>
                                <select name="user_asignado_id" class="form-control">
                                        <option value="0">Seleccione una opción</option>
                                        @foreach ($users as $us)
                                        <option value="{{$us->id}}">{{$us->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('vendedores.index') }}">Regresar</a>
                            <button id="ButtonVendedor" class="btn btn-success form-button">Guardar</button>
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
    //datepicker settings
    $('#fecha_ing').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());


</script>

<script src="{{asset('js/vendedores/create.js')}}"></script>
@endpush
