//Funcion para validar NIT
function nitIsValid(nit) {
    if (!nit) {
        return true;
    }

    var nitRegExp = new RegExp('^[0-9]+(-?[0-9kK])?$');

    if (!nitRegExp.test(nit)) {
        return false;
    }

    nit = nit.replace(/-/, '');
    var lastChar = nit.length - 1;
    var number = nit.substring(0, lastChar);
    var expectedCheker = nit.substring(lastChar, lastChar + 1).toLowerCase();

    var factor = number.length + 1;
    var total = 0;

    for (var i = 0; i < number.length; i++) {
        var character = number.substring(i, i + 1);
        var digit = parseInt(character, 10);

        total += (digit * factor);
        factor = factor - 1;
    }

    var modulus = (11 - (total % 11)) % 11;
    var computedChecker = (modulus == 10 ? "k" : modulus.toString());

    return expectedCheker === computedChecker;
}

$.validator.addMethod("nit", function (value, element) {
    var valor = value;

    if (nitIsValid(valor) == true) {
        return true;
    }

    else {
        return false;
    }
}, "El NIT ingresado es incorrecto o inválido, reviselo y vuelva a ingresarlo");


var validator = $("#ClienteEditForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        nombre_comercial: {
			required : true
		},
		razon_social: {
			required : true
		},
		direccion_comercial: {
			required: true
		},
        nit: {
			required: true,
            nit:true
		},
        telefono: {
			required: true
		},
		correo_electronico:{
			required: true
		},
		prop_replegal:{
			required: true
		}
	},
	messages: {
		nombre_comercial: {
			required: "Por favor, ingrese el nombre comercial"
		},
        razon_social: {
			required: "Por favor, ingrese la razón social"
		},
		direccion_comercial: {
			required: "Por favor, ingrese la dirección comercial"
		},
		nit: {
			required: "Por favor, ingrese el NIT"
		},
        telefono: {
			required: "Por favor, ingrese el número de teléfono"
		},
        correo_electronico: {
			required: "Por favor, ingrese el correo electrónico"
		},
		prop_replegal: {
			required: "Por favor, ingrese el nombre del propietario o representante legal"
		}
    }
});


$("#ButtonClienteUpdate").click(function (event) {
    if ($('#ClienteEditForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonClienteUpdate");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});
