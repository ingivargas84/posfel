
var validator = $("#DocumentoEditForm").validate({
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
			required: "Por favor, ingrese el codigo del documento"
		},
		descripcion: {
			required: "Por favor, ingrese la descripción del documento"
		}
    }
});

$("#ButtonDocumentoUpdate").click(function (event) {
    if ($('#DocumentoEditForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonDocumentoUpdate");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});
