@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Series
          <small>Editar Series</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('series.index')}}"><i class="fa fa-list"></i> Series</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="SerieEditForm"  action="{{route('series.update', $serie)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                    <div class="row">
                            <div class="col-sm-4">
                                <label for="serie">Serie:</label>
                                <input type="text" onkeyup="mayus(this);" class="form-control" placeholder="Serie" name="serie" id="serie" value="{{old('serie', $serie->serie)}}">
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <label for="fecha_vence">Fecha Vencimiento:</label>
                                <div class="input-group date" id="fecha_vence">
                                    <input class="form-control" name="fecha_vence" id="fecha_vence" placeholder="Fecha Vencimiento" value="{{old('fecha_vencimiento', $serie->fecha_vencimiento)}}">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="documento_id">Documento</label>
                                <select name="documento_id" class="form-control">
                                        <option value="0">Seleccione una opción</option>
                                        @foreach ($documentos as $doc)
                                        @if ($doc->id == $serie->documento_id)
                                            <option value="{{$doc->id}}" selected >{{$doc->descripcion}}</option>
                                        @else
                                            <option value="{{$doc->id}}">{{$doc->descripcion}}</option>
                                        @endif
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('series.index') }}">Regresar</a>
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
    
    $('#fecha_vence').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    });


    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

</script>

<script src="{{asset('js/series/edit.js')}}"></script>
@endpush
