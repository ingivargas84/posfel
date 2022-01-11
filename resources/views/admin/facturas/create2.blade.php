@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Factura
        <small>Registrar una Factura</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('facturas.index')}}"><i class="fa fa-list"></i> Facturas</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="FacturaForm2" action="{{route('facturas.save')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="tipo_factura_id">Tipo Factura:</label>
                        <select name="tipo_factura_id" class="form-control" id="tipo_factura_id" tabindex="1">
                            <option value="default">Seleccione un Tipo de Factura</option>
                            @foreach ($tipo_factura as $tf)
                            <option value="{{$tf->id}}">{{$tf->tipo_factura}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="orden_compra">Orden de Compra:</label>
                        <input type="text" class="form-control" name="orden_compra" placeholder="Orden de Compra" id="orden_compra" tabindex="2">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="fecha_documento">Fecha Documento:</label>
                            <div class="input-group date" id="fecha_documento">
                            <input class="form-control" name="fecha_documento" id="fecha_documento" placeholder="Fecha Documento" tabindex="3">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                    <label for="cliente_id">Cliente:</label>
                        <select name="cliente_id" class="selectpicker form-control" data-live-search="true" id="cliente_id" tabindex="1">
                            <option value="default">Seleccione un Cliente</option>
                            @foreach ($clientes as $cl)
                            <option value="{{$cl->id}}">{{$cl->codigo}} - {{$cl->nombre_comercial}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="nit_cliente">NIT Cliente:</label>
                        <input type="text" class="form-control" name="nit_cliente" placeholder="NIT Cliente" id="nit_cliente" tabindex="6">
                    </div>
                    <div class="col-md-6 col-sm-6">
                    <label for="nombre_cliente">Nombre Cliente:</label>
                        <input type="text" class="form-control" name="nombre_cliente" placeholder="Nombre Cliente" id="nombre_cliente" tabindex="8">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label for="direccion_cliente">Direccion Cliente:</label>
                        <input type="text" class="form-control" name="direccion_cliente" placeholder="Dirección Cliente" id="direccion_cliente" tabindex="6">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="exenta">Exenta</label>
                        <select name="exenta" class="form-control" tabindex="16">
                            <option value="No">No</option>
                            <option value="Si">Si</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="descuento_porcentaje">Descuento (Porcentaje - %):</label>
                        <input type="text" class="form-control" name="descuento_porcentaje" placeholder="Descuento Porcentaje" id="descuento_porcentaje" tabindex="11">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="descuento_valores">Descuento (Valores):</label>
                        <input type="text" class="form-control" name="descuento_valores" placeholder="Descuento Valores" id="descuento_valores" tabindex="12">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="transportado_por">Transportado por:</label>
                        <input type="text" class="form-control" name="transpotado_por" id="transpotado_por" tabindex="19" value="NUESTRO TRANSPORTE">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label for="envios">Envios:</label>
                        <input type="text" class="form-control" name="envios" placeholder="Envios" id="envios" tabindex="20">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="articulo_id">Artículo:</label>
                        <select name="articulo_id" class="selectpicker form-control" data-live-search="true" id="articulo_id" tabindex="23">
                            <option value="default">Seleccione un Artículo</option>
                            @foreach ($articulos as $art)
                            <option value="{{$art->id}}">{{$art->codigo_articulo}} - {{$art->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="desc_art">.</label>
                        <input type="text" class="form-control" name="desc_art" id="desc_art" tabindex="24">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" class="form-control" placeholder="Cantidad" name="cantidad" id="cantidad" tabindex="25">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="precio_unitario">Valor Unitario:</label>
                        <input type="number" class="form-control" placeholder="Valor Unitario" name="precio_unitario" id="precio_unitario" tabindex="26">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" placeholder="Subtotal" name="subtotal" id="subtotal" disabled tabindex="27">
                    </div>
                </div>
                <input type="text" class="form-control" name="ebodega" id="ebodega" disabled tabindex="30">
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
                            <input type="text" class="form-control customreadonly" placeholder="Total Factura" name="total" id="total" tabindex="29">
                        </div>
                    </div>
                </div>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('facturas.index') }}">Regresar</a>
                    <button id="ButtonFactura2"  class="btn btn-success form-button">Guardar</button>
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




    $("#articulo_id").change(function () {
	var articulo_id = $("#articulo_id").val();
	var url = "/cotizaciones/getArticulo/" + articulo_id ;
	if (articulo_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='desc_art'] ").val(result[0].descripcion);
            $("input[name='precio_unitario'] ").val(result[0].precio_quetzales);

            $filas = result.length;
            $ebodegas = "";
            $etotal = 0;

            for(i=0; i<$filas; i++){
                $ebodegas = $ebodegas + result[i].bodega + ": " + result[i].existencia + "; ";
                $etotal = parseInt($etotal) + parseInt(result[i].existencia);
            }
            $("input[name='ebodega'] ").val("Total Existencias: " + $etotal + "; " + $ebodegas);
		    });
	}
    });


    $("#cliente_id").change(function () {
	var cliente_id = $("#cliente_id").val();

    if (cliente_id == 0){
        document.getElementById("nit_cliente").disabled = false;
        document.getElementById("nit_cliente").focus();
        document.getElementById("nombre_cliente").disabled = false;
        document.getElementById("direccion_cliente").disabled = false;
    }
    else{
	var url = "/cotizaciones/getCliente/" + cliente_id ;
	if (cliente_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='nit_cliente'] ").val(result[0].nit);
            $("input[name='nombre_cliente'] ").val(result[0].nombre_comercial);
            $("input[name='direccion_cliente'] ").val(result[0].direccion_comercial);
            $("input[name='descuento_porcentaje'] ").val(result[0].descuento_autorizado);
            $("input[name='descuento_valores'] ").val("0");
		});
	}   
    }
    });



    $(document).on('focusout', '#precio_unitario', function() {
        $('#subtotal').val(parseInt($('#cantidad').val())*parseFloat($('#precio_unitario').val()));
    });



    $(document).on('focusout', '#nit_cliente', function() {

        var nit = $("#nit_cliente").val();

        var url = "/facturas/getCliente/" + nit ;
	    if (nit != "") {
		    $.getJSON( url , function ( result ) {
			    $("input[name='nombre_cliente'] ").val(result.body.nombre);
                $("input[name='direccion_cliente'] ").val("Ciudad");
                $("input[name='descuento_valores'] ").val("0");
                $("input[name='descuento_porcentaje'] ").val("0");
		    });
	    }

    });



    $("#fecha_documento").change(function () {
        var fecfec = ($("input[name='fecha_documento'] ").val()).substr(3,2);
        var fecha = new Date;
        var mes = fecha.getMonth() + 1;

        if (fecfec != mes){
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('La fecha seleccionada debe pertenecer al presente mes, corregirlo por favor')

        }
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


    $(document).on('click', '#ButtonFactura2', function(e) {
        e.preventDefault();

        $desc =  ((parseFloat($('#total').val()) * parseFloat($('#descuento_porcentaje').val())) /100) + parseFloat($('#descuento_valores').val());
        if ($('#FacturaForm2').valid()) {
            if( $desc < $('#total').val() ) {

                var btnAceptar = document.getElementById("ButtonFactura");
                var disableButton = function() { this.disabled = true; };
        
                if (btnAceptar)
                {
                    btnAceptar.addEventListener('click', disableButton , false);
                }
                
            var arr1 = $('#FacturaForm2').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('facturas.save2')}}",
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(),
                },
                data: JSON.stringify(arr3),
                dataType: 'json',
                success: function() {
                    $('#serie_id').val('default');
                    $('#cliente_id').val('default');
                    $('#correlativo_documento').val(null);
                    $('#fecha_documento').val(null);
                    $('#tipo_factura_id').val('default');
                    $('#cliente_id').val(null);
                    $('#nit_cliente').val(null);
                    $('#nombre_cliente').val(null);
                    $('#descuento_porcentaje').val(null);
                    $('#descuento_valores').val(null);
                    $('#exenta').val('default');
                    $('#envios').val(null);
                    $('#total').val(null);
                    detalle_table.rows().remove().draw();
                    window.location.assign('/facturas')
                },
                error: function(error) {

                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar la factura')
                }
            })
        }else{

                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error, los descuentos son mayores al total de la cotización')
            }
        }
    });

</script>

<script src="{{asset('js/facturas/detalle.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/facturas/create2.js')}}"></script>{{-- validator --}}
@endpush
