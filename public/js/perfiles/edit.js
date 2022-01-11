
var validator = $("#PerfilEditForm").validate({
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
			required: "Por favor, ingrese el codigo del perfil"
		},
		descripcion: {
			required: "Por favor, ingrese la descripción del perfil"
		}
    }
});

$("#ButtonPerfilUpdate").click(function (event) {
    if ($('#PerfilEditForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonPerfilUpdate");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});
