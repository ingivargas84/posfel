@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Documentos
          <small>Editar Documento</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('documentos.index')}}"><i class="fa fa-list"></i> Documentos</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="DocumentoEditForm"  action="{{route('documentos.update', $documento)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" placeholder="Código" name="codigo" value="{{old('codigo', $documento->codigo)}}" >
                            </div>
                            <div class="col-sm-8">
                                <label for="descripcion">Descripción de Bodega:</label>
                                <input type="text" class="form-control" placeholder="Descripcion de Bodega" name="descripcion" value="{{old('descripcion', $documento->descripcion)}}" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tipo_documento_id">Tipo Documento</label>
                                <select name="tipo_documento_id" class="form-control">
                                        @foreach ($tipo_documento as $td)
                                        @if ($td->id == $documento->tipo_documento_id)
                                            <option value="{{$td->id}}" selected >{{$td->tipo_documento}}</option>
                                        @else
                                            <option value="{{$td->id}}">{{$td->tipo_documento}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                            <label for="costea">Costea</label>
                                <select name="costea" class="form-control">
                                <option value="{{$documento->costea}}" selected >{{$documento->costea}}</option>
                                        <option value="0">Seleccione una opción</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                            <label for="imprime">Imprime</label>
                                <select name="imprime" class="form-control">
                                <option value="{{$documento->imprime}}" selected >{{$documento->imprime}}</option>
                                        <option value="0">Seleccione una opción</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('documentos.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonDocumentoUpdate">Actualizar</button>
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

<script src="{{asset('js/documentos/edit.js')}}"></script>
@endpush
