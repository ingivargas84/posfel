@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Reporte de Ventas por Producto
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptVentas_ProdsForm" action="{{route('reportes.rpt_ventas_prods')}}" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label for="articulo_inicial">Articulo Inicial:</label>
                                <select name="articulo_inicial"class="selectpicker form-control" data-live-search="true" id="articulo_inicial" tabindex="1">
                                    <option value="default">Seleccione un artículo inicial</option>
                                    @foreach ($articulos as $art)
                                        <option value="{{$art->id}}">{{$art->codigo_articulo}} - {{$art->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label for="articulo_final">Articulo Final:</label>
                                <select name="articulo_final" class="selectpicker form-control" data-live-search="true" id="articulo_final" tabindex="2">
                                    <option value="default">Seleccione el artículo final</option>
                                    @foreach ($articulos as $art)
                                    <option value="{{$art->id}}">{{$art->codigo_articulo}} - {{$art->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label for="fecha_inicial">Fecha Inicial:</label>
                                <div class="input-group date" id="fecha_inicial">
                                    <input class="form-control" name="fecha_inicial" id="fecha_inicial" placeholder="Fecha Inicial" tabindex="3">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label for="fecha_final">Fecha Final:</label>
                                <div class="input-group date" id="fecha_final">
                                    <input class="form-control" name="fecha_final" id="fecha_final" placeholder="Fecha Final" tabindex="4">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptVentas_Prods" class="btn btn-success form-button">Generar XLS</button>
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
    $('#fecha_inicial').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());


    $('#fecha_final').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());


</script>


@endpush

