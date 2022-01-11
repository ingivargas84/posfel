$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $("#FacturaForm2").validate({

	ignore: [],
	onkeyup:false,
	rules: {
		nombre_comercial: {
			required : true,
            select: 'default'
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

$("#ButtonFactura2").click(function(event) {
	if ($('#FacturaForm2').valid()) {
		$('.loader').addClass("is-active");
		var btnAceptar=document.getElementById("ButtonFactura2");
		var disableButton = function() { this.disabled = true; };
		btnAceptar.addEventListener('click', disableButton , false);
	} else {
		validator.focusInvalid();
	}
});
