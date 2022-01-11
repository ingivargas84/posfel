$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#OrdenCompraForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        serie_id: {
            required: true,
            select: 'default'
        },
        fecha_documento: {
            required: true,
        },
        tipo_documento_importacion_id: {
            required: true,
            select: 'default'
        },
        tipo_pago_id: {
            required: true,
            select: 'default'
        },
        observaciones: {
            required: true
        },
        autoriza_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        serie_id: {
            required: "Este campo es obligatorio."
        },
        fecha_documento: {
            required: "Este campo es obligatorio."
        },
        tipo_documento_importacion_id: {
            required: "Este campo es obligatorio."
        },
        tipo_pago_id: {
            required: "Este campo es obligatorio."
        },
        observaciones: {
            required: "Este campo es obligatorio."
        },
        autoriza_id: {
            required: "Este campo es obligatorio."
        }

    }
});

