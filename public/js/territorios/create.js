var validator = $("#TerritorioForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		territorio:{
			required: true
		},
		descripcion:{
			required: true
		}

	},
	messages: {
		territorio: {
			required: "Por favor, ingrese datos del territorio"
		},
		descripcion: {
			required: "Por favor, ingrese datos de una descripción"
		}

	}
});

$("#ButtonTerritorio").click(function(event) {
	if ($('#TerritorioForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});