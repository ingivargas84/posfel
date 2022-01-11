
var validator = $("#BodegaEditForm").validate({
    ignore: [],
    onkeyup: false,
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

$("#ButtonBodegaUpdate").click(function (event) {
    if ($('#BodegaEditForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonBodegaUpdate");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});
