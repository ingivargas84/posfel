
var validator = $("#RolEditForm").validate({
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
			required: "Por favor, ingrese el codigo del rol"
		},
		descripcion: {
			required: "Por favor, ingrese la descripción del rol"
		}
    }
});

$("#ButtonRolUpdate").click(function (event) {
    if ($('#RolEditForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonRolUpdate");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});
