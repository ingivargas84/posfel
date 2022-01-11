
var validator = $("#DocumentoForm").validate({

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
			required: "Por favor, ingrese el codigo del documento"
		},
		descripcion: {
			required: "Por favor, ingrese la descripción del documento"
		}
	}
});

$("#ButtonDocumento").click(function(event) {
	if ($('#DocumentoForm').valid()) {
		$('.loader').addClass("is-active");
		var btnAceptar=document.getElementById("ButtonDocumento");
		var disableButton = function() { this.disabled = true; };
		btnAceptar.addEventListener('click', disableButton , false);
	} else {
		validator.focusInvalid();
	}
});
