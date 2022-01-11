
var validator = $("#ArticuloForm").validate({

	ignore: [],
	onkeyup:false,
	rules: {
		codigo_articulo:{
			required: true
		},
		descripcion: {
			required : true
		}
	},
	messages: {
		codigo_articulo: {
			required: "Por favor, ingrese el codigo del articulo"
		},
		descripcion: {
			required: "Por favor, ingrese la descripción del articulo"
		}
	}
});

$("#ButtonArticulo").click(function(event) {
	if ($('#ArticuloForm').valid()) {
		$('.loader').addClass("is-active");
		var btnAceptar=document.getElementById("ButtonArticulo");
		var disableButton = function() { this.disabled = true; };
		btnAceptar.addEventListener('click', disableButton , false);
	} else {
		validator.focusInvalid();
	}
});
