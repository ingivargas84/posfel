@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Cotizaciones
        <small>Editar Detalle Cotización</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('cotizaciones.index')}}"><i class="fa fa-list"></i> Cotizaciones</a></li>
        <li class="active">Editar Detalle</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="CotizacionEditDetalleForm" name="CotizacionEditDetalleForm" action="{{route('cotizaciones.updatedetalle', $cotizacion_detalle)}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="articulo_id">Articulo:</label>
                        <select name="articulo_id" class="selectpicker form-control" data-live-search="true" id="articulo_id" tabindex="1">
                            @foreach ($articulos as $art)
                                @if ($art->id == $cotizacion_detalle->articulo_id)
                                    <option value="{{$art->id}}" selected >{{$art->codigo_articulo}} - {{$art->descripcion}}</option>
                                @else
                                    <option value="{{$art->id}}">{{$art->codigo_articulo}} - {{$art->descripcion}}</option>
                                @endif
                            @endforeach
                        </select>
                        <input type="hidden" class="form-control" name="detalle_id" id="detalle_id" value="{{$cotizacion_detalle->id}}" >
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="desc_articulo">Descripción Artículo</label>
                        <input type="text" class="form-control" name="desc_articulo" placeholder="NIT Cliente" id="desc_articulo"  value="{{$cotizacion_detalle->desc_articulo}}">
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" class="form-control" name="cantidad" placeholder="Cantidad" id="cantidad" value="{{$cotizacion_detalle->cantidad}}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="precio_unitario">Precio Unitario:</label>
                        <input type="text" class="form-control" name="precio_unitario" placeholder="Precio Unitario" id="precio_unitario"  value="{{$cotizacion_detalle->precio_unitario}}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="subtotal">Subtotal:</label>
                        <input disabled type="text" class="form-control" name="subtotal" placeholder="Subtotal" id="subtotal"  value="{{$cotizacion_detalle->subtotal}}">
                    </div>
                </div>
                <br>

                <div class="text-right m-t-15">
                    
                    <button id="ButtonUpdateCotizacionDetalle" class="btn btn-success form-button">Editar Detalle</button>
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

    $("#articulo_id").change(function () {
	var articulo_id = $("#articulo_id").val();
	var url = "/cotizaciones/getArticulo/" + articulo_id ;
    var cantidad = $("input[name='cantidad'] ").val();
	if (articulo_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='desc_articulo'] ").val(result[0].descripcion);
            $("input[name='precio_unitario'] ").val(result[0].precio_quetzales);
            $("input[name='subtotal'] ").val(result[0].precio_quetzales * cantidad );

		});
	}
    });



    $(document).on('focusout', '#cantidad', function() {
        $('#subtotal').val(parseInt($('#cantidad').val())*parseFloat($('#precio_unitario').val()));
    });

    $(document).on('focusout', '#precio_unitario', function() {
        $('#subtotal').val(parseInt($('#cantidad').val())*parseFloat($('#precio_unitario').val()));
    });



    var validator = $("#CotizacionEditDetalleForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        cantidad: {
			required : true
		}
	},
	messages: {
		cantidad: {
			required: "Por favor, ingrese la cantidad"
		}
    }
});


$("#ButtonUpdateCotizacionDetalle").click(function (event) {
    if ($('#CotizacionEditDetalleForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonUpdateCotizacionDetalle");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});

</script>


@endpush
