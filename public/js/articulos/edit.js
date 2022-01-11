
var validator = $("#ArticuloEditForm").validate({
    ignore: [],
    onkeyup: false,
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

$("#ButtonArticuloUpdate").click(function (event) {
    if ($('#ArticuloEditForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonArticuloUpdate");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});
