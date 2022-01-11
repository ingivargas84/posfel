$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#CompraForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        serie_documento: {
            required: true,
        },
        correlativo_documento: {
            required: true,
        },
        fecha_documento: {
            required: true,
        },
        tipo_documento_id: {
            required: true,
            select: 'default'
        },
        bodega_origen_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        serie_documento: {
            required: "Este campo es obligatorio."
        },
        correlativo_documento: {
            required: "Este campo es obligatorio."
        },
        fecha_documento: {
            required: "Este campo es obligatorio."
        },
        tipo_documento_id: {
            required: "Este campo es obligatorio."
        },
        bodega_origen_id: {
            required: "Este campo es obligatorio.",
        }
    }
});

