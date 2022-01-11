@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Generar TXT
        <small>Generar Txt</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('facturas.index')}}"><i class="fa fa-list"></i> Facturas</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="FacturaGeneraForm" action="{{route('facturas.savegeneratxt')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                    <label for="fecha_documento">Fecha de Generación:</label>
                            <div class="input-group date" id="fecha_documento">
                            <input class="form-control" name="fecha_documento" id="fecha_documento" placeholder="Fecha Documento" tabindex="3">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('facturas.index') }}">Regresar</a>
                    <button id="ButtonGeneraFactura" class="btn btn-success form-button">Generar</button>
                </div>
                <br>

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
    $('#fecha_documento').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());

</script>

@endpush