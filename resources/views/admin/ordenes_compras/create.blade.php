@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Ordenes de Compras
        <small>Registrar una Orden de Compra</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('ordenes_compras.index')}}"><i class="fa fa-list"></i> Ordenes de Compra</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="OrdenCompraForm" action="{{route('ordenes_compras.save')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="serie_id">Serie Documento:</label>
                        <select name="serie_id" class="form-control" id="serie_id" tabindex="1">
                            <option value="default">Seleccione una Serie</option>
                            @foreach ($series as $s)
                            <option value="{{$s->id}}">{{$s->serie}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="correlativo_documento">Correlativo Documento:</label>
                        <input type="number" class="form-control" name="correlativo_documento" placeholder="Correlativo Documento" id="correlativo_documento" tabindex="2">
                    </div>
                    <div class="col-md-3 col-sm-3">
                            <label for="fecha_documento">Fecha Documento:</label>
                            <div class="input-group date" id="fecha_documento">
                            <input class="form-control" name="fecha_documento" id="fecha_documento" placeholder="Fecha Documento" tabindex="3">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="tipo_documento_importacion_id">Tipo Documento:</label>
                        <select name="tipo_documento_importacion_id" class="form-control" id="tipo_documento_importacion_id" tabindex="4">
                            <option value="default">Seleccione un Tipo de Documento</option>
                            @foreach ($tipo_documento_importacion as $td)
                            <option value="{{$td->id}}">{{$td->tipo_documento_importacion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="proveedor_id">Proveedor:</label>
                        <select name="proveedor_id" class="selectpicker form-control" data-live-search="true" id="proveedor_id" tabindex="5" >
                            <option value="default">Seleccione un Proveedor</option>
                            @foreach ($proveedores as $pro)
                            <option value="{{$pro->id}}">{{$pro->codigo}} - {{$pro->nombre_comercial}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="nit_proveedor">NIT Proveedor:</label>
                        <input disabled type="text" class="form-control" name="nit_proveedor" placeholder="NIT Proveedor" id="nit_proveedor" tabindex="6">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="dias_credito_proveedor">Dias de Crédito:</label>
                        <input disabled type="text" class="form-control" name="dias_credito_proveedor" placeholder="Dias Crédito Proveedor" id="dias_credito_proveedor" tabindex="7">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="nombre_proveedor">Nombre Proveedor:</label>
                        <input disabled type="text" class="form-control" name="nombre_proveedor" placeholder="Nombre Proveedor" id="nombre_proveedor" tabindex="8">
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="direccion_proveedor">Dirección Proveedor:</label>
                        <input disabled type="text" class="form-control" name="direccion_proveedor" placeholder="Dirección Proveedor" id="direccion_proveedor" tabindex="9">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="atencion_a">Atención A:</label>
                        <input type="text" class="form-control" name="atencion_a" placeholder="Atención A" id="atencion_a" tabindex="10">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="solicito">Persona que Solicita:</label>
                        <input type="text" class="form-control" name="solicito" placeholder="Persona que Solicita" id="solicito" tabindex="11">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="lugar_entrega">Lugar de Entrega:</label>
                        <input type="text" class="form-control" name="lugar_entrega" placeholder="Lugar de Entrega" id="lugar_entrega" tabindex="12">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="tipo_pago_id">Tipo Pago:</label>
                        <select name="tipo_pago_id" class="form-control" id="tipo_pago_id" tabindex="13">
                            <option value="default">Seleccione un Tipo de Pago</option>
                            @foreach ($tipo_pago as $tp)
                            <option value="{{$tp->id}}">{{$tp->tipo_pago}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                            <label for="fecha_entrega">Fecha Entrega:</label>
                            <div class="input-group date" id="fecha_entrega">
                            <input class="form-control" name="fecha_entrega" id="fecha_entrega" placeholder="Fecha Entrega" tabindex="14">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="preparado_por">Preparado por:</label>
                        <input disabled type="text" class="form-control" name="preparado_por" placeholder="Preparado por" id="preparado_por" tabindex="15" value="{{{ $crea }}}">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="autoriza_id">Autorizado por:</label>
                        <select name="autoriza_id" class="form-control" id="autoriza_id" tabindex="16">
                            <option value="default">Seleccione quien Autoriza</option>
                            @foreach ($autoriza as $a)
                            <option value="{{$a->id}}">{{$a->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label for="observaciones">Observaciones:</label>
                        <input type="text" class="form-control" name="observaciones" placeholder="Observaciones" id="observaciones" tabindex="17">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="articulo_id">Artículo:</label>
                        <select name="articulo_id" class="selectpicker form-control" data-live-search="true" id="articulo_id" tabindex="18">
                            <option value="default">Seleccione un Artículo</option>
                            @foreach ($articulos as $art)
                            <option value="{{$art->id}}">{{$art->codigo_articulo}} - {{$art->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="desc_art">.</label>
                        <input type="text" class="form-control" name="desc_art" id="desc_art" tabindex="20">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" class="form-control" placeholder="Cantidad" name="cantidad" id="cantidad" tabindex="21">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="precio_unitario">Valor Unitario:</label>
                        <input type="number" class="form-control" placeholder="Valor Unitario" name="precio_unitario" id="precio_unitario" tabindex="22">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" placeholder="Subtotal" name="subtotal" id="subtotal" disabled tabindex="23">
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
                            <input type="text" class="form-control customreadonly" placeholder="Total Orden Compra" name="total" id="total" tabindex="24">
                        </div>
                    </div>
                </div>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('ordenes_compras.index') }}">Regresar</a>
                    <button id="ButtonOrdenCompra" class="btn btn-success form-button">Guardar</button>
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
    $('#fecha_documento').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());


    $('#fecha_entrega').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());


    $("#articulo_id").change(function () {
	var articulo_id = $("#articulo_id").val();
	var url = "/ordenes_compras/getArticulo/" + articulo_id ;
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
    

    $("#proveedor_id").change(function () {
	var proveedor_id = $("#proveedor_id").val();
	var url = "/ordenes_compras/getProveedor/" + proveedor_id ;
	if (proveedor_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='nit_proveedor'] ").val(result[0].nit);
            $("input[name='nombre_proveedor'] ").val(result[0].nombre_comercial);
            $("input[name='dias_credito_proveedor'] ").val(result[0].dias_credito);
            $("input[name='direccion_proveedor'] ").val(result[0].direccion_comercial);
            $("input[name='atencion_a'] ").val(result[0].contacto);
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
            $('#articulo_id').val("default");
            $('#articulo_id').focus();
            $('#desc_art').val(null);
            $('#cantidad').val(null);
            $('#precio_unitario').val(null);
            $('#subtotal').val(null);
        } else {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Debe seleccionar un artículo, ingresar cantidad o precio')
        }
    });



    $(document).on('click', '#ButtonOrdenCompra', function(e) {
        e.preventDefault();

        if ($('#OrdenCompraForm').valid()) {

            var btnAceptar = document.getElementById("ButtonOrdenCompra");
            var disableButton = function() { this.disabled = true; };
        
            if (btnAceptar)
            {
                btnAceptar.addEventListener('click', disableButton , false);
            }

            var arr1 = $('#OrdenCompraForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('ordenes_compras.save')}}",
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(), 
                },
                data: JSON.stringify(arr3), 
                dataType: 'json',
                success: function() {
                    $('#serie_documento').val(null);
                    $('#correlativo_documento').val(null);
                    $('#fecha_documento').val(null);
                    $('#tipo_documento_importacion_id').val('default');
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
                    window.location.assign('/ordenes_compras')
                },
                error: function() {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar la orden de compra')
                }
            })
        }
    });

</script>

<script src="{{asset('js/ordenes_compras/detalle.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/ordenes_compras/create.js')}}"></script>{{-- validator --}}
@endpush
