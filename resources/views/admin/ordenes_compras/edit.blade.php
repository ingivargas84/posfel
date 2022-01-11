@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Ordenes de Compras
        <small>Editar una Orden de Compra</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('ordenes_compras.index')}}"><i class="fa fa-list"></i> Ordenes de Compras</a></li>
        <li class="active">Editar</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="OrdenCompraEditForm" name="OrdenCompraEditForm" action="{{route('ordenes_compras.update', $orden_compra_maestro)}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="serie_id">Serie Documento:</label>
                        <select name="serie_id" class="form-control" id="serie_id" tabindex="1">
                            @foreach ($series as $s)
                                @if ($s->id == $orden_compra_maestro->serie_id)
                                    <option value="{{$s->id}}" selected >{{$s->serie}}</option>
                                @else
                                    <option value="{{$s->id}}">{{$s->serie}}</option>
                                @endif
                            @endforeach
                        </select>
                        <input type="hidden" class="form-control" name="maestro_id" id="maestro_id" value="{{$orden_compra_maestro->id}}" >
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="correlativo_documento">Correlativo Documento:</label>
                        <input type="number" class="form-control" name="correlativo_documento" placeholder="Correlativo Documento" id="correlativo_documento" tabindex="2" value="{{$orden_compra_maestro->correlativo_documento}}">
                    </div>
                    <div class="col-md-3 col-sm-3">
                            <label for="fecha_documento">Fecha Documento:</label>
                            <div class="input-group date" id="fecha_documento">
                            <input class="form-control" name="fecha_documento" id="fecha_documento" placeholder="Fecha Documento" tabindex="3" value="{{$orden_compra_maestro->fecha_documento}}"> 
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="tipo_documento_importacion_id">Tipo Documento:</label>
                        <select name="tipo_documento_importacion_id" class="form-control" id="tipo_documento_importacion_id" tabindex="4">
                            <option value="default">Seleccione un Tipo de Documento</option>
                            @foreach ($tipo_documento_importacion as $td)
                                @if ($td->id == $orden_compra_maestro->tipo_documento_importacion_id)
                                    <option value="{{$td->id}}" selected >{{$td->tipo_documento_importacion}}</option>
                                @else
                                    <option value="{{$td->id}}">{{$td->tipo_documento_importacion}}</option>
                                @endif
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
                                @if ($pro->id == $orden_compra_maestro->proveedor_id)
                                    <option value="{{$pro->id}}" selected >{{$pro->codigo}} - {{$pro->nombre_comercial}}</option>
                                @else
                                    <option value="{{$pro->id}}">{{$pro->codigo}} - {{$pro->nombre_comercial}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="nit_proveedor">NIT Proveedor:</label>
                        <input disabled type="text" class="form-control" name="nit_proveedor" placeholder="NIT Proveedor" id="nit_proveedor" tabindex="6" value="{{$proveedores[0]->nit}}" >
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="dias_credito_proveedor">Dias de Crédito:</label>
                        <input disabled type="text" class="form-control" name="dias_credito_proveedor" placeholder="Dias Crédito Proveedor" id="dias_credito_proveedor" tabindex="7" value="{{$proveedores[0]->dias_credito}}" >
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="nombre_proveedor">Nombre Proveedor:</label>
                        <input disabled type="text" class="form-control" name="nombre_proveedor" placeholder="Nombre Proveedor" id="nombre_proveedor" tabindex="8" value="{{$proveedores[0]->nombre_comercial}}" >
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="direccion_proveedor">Dirección Proveedor:</label>
                        <input disabled type="text" class="form-control" name="direccion_proveedor" placeholder="Dirección Proveedor" id="direccion_proveedor" tabindex="9" value="{{$proveedores[0]->direccion_comercial}}"  >
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="atencion_a">Atención A:</label>
                        <input type="text" class="form-control" name="atencion_a" placeholder="Atención A" id="atencion_a" tabindex="10" value="{{$orden_compra_maestro->atencion_a}}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="solicito">Persona que Solicita:</label>
                        <input type="text" class="form-control" name="solicito" placeholder="Persona que Solicita" id="solicito" tabindex="11" value="{{$orden_compra_maestro->solicito}}" >
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="lugar_entrega">Lugar de Entrega:</label>
                        <input type="text" class="form-control" name="lugar_entrega" placeholder="Lugar de Entrega" id="lugar_entrega" tabindex="12" value="{{$orden_compra_maestro->lugar_entrega}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="tipo_pago_id">Tipo Pago:</label>
                        <select name="tipo_pago_id" class="form-control" id="tipo_pago_id" tabindex="13">
                            <option value="default">Seleccione un Tipo de Pago</option>
                            @foreach ($tipo_pago as $tp)
                                @if ($tp->id == $orden_compra_maestro->tipo_pago_id)
                                    <option value="{{$tp->id}}" selected >{{$tp->tipo_pago}}</option>
                                @else
                                    <option value="{{$tp->id}}">{{$tp->tipo_pago}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                            <label for="fecha_entrega">Fecha Entrega:</label>
                            <div class="input-group date" id="fecha_entrega">
                            <input class="form-control" name="fecha_entrega" id="fecha_entrega" placeholder="Fecha Entrega" tabindex="14" value="{{$orden_compra_maestro->fecha_entrega}}">
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
                                @if ($a->id == $orden_compra_maestro->autoriza_id)
                                    <option value="{{$a->id}}" selected >{{$a->name}}</option>
                                @else
                                    <option value="{{$a->id}}">{{$a->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label for="observaciones">Observaciones:</label>
                        <input type="text" class="form-control" name="observaciones" placeholder="Observaciones" id="observaciones" tabindex="17" value="{{$orden_compra_maestro->observaciones}}" >
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
                            <input type="text" class="form-control customreadonly" placeholder="Total Cotización" name="total" id="total" tabindex="29" value="{{old('total', $orden_compra_maestro->total)}}">
                        </div>
                    </div>
                </div>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('ordenes_compras.index') }}">Regresar</a>
                    <button id="ButtonUpdateOrdenCompra" class="btn btn-success form-button">Editar</button>
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

    $("#OrdenCompraEditForm").show(function () {

        var maestro_id = $("#maestro_id").val();

        var url = "/ordenes_compras/getdetalle/" + maestro_id ;
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

    $('#fecha_entrega').datepicker({
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


    var validator = $("#OrdenCompraEditForm").validate({
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




$("#ButtonUpdateOrdenCompra").click(function(event) {
  if ($('#OrdenCompraEditForm').valid()) {
    event.preventDefault();
    editOC();
  } else {
    validator.focusInvalid();
  }
});


function editOC() {
    var arr1 = $('#OrdenCompraEditForm').serializeArray();
    var arr2 = detalleadd_table.rows().data().toArray();
    var arr3 = arr1.concat(arr2);

    var maestro_id = $("#maestro_id").val();


  $.ajax({
    type: "POST",
    headers: {'X-CSRF-TOKEN': $('#token').val()},
    url: "/ordenes_compras/" + maestro_id +"/update",
    data: JSON.stringify(arr3),
    async: false,
    dataType: 'json',
    success: function(data) {
        detalleadd_table.rows().remove().draw();
        window.location.assign('/ordenes_compras')
    },
    error: function() {
        alertify.set('notifier', 'position', 'top-center');
        alertify.error('Hubo un error al editar la orden de compra')
    }
  });
}


</script>

<script src="{{asset('js/ordenes_compras/detalle_edit.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/ordenes_compras/detalle_add_edit.js')}}"></script>{{-- datatable --}}

@endpush
