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




	$.validator.addMethod("nit", function(value, element){
		
		var valor = value;

		
		if(nitIsValid(valor)==true)
		{
			return true;
		}
		else
		{
			return false;
		}
		

	}, "El NIT ingresado es incorrecto o inválido, reviselo y vuelva a ingresarlo");



$.validator.addMethod("ntel", function(value, element) {
	var valor = value.length;
	if (valor == 8)
	{
		return true;
	}
	else
	{
		return false;
	}
}, "Debe ingresar el número de teléfono con 8 dígitos, en formato ########");



var validator = $("#ProveedorForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nit:{
			if_else:(tipo_proveedor_id.value==1),required: true,required: false,
			nit:true,
			nitUnico: true
		},
		nombre_comercial: {
			required : true
		},
		telefono: {
			required: true
		},
		direccion: {
			required: true
		},
		dias_credito: {
			required: true
		},
		email:{
			email: true,
			required: true
		},
		contacto:{
			required: true
		}

	},
	messages: {
		nit: {
			required: "Por favor, ingrese el nit"
		},
		nombre_comercial: {
			required: "Por favor, ingrese el nombre comercial"
		},
		telefono: {
			required: "Por favor, ingrese el número de teléfono"
		},
		direccion: {
			required: "Por favor, ingrese la dirección"
		},
		dias_credito: {
			required: "Por favor, ingrese los dias de crédito"
		},
		email: {
			email: "El formato de correo no es correcto",
			required: "Por favor, ingrese correo electrónico"
		},
		contacto: {
			required: "Por favor, ingrese datos de contacto 1"
		}

	}
});

$("#ButtonProveedor").click(function(event) {
	if ($('#ProveedorForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});