$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#CotizacionForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        serie_documento: {
            required: true,
        },
        fecha_documento: {
            required: true,
        },
        tipo_pago_id: {
            required: true,
            select: 'default'
        },
        cliente_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        serie_documento: {
            required: "Este campo es obligatorio."
        },
        fecha_documento: {
            required: "Este campo es obligatorio."
        },
        tipo_pago_id: {
            required: "Este campo es obligatorio."
        },
        cliente_id: {
            required: "Este campo es obligatorio.",
        }
    }
});

