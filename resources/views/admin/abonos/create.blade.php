@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Abonos
        <small>Registrar un Abono</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('abonos.index')}}"><i class="fa fa-list"></i> Abonos</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="AbonoForm" action="{{route('abonos.save')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="tipo_abono_id">Tipo Abono:</label>
                        <select name="tipo_abono_id" class="form-control" id="tipo_abono_id" tabindex="1">
                            <option value="default">Seleccione un Tipo de Abono</option>
                            @foreach ($tipo_abono as $ta)
                            <option value="{{$ta->id}}">{{$ta->tipo_abono}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="serie_id">Serie Documento:</label>
                        <select name="serie_id" class="form-control" id="serie_id" tabindex="2">
                            <option value="default">Seleccione una Serie</option>
                            @foreach ($series as $ser)
                            <option value="{{$ser->id}}">{{$ser->serie}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="correlativo_documento">Correlativo Documento:</label>
                        <input type="number" class="form-control" name="correlativo_documento" placeholder="Correlativo Documento" id="correlativo_documento" tabindex="5">
                    </div>
                    <div class="col-md-3 col-sm-3">
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
                        <select name="cliente_id" class="selectpicker form-control" data-live-search="true" id="cliente_id" tabindex="4">
                            <option value="default">Seleccione un Cliente</option>
                            @foreach ($clientes as $cl)
                            <option value="{{$cl->id}}">{{$cl->codigo}} - {{$cl->nombre_comercial}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="nit_cliente">NIT Cliente:</label>
                        <input disabled type="text" class="form-control" name="nit_cliente" placeholder="NIT Cliente" id="nit_cliente" tabindex="5">
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="nombre_cliente">Nombre Cliente:</label>
                        <input disabled type="text" class="form-control" name="nombre_cliente" placeholder="Nombre Cliente" id="nombre_cliente" tabindex="6">
                    </div>                    
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label for="concepto">Concepto:</label>
                        <input type="text" class="form-control" name="concepto" placeholder="Concepto" id="concepto" tabindex="7">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="factura_maestro_id">Facturas Pendientes de Pago:</label>
                        <select name="factura_maestro_id" class=" form-control"  id="factura_maestro_id" tabindex="8">
                            <option value="default">Seleccione una Factura</option>
                        </select>
                        <input type="hidden" class="form-control" name="factura_id" id="factura_id" tabindex="39">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="serie_factura">Serie Factura:</label>
                        <input type="text" class="form-control" placeholder="Serie Factura" disabled name="serie_factura" id="serie_factura" tabindex="10">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="no_factura">No Factura:</label>
                        <input type="number" class="form-control" placeholder="No Factura" disabled name="no_factura" id="no_factura" tabindex="11">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="fecha_factura">Fecha Factura:</label>
                        <input type="text" class="form-control" placeholder="Fecha Factura" name="fecha_factura" id="fecha_factura" disabled tabindex="12">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="total_factura">Total Factura:</label>
                        <input type="number" class="form-control" placeholder="Total Factura" name="total_factura" id="total_factura" disabled tabindex="12">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="saldo_factura">Saldo:</label>
                        <input type="number" class="form-control" placeholder="Saldo" name="saldo_factura" id="saldo_factura" disabled tabindex="12">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="abono_factura">Abono:</label>
                        <input type="number" class="form-control" placeholder="Abono" name="abono_factura" id="abono_factura"  tabindex="12">
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
                            <input type="text" class="form-control customreadonly" placeholder="Total Cotización" name="total" id="total" tabindex="13">
                        </div>
                    </div>
                </div>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('abonos.index') }}">Regresar</a>
                    <button id="ButtonAbono" class="btn btn-success form-button">Guardar</button>
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
		});
	}
    });


    $("#serie_id").change(function () {
	var serie_id = $("#serie_id").val();
	var url = "/abonos/getSerie/" + serie_id ;
	if (serie_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='correlativo_documento'] ").val(result[0].correlativo);
		});
	}
    });



    $("#cliente_id").change(function () {
	var cliente_id = $("#cliente_id").val();
	var url = "/abonos/getCliente/" + cliente_id ;
	if (cliente_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='nit_cliente'] ").val(result[0].nit);
            $("input[name='nombre_cliente'] ").val(result[0].nombre_comercial);

            for (var i=0; i<result.length; i++){
                document.getElementById("factura_maestro_id").innerHTML += "<option value='"+result[i].fac_id+"'>"+ result[i].serie + "-" + result[i].correlativo_documento + "     |     Total Neto: Q." +  result[i].saldo   + "</option>";
            }
                  
		});
	}
    });


    $("#factura_maestro_id").change(function () {
	var factura_id = $("#factura_maestro_id").val();
	var url = "/abonos/getFacturas/" + factura_id ;
	if (factura_id != "") {
		$.getJSON( url , function ( result ) {
            $("input[name='factura_id'] ").val(result[0].id);
			$("input[name='serie_factura'] ").val(result[0].serie);
            $("input[name='no_factura'] ").val(result[0].correlativo_documento);
            $("input[name='fecha_factura'] ").val(result[0].fecha_documento);
            $("input[name='total_factura'] ").val(result[0].total);
            $("input[name='saldo_factura'] ").val(result[0].saldo);
            $("input[name='abono_factura'] ").val(result[0].total_pagado);
		});
	}
    });




    function chkflds() {
        if ($('#serie_factura').val() && $('#no_factura').val() && $('#abono_factura').val()) {
            return true
        } else {
            return false
        }
    }



    $('#agregar-detalle').click(function(e) {
        e.preventDefault();
        if (chkflds()) {
            
            var abono = $("#abono_factura").val();

            if (abono > 0)
            {
                var saldo = parseFloat($('#saldo_factura').val()) - parseFloat($('#abono_factura').val());

                detalle_table.row.add({
                    'factura_id': $('#factura_id').val(),
                    'serie': $('#serie_factura').val(),
                    'documento': $('#no_factura').val(),
                    'fecha': $('#fecha_factura').val(),
                    'monto': $('#total_factura').val(),
                    'abono': $('#abono_factura').val(),
                    'saldo': saldo
                }).draw();

                var total = 0;
                detalle_table.column(6).data().each(function(value, index) {
                    total = total + parseFloat(value);
                    // parseFloat(total);
                    $('#total').val(total.toFixed(2));
                    $('#total-error').remove();
                });
                //resets form data
                $('#factura_id').val(null);
                $('#factura_maestro_id').val('default');
                $('#serie_factura').val(null);
                $('#no_factura').val(null);
                $('#fecha_factura').val(null);
                $('#total_factura').val(null);
                $('#saldo_factura').val(null);
                $('#abono_factura').val(null);
            } else {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error('El abono debe ser mayor a cero')    
            }
        } else {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Debe seleccionar una factura, o ingresar abono')
        }
    });



    
    $(document).on('click', '#ButtonAbono', function(e) {
        e.preventDefault();

        var btnAceptar = document.getElementById("ButtonAbono");
        var disableButton = function() { this.disabled = true; };
        
        if (btnAceptar)
        {
            btnAceptar.addEventListener('click', disableButton , false);
        }

        if ($('#AbonoForm').valid()) {
            var arr1 = $('#AbonoForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('abonos.save')}}",
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(), 
                },
                data: JSON.stringify(arr3), 
                dataType: 'json',
                success: function() {
                    $('#serie_id').val('default');
                    $('#fecha_documento').val(null);
                    $('#tipo_abono_id').val('default');
                    $('#cliente_id').val(null);
                    $('#nit_cliente').val(null);
                    $('#nombre_cliente').val(null);
                    $('#concepto').val('default');
                    $('#total').val(null);
                    detalle_table.rows().remove().draw();
                    window.location.assign('/abonos')
                },
                error: function() {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar el Abono')
                }
            })
        }
    });

</script>

<script src="{{asset('js/abonos/detalle.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/abonos/create.js')}}"></script>{{-- validator --}}
@endpush
