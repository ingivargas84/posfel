@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Reporte de Valorización de Inventario
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptValInventarioForm" action="{{route('reportes.rpt_val_inventario')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="bodega_id">Bodegas:</label>
                                <select name="bodega_id" class="form-control" id="bodega_id" tabindex="1">
                                    <option value="default">Seleccione una Bodega</option>
                                    @foreach ($bodegas as $bd)
                                        <option value="{{$bd->id}}">{{$bd->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label for="articulo_inicial">Articulo Inicial:</label>
                                <select name="articulo_inicial" class="selectpicker form-control" data-live-search="true" id="articulo_inicial" tabindex="1">
                                    <option value="default">Seleccione un artículo inical</option>
                                    @foreach ($articulos as $art)
                                        <option value="{{$art->id}}">{{$art->codigo_articulo}} - {{$art->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label for="articulo_final">Articulo Final:</label>
                                <select name="articulo_final" class="selectpicker form-control" data-live-search="true" id="articulo_final" tabindex="1">
                                    <option value="default">Seleccione el artículo final</option>
                                    @foreach ($articulos as $art)
                                    <option value="{{$art->id}}">{{$art->codigo_articulo}} - {{$art->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptValInventario" class="btn btn-success form-button">Generar XLS</button>
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


@endpush
