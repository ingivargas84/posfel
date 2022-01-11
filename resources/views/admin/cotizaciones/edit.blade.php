@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Cotizaciones
        <small>Editar una Cotización</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('cotizaciones.index')}}"><i class="fa fa-list"></i> Cotizaciones</a></li>
        <li class="active">Editar</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="CotizacionEditForm" name="CotizacionEditForm" action="{{route('cotizaciones.update', $cotizacion_maestro)}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="serie_id">Serie Documento:</label>
                        <select name="serie_id" class="form-control" id="serie_id" tabindex="1">
                            @foreach ($series as $s)
                                @if ($s->id == $cotizacion_maestro->serie_id)
                                    <option value="{{$s->id}}" selected >{{$s->serie}}</option>
                                @else
                                    <option value="{{$s->id}}">{{$s->serie}}</option>
                                @endif
                            @endforeach
                        </select>
                        <input type="hidden" class="form-control" name="maestro_id" id="maestro_id" value="{{$cotizacion_maestro->id}}" >
                    </div>
                    <div class="col-md-4 col-sm-4">
                            <label for="fecha_documento">Fecha Documento:</label>
                            <div class="input-group date" id="fecha_documento">
                            <input class="form-control" name="fecha_documento" id="fecha_documento" placeholder="Fecha Documento" tabindex="2" value="{{old('fecha_documento', $cotizacion_maestro->fecha_documento)}}">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="tipo_pago_id">Tipo Pago:</label>
                        <select name="tipo_pago_id" class="form-control" id="tipo_pago_id" tabindex="4">
                            <option value="default">Seleccione un Tipo de Pago</option>
                            @foreach ($tipo_pago as $tp)
                                @if ($tp->id == $cotizacion_maestro->tipo_pago_id)
                                    <option value="{{$tp->id}}" selected >{{$tp->tipo_pago}}</option>
                                @else
                                    <option value="{{$tp->id}}">{{$tp->tipo_pago}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="cliente_id">Cliente:</label>
                        <select name="cliente_id" class="selectpicker form-control" data-live-search="true" id="cliente_id" tabindex="5" >
                            <option value="default">Seleccione un Cliente</option>
                            @foreach ($clientes as $cl)
                                @if ($cl->id == $cotizacion_maestro->cliente_id)
                                    <option value="{{$cl->id}}" selected >{{$cl->codigo}} - {{$cl->nombre_comercial}}</option>
                                @else
                                    <option value="{{$cl->id}}">{{$cl->codigo}} - {{$cl->nombre_comercial}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="nit_cliente">NIT Cliente:</label>
                        <input type="text" class="form-control" name="nit_cliente" placeholder="NIT Cliente" id="nit_cliente" tabindex="6" value="{{$clientes_asig[0]->nit}}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="dias_credito_cliente">Dias de Crédito:</label>
                        <input type="text" class="form-control" name="dias_credito_cliente" placeholder="Dias Crédito Cliente" id="dias_credito_cliente" tabindex="7" value="{{$clientes_asig[0]->dias_credito}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="nombre_cliente">Nombre Cliente:</label>
                        <input type="text" class="form-control" name="nombre_cliente" placeholder="Nombre Cliente" id="nombre_cliente" tabindex="8" value="{{$clientes_asig[0]->nombre_comercial}}">
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="direccion_cliente">Dirección Cliente:</label>
                        <input type="text" class="form-control" name="direccion_cliente" placeholder="Dirección Cliente" id="direccion_cliente" tabindex="9" value="{{$clientes_asig[0]->direccion_comercial}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="lugar_entrega">Lugar Entrega:</label>
                        <input type="text" class="form-control" name="lugar_entrega" placeholder="Lugar Entrega" id="lugar_entrega" tabindex="10" value="{{$cotizacion_maestro->lugar_entrega}}">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="descuento_porcentaje">Descuento (Porcentaje - %):</label>
                        <input type="text" class="form-control" name="descuento_porcentaje" placeholder="Descuento Porcentaje" id="descuento_porcentaje" tabindex="11" value="{{old('descuento_porcentaje', $cotizacion_maestro->descuento_porcentaje)}}">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="descuento_valores">Descuento (Valores):</label>
                        <input type="text" class="form-control" name="descuento_valores" placeholder="Descuento Valores" id="descuento_valores" tabindex="12" value="{{old('descuento_valores', $cotizacion_maestro->descuento_valores)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="atencion_a">Atención A:</label>
                        <input type="text" class="form-control" name="atencion_a" placeholder="Atención A" id="atencion_a" tabindex="13" value="{{old('atencion_a', $cotizacion_maestro->atencion_a)}}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="vendedor">Vendedor Asignado:</label>
                        <input type="hidden" class="form-control" name="vendedor_id" id="vendedor_id" tabindex="14" value="{{old('vendedor_id', $vendedor[0]->id)}}" >
                        <input disabled type="text" class="form-control" name="vendedor" placeholder="Vendedor" id="vendedor" tabindex="15" value="{{old('nombres', $vendedor[0]->nombres .' '. $vendedor[0]->apellidos)}}" >
                    </div>
                    <div class="col-sm-4">
                        <label for="exenta">Exenta</label>
                        <select name="exenta" class="form-control" tabindex="16">
                            <option value="No">No</option>
                            <option value="Si">Si</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                    <label for="tiempo_entrega">Tiempo de Entrega:</label>
                        <input type="text" class="form-control" name="tiempo_entrega" id="tiempo_entrega" tabindex="17" value="{{old('tiempo_entrega', $cotizacion_maestro->tiempo_entrega)}}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="validez_oferta">Validez de la Oferta:</label>
                        <input type="text" class="form-control" name="validez_oferta" id="validez_oferta" tabindex="18" value="{{old('validez_oferta', $cotizacion_maestro->validez_oferta)}}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                    <label for="transportado_por">Transportado por:</label>
                        <input type="text" class="form-control" name="transportado_por" id="transportado_por" tabindex="19" value="{{old('transportado_por', $cotizacion_maestro->transportado_por)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label for="anotaciones">Anotaciones:</label>
                        <input type="text" class="form-control" name="anotaciones" placeholder="Anotaciones" id="anotaciones" tabindex="20" value="{{old('anotaciones', $cotizacion_maestro->anotaciones)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label for="referencia">Referencia:</label>
                        <input type="text" class="form-control" name="referencia" placeholder="Referencia" id="referencia" tabindex="21" value="{{old('referencia', $cotizacion_maestro->referencia)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label for="observaciones">Observaciones:</label>
                        <input type="text" class="form-control" name="observaciones" placeholder="Observaciones" id="observaciones" tabindex="22" value="{{old('observaciones', $cotizacion_maestro->observaciones)}}">
                    </div>
                </div>
                <br>
                <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
                </table>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
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
                    <div class="col-md-6 col-sm-6">
                        <label for="desc_art">.</label>
                        <input type="text" class="form-control" name="desc_art" id="desc_art" tabindex="24">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" class="form-control" placeholder="Cantidad" name="cantidad" id="cantidad" tabindex="25">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="precio_unitario">Valor Unitario:</label>
                        <input type="number" class="form-control" placeholder="Valor Unitario" name="precio_unitario" id="precio_unitario" tabindex="26">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" placeholder="Subtotal" name="subtotal" id="subtotal" disabled tabindex="27">
                    </div>
                </div>
                <input type="text" class="form-control" name="ebodega" id="ebodega" disabled tabindex="30">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="text-left m-t-15">
                            <h3>Agregar Detalles</h3>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right m-t-15" style="margin-top: 15px; margin-bottom: 10px">
                            <button id="agregar-detalle" class="btn btn-success form-button">Agregar al detalle</button>
                        </div>
                    </div>
                </div>
                <br>
                <table id="detalleadd-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
                </table>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="total">Total:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q.</span>
                            <input type="text" class="form-control customreadonly" placeholder="Total Cotización" name="total" id="total" tabindex="29" value="{{old('total', $cotizacion_maestro->total)}}">
                        </div>
                    </div>
                </div>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('cotizaciones.index') }}">Regresar</a>
                    <button id="ButtonUpdateCotizacion" class="btn btn-success form-button">Editar</button>
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

    $("#CotizacionEditForm").show(function () {

        var maestro_id = $("#maestro_id").val();

        var url = "/cotizaciones/getdetalle/" + maestro_id ;
	    if (maestro_id != "") {
		    $.getJSON( url , function ( result ) {
			    
                $filas = result.length;

                for(i=0; i<$filas; i++)
                {
                    detalle_table.row.add({
                    'articulo_id': result[i].articulo_id,
                    'id': result[i].id,
                    'articulo': result[i].desc_articulo,
                    'cantidad': result[i].cantidad,
                    'precio_unitario': result[i].precio_unitario,
                    'subtotal': result[i].subtotal,
                }).draw();
            }

		    });
	    }
    });

 
    //datepicker settings

    $('#fecha_documento').datepicker({
        language: "es", 
        todayHighlight: true, 
        clearBtn: true, 
        autoclose: true, 
        format: 'dd-mm-yyyy',
    });


    


    $("#articulo_id").change(function () {
	var articulo_id = $("#articulo_id").val();
	var url = "/cotizaciones/getArticulo/" + articulo_id ;
	if (articulo_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='desc_art'] ").val(result[0].descripcion);
            $("input[name='precio_unitario'] ").val(result[0].precio_quetzales);
            $("input[name='existencias'] ").val("El total de existencias es: " + result[0].existencia + " unidades");
		});
	}
    });

    

    $("#cliente_id").change(function () {
	var cliente_id = $("#cliente_id").val();
	

    if (cliente_id == 0){
        $("input[name='nit_cliente'] ").val("");
        document.getElementById("nit_cliente").disabled = false;
        document.getElementById("nit_cliente").focus();
        document.getElementById("nombre_cliente").disabled = false;
        $("input[name='nombre_cliente'] ").val("");
        document.getElementById("direccion_cliente").disabled = false;
        $("input[name='direccion_cliente'] ").val("");
        $("input[name='dias_credito_cliente'] ").val("0");
        document.getElementById("dias_credito_cliente").disabled = false;
    }
    else
    {
        var url = "/cotizaciones/getCliente/" + cliente_id ;
	
		$.getJSON( url , function ( result ) {
			$("input[name='nit_cliente'] ").val(result[0].nit);
            $("input[name='nombre_cliente'] ").val(result[0].nombre_comercial);
            $("input[name='dias_credito_cliente'] ").val(result[0].dias_credito);
            $("input[name='direccion_cliente'] ").val(result[0].direccion_comercial);
            $("input[name='lugar_entrega'] ").val(result[0].lugar_entrega);
            $("input[name='descuento_porcentaje'] ").val(result[0].descuento_autorizado);
            $("input[name='descuento_valores'] ").val("0");
            $("input[name='atencion_a'] ").val(result[0].nombre_contacto);
            $("input[name='vendedor_id'] ").val(result[0].vendedor_id);
            $("input[name='vendedor'] ").val(result[0].nombres + ' ' + result[0].apellidos);
		});
	}
    });


    $(document).on('focusout', '#nit_cliente', function() {

        var nit = $("#nit_cliente").val();

        var url = "/facturas/getCliente/" + nit ;
        if (nit != "") {
            $.getJSON( url , function ( result ) {
                $("input[name='nombre_cliente'] ").val(result.body.nombre);
                $("input[name='direccion_cliente'] ").val("Ciudad");
                $("input[name='dias_credito_cliente'] ").val("0");
                $("input[name='descuento_valores'] ").val("0");
                $("input[name='descuento_porcentaje'] ").val("0");
                $("input[name='lugar_entrega'] ").val("X");
                $("input[name='atencion_a'] ").val("X");
            });
        }
    });


    $(document).on('focusout', '#precio_unitario', function() {
        $('#subtotal').val(parseInt($('#cantidad').val())*parseFloat($('#precio_unitario').val()));
    });


    $(document).on('focusout', '#cantidad', function() {
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

            total2 = parseFloat($('#total').val()) + (parseFloat($('#precio_unitario').val()) * parseFloat($('#cantidad').val()));
            //adds the form data to the table
            detalleadd_table.row.add({
                'articulo_id': $('#articulo_id').val(),
                'articulo': $('#desc_art').val(),
                'cantidad': $('#cantidad').val(),
                'precio_unitario': $('#precio_unitario').val(),
                'subtotal': subt
            }).draw();
            //adds all subtotal row data and sets the total input

            $('#total').val( total2 );
            $('#total-error').remove();

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


    var validator = $("#CotizacionEditForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        fecha_documento: {
			required : true
		}
	},
	messages: {
		fecha_documento: {
			required: "Por favor, ingrese la fecha del documento"
		}
    }
});




$("#ButtonUpdateCotizacion").click(function(event) {
  if ($('#CotizacionEditForm').valid()) {
    event.preventDefault();
    editCoti();
  } else {
    validator.focusInvalid();
  }
});


function editCoti() {
    var arr1 = $('#CotizacionEditForm').serializeArray();
    var arr2 = detalleadd_table.rows().data().toArray();
    var arr3 = arr1.concat(arr2);

    var maestro_id = $("#maestro_id").val();


  $.ajax({
    type: "POST",
    headers: {'X-CSRF-TOKEN': $('#token').val()},
    url: "/cotizaciones/" + maestro_id +"/update",
    data: JSON.stringify(arr3),
    async: false,
    dataType: 'json',
    success: function(data) {
        detalleadd_table.rows().remove().draw();
        window.location.assign('/cotizaciones')
    },
    error: function() {
        alertify.set('notifier', 'position', 'top-center');
        alertify.error('Hubo un error al editar la cotización')
    }
  });
}


</script>

<script src="{{asset('js/cotizaciones/detalle_edit.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/cotizaciones/detalle_add_edit.js')}}"></script>{{-- datatable --}}

@endpush
