@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Bodegas
          <small>Editar Bodega</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('bodegas.index')}}"><i class="fa fa-list"></i> Bodegas</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="BodegaEditForm"  action="{{route('bodegas.update', $bodega)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" placeholder="Código" name="codigo" value="{{old('codigo', $bodega->codigo)}}">
                            </div>
                            <div class="col-sm-8">
                                <label for="descripcion">Descripción de Bodega:</label>
                                <input type="text" class="form-control" placeholder="Bodega" name="descripcion" value="{{old('descripcion', $bodega->descripcion)}}">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('bodegas.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonBodegaUpdate">Actualizar</button>
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

<script src="{{asset('js/bodegas/edit.js')}}"></script>
@endpush
