$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#AbonoForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        serie_id: {
            required: true,
            select: 'default'
        },
        correlativo_documento: {
            required: true,
        },
        concepto: {
            required: true,
        },
        tipo_abono_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        serie_id: {
            required: "Este campo es obligatorio."
        },
        correlativo_documento: {
            required: "Este campo es obligatorio."
        },
        concepto: {
            required: "Este campo es obligatorio."
        },
        tipo_abono_id: {
            required: "Este campo es obligatorio."
        }
    }
});

