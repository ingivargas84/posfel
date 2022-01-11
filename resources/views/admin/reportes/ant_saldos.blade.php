@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Reporte de Antigüedad de Saldos
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptFac_EmitidasForm"  action="{{route('reportes.rpt_ant_saldos')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="cliente_id">Cliente:</label>
                                <select name="cliente_id" class="selectpicker form-control" data-live-search="true" id="cliente_id" tabindex="1">
                                    <option value="default">Seleccione un Cliente</option>
                                    @foreach ($clientes as $cl)
                                    <option value="{{$cl->id}}">{{$cl->codigo}} - {{$cl->nombre_comercial}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="vendedor_id">Vendedores</label>
                                <select name="vendedor_id" class="form-control">
                                    <option value="default">Seleccione un Vendedor</option>
                                    @foreach ($vendedores as $ven)
                                        <option value="{{$ven->id}}">{{$ven->nombres}} {{$ven->apellidos}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <label for="fecha_inicial">Fecha Inicial:</label>
                                <div class="input-group date" id="fecha_inicial">
                                    <input class="form-control" name="fecha_inicial" id="fecha_inicial" placeholder="Fecha Inicial" tabindex="4">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <label for="fecha_final">Fecha Final:</label>
                                <div class="input-group date" id="fecha_final">
                                    <input class="form-control" name="fecha_final" id="fecha_final" placeholder="Fecha Final" tabindex="5">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptFacEmitidas" class="btn btn-success form-button">Generar XLS</button>
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
