@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Reporte de Libro de Ventas y Servicios Prestados
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptLib_VentasForm" action="{{route('reportes.rpt_lib_ventas')}}" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="serie_id">Serie Documento:</label>
                                <select name="serie_id" class="form-control" id="serie_id" tabindex="1">
                                    <option value="default">Seleccione una Serie</option>
                                    @foreach ($series as $s)
                                        <option value="{{$s->id}}">{{$s->serie}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <label for="fecha_inicial">Fecha Inicial:</label>
                                <div class="input-group date" id="fecha_inicial">
                                    <input class="form-control" name="fecha_inicial" id="fecha_inicial" placeholder="Fecha Inicial" tabindex="2">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <label for="fecha_final">Fecha Final:</label>
                                <div class="input-group date" id="fecha_final">
                                    <input class="form-control" name="fecha_final" id="fecha_final" placeholder="Fecha Final" tabindex="3">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <label for="folio">No Folio:</label>
                                <input type="number" class="form-control" placeholder="No Folio" name="folio" id="folio" tabindex="4">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptLibVentas" class="btn btn-success form-button">Generar XLS</button>
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

<script src="{{asset('js/reportes/rpt_lib_ventas.js')}}"></script>

@endpush
