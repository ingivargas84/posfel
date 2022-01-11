
var validator = $("#BodegaForm").validate({

	ignore: [],
	onkeyup:false,
	rules: {
		codigo:{
			required: true
		},
		descripcion: {
			required : true
		}
	},
	messages: {
		codigo: {
			required: "Por favor, ingrese el codigo de la bodega"
		},
		descripcion: {
			required: "Por favor, ingrese la descripción de la bodega"
		}
	}
});

$("#ButtonBodega").click(function(event) {
	if ($('#BodegaForm').valid()) {
		$('.loader').addClass("is-active");
		var btnAceptar=document.getElementById("ButtonBodega");
		var disableButton = function() { this.disabled = true; };
		btnAceptar.addEventListener('click', disableButton , false);
	} else {
		validator.focusInvalid();
	}
});
