
var validator = $("#PerfilForm").validate({

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
			required: "Por favor, ingrese el codigo del perfil"
		},
		descripcion: {
			required: "Por favor, ingrese la descripción del perfil"
		}
	}
});

$("#ButtonPerfil").click(function(event) {
	if ($('#PerfilForm').valid()) {
		$('.loader').addClass("is-active");
		var btnAceptar=document.getElementById("ButtonPerfil");
		var disableButton = function() { this.disabled = true; };
		btnAceptar.addEventListener('click', disableButton , false);
	} else {
		validator.focusInvalid();
	}
});
