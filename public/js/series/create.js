
var validator = $("#SerieForm").validate({

	ignore: [],
	onkeyup:false,
	rules: {
		serie:{
			required: true
		},
		fecha_vencimiento: {
			required : true
		}
	},
	messages: {
		serie: {
			required: "Por favor, ingrese la serie"
		},
		fecha_vencimiento: {
			required: "Por favor, seleccione la fecha de vencimiento"
		}
	}
});

$("#ButtonSerie").click(function(event) {
	if ($('#SerieForm').valid()) {
		$('.loader').addClass("is-active");
		var btnAceptar=document.getElementById("ButtonSerie");
		var disableButton = function() { this.disabled = true; };
		btnAceptar.addEventListener('click', disableButton , false);
	} else {
		validator.focusInvalid();
	}
});
