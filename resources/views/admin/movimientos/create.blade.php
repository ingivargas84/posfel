@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        MOVIMIENTOS
        <small>Registrar un Movimiento</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('movimientos.index')}}"><i class="fa fa-list"></i> Movimientos</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="MovimientoForm" action="{{route('movimientos.save')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="serie_id">Serie Documento:</label>
                        <select name="serie_id" class="form-control" id="serie_id" tabindex="1">
                            <option value="default">Seleccione una Serie</option>
                            @foreach ($series as $s)
                            <option value="{{$s->id}}">{{$s->serie}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="correlativo_documento">Correlativo Documento:</label>
                        <input type="number" class="form-control" name="correlativo_documento" placeholder="Correlativo Documento" id="correlativo_documento" tabindex="2">
                    </div>
                    <div class="col-md-4 col-sm-4">
                            <label for="fecha_documento">Fecha Documento:</label>
                            <div class="input-group date" id="fecha_documento_dp">
                            <input class="form-control" name="fecha_documento" id="fecha_documento" placeholder="Fecha Documento" tabindex="3">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">

                    <div class="col-md-4 col-sm-4">
                        <label  for="tipo_documento_id">Tipo Documento:</label>
                        <select name="tipo_documento_id" class="form-control" id="tipo_documento_id" tabindex="4">
                            <option value="default">Seleccione un Tipo de Documento</option>
                            @foreach ($tipo_documento as $td)
                            <option value="{{$td->id}}">{{$td->tipo_documento}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-md-3 col-sm-3">
                        <label  id="lbl_proveedor_id" name="lbl_proveedor_id" for="proveedor_id">Proveedor:</label>
                        <select  name="proveedor_id" class="selectpicker form-control" data-live-search="true" id="proveedor_id" tabindex="5">
                            <option value="default">Seleccione un Proveedor</option>
                            @foreach ($proveedores as $pr)
                            <option value="{{$pr->id}}">{{$pr->codigo}} - {{$pr->nombre_comercial}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label  id="lbl_cliente_id" name="lbl_cliente_id" for="cliente_id">Cliente:</label>
                        <select  name="cliente_id" class="selectpicker form-control" data-live-search="true" id="cliente_id" tabindex="6">
                            <option value="default">Seleccione un Cliente</option>
                            @foreach ($clientes as $cl)
                            <option value="{{$cl->id}}">{{$cl->codigo}} - {{$cl->nombre_comercial}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label  id="lbl_bodega_origen_id" name="lbl_bodega_origen_id" for="bodega_origen_id">Bodega Origen:</label>
                        <select  name="bodega_origen_id" class="form-control" id="bodega_origen_id" tabindex="7">
                            <option value="default">Seleccione una Bodega de Origen</option>
                            @foreach ($bodegas as $bod)
                            <option value="{{$bod->id}}">{{$bod->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label  id="lbl_bodega_destino_id" name="lbl_bodega_destino_id" for="bodega_destino_id">Bodega Destino:</label>
                        <select  name="bodega_destino_id" class="form-control" id="bodega_destino_id" tabindex="8">
                            <option value="default">Seleccione una Bodega de Destino</option>
                            @foreach ($bodegas as $bod1)
                            <option value="{{$bod1->id}}">{{$bod1->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label for="observaciones">Observaciones:</label>
                        <input type="text" class="form-control" name="observaciones" placeholder="Observaciones" id="observaciones" tabindex="9">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="articulo_id">Artículo:</label>
                        <select name="articulo_id" class="selectpicker form-control" data-live-search="true" id="articulo_id" tabindex="10">
                            <option value="default">Seleccione un Artículo</option>
                            @foreach ($articulos as $art)
                            <option value="{{$art->id}}">{{$art->codigo_articulo}} - {{$art->descripcion}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" class="form-control" name="desc_art" id="desc_art" tabindex="11">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" class="form-control" placeholder="Cantidad" name="cantidad" id="cantidad" tabindex="12">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="precio_unitario">Valor Unitario:</label>
                        <input type="number" class="form-control" placeholder="Valor Unitario" name="precio_unitario" id="precio_unitario" tabindex="13">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" placeholder="Subtotal" name="subtotal" id="subtotal" disabled tabindex="14">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="text-left m-t-15">
                            <h3>Detalle</h3>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right m-t-15" style="margin-top: 15px; margin-bottom: 10px">
                            <button id="agregar-detalle" class="btn btn-success form-button">Agregar al detalle</button>
                        </div>
                    </div>
                </div>
                <br>
                <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
                </table>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="total">Total:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q.</span>
                            <input type="text" class="form-control customreadonly" placeholder="Total Artículos" name="total" id="total" tabindex="15">
                        </div>
                    </div>
                </div>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('movimientos.index') }}">Regresar</a>
                    <button id="ButtonMovimiento" class="btn btn-success form-button">Guardar</button>
                </div>
                <br>

            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

<style>
    div.col-md-6 {
        margin-bottom: 15px;
    }

    .customreadonly {
        background-color: #eee;
        cursor: not-allowed;
        pointer-events: none;
    }

    .switch-field {
        display: flex;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
        width: 50%
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #55bd8c;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

</style>

@endpush

@push('scripts')

<script>
    //datepicker settings
    $('#fecha_documento_dp').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());

  
    $("#MovimientoForm").show(function () {
    document.getElementById("proveedor_id").disabled = false;
    document.getElementById("cliente_id").disabled = false;
    document.getElementById("bodega_origen_id").disabled = true;
    document.getElementById("bodega_destino_id").disabled = true;
});


    $("#tipo_documento_id").change(function () {
    var tipo_documento_id = $("#tipo_documento_id").val();

    if (tipo_documento_id == 1) {
        document.getElementById("proveedor_id").disabled = false;
        document.getElementById("cliente_id").disabled = true;
        document.getElementById("bodega_origen_id").disabled = false;
        document.getElementById("bodega_destino_id").disabled = true;
    }else if (tipo_documento_id == 2) {
        document.getElementById("proveedor_id").disabled = true;
        document.getElementById("cliente_id").disabled = false;
        document.getElementById("bodega_origen_id").disabled = false;
        document.getElementById("bodega_destino_id").disabled = true;
    }else if (tipo_documento_id == 3) {
        document.getElementById("proveedor_id").disabled = true;
        document.getElementById("cliente_id").disabled = true;
        document.getElementById("bodega_origen_id").disabled = false;
        document.getElementById("bodega_destino_id").disabled = false;
    }

});


    $("#articulo_id").change(function () {
	var articulo_id = $("#articulo_id").val();
	var url = "/movimientos/getArticulo/" + articulo_id ;
	if (articulo_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='desc_art'] ").val(result[0].descripcion);
		});
	}
    });


    $("#serie_id").change(function () {
	var serie_id = $("#serie_id").val();
	var url = "/movimientos/getSerie/" + serie_id ;
	if (serie_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='correlativo_documento'] ").val(result[0].correlativo);
		});
	    }
    });


    $(document).on('focusout', '#precio_unitario', function() {
        $('#subtotal').val(parseInt($('#cantidad').val())*parseFloat($('#precio_unitario').val()));
    });


    function chkflds() {
        if ($('#cantidad').val() && $('#precio_unitario').val()) {
            return true
        } else {
            return false
        }
    }


    $('#agregar-detalle').click(function(e) {
        e.preventDefault();
        if (chkflds()) {
            //calculates the subtotal
            var subt = parseFloat($('#precio_unitario').val()) * parseFloat($('#cantidad').val());
            //limits subtotal decimal places to two
            subt = subt.toFixed(2);
            //adds the form data to the table
            detalle_table.row.add({
                'articulo_id': $('#articulo_id').val(),
                'articulo': $('#desc_art').val(),
                'cantidad': $('#cantidad').val(),
                'precio_unitario': $('#precio_unitario').val(),
                'subtotal': subt
            }).draw();
            //adds all subtotal row data and sets the total input
            var total = 0;
            detalle_table.column(4).data().each(function(value, index) {
                total = total + parseFloat(value);
                // parseFloat(total);
                $('#total').val(total.toFixed(2));
                $('#total-error').remove();
            });
            //resets form data
            $('#articulo_id').val('default');
            $('#desc_art').val(null);
            $('#cantidad').val(null);
            $('#precio_unitario').val(null);
            $('#subtotal').val(null);
        } else {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Debe seleccionar un artículo, ingresar cantidad o precio')
        }
    });



    $(document).on('click', '#ButtonMovimiento', function(e) {
        e.preventDefault();
        if ($('#MovimientoForm').valid()) {
            var arr1 = $('#MovimientoForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('movimientos.save')}}",
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(), 
                },
                data: JSON.stringify(arr3), 
                dataType: 'json',
                success: function() {
                    $('#serie_documento').val(null);
                    $('#correlativo_documento').val(null);
                    $('#fecha_documento').val(null);
                    $('#tipo_documento_id').val('default');
                    $('#bodega_origen_id').val('default');
                    $('#bodega_destino_id').val('default');
                    $('#observaciones').val(null);
                    $('#articulo_id').val('default');
                    $('#desc_art').val(null);
                    $('#cantidad').val(null);
                    $('#precio_unitario').val(null);
                    $('#subtotal').val(null);
                    $('#total').val(null);
                    detalle_table.rows().remove().draw();
                    window.location.assign('/movimientos')
                },
                error: function() {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar el movimiento')
                }
            })
        }
    });

</script>

<script src="{{asset('js/movimientos/detalle.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/movimientos/create.js')}}"></script>{{-- validator --}}
@endpush
