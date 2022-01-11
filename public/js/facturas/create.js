$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#FacturaForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        tipo_factura_id: {
            required: true,
            select: 'default'
        },
        serie_cotizacion_id: {
            required: true,
            select: 'default'
        },
        coti: {
            required: true,
        },
        fecha_documento: {
            required: true,
        },
        orden_compra: {
            required: true,
        },
        porcentaje: {
            required: true,
        },
        descuento_valores: {
            required: true,
        }
    },
    messages: {
        tipo_factura_id: {
            required: "Este campo es obligatorio."
        },
        serie_cotizacion_id: {
            required: "Este campo es obligatorio."
        },
        coti: {
            required: "Este campo es obligatorio."
        },
        fecha_documento: {
            required: "Este campo es obligatorio."
        },
        orden_compra: {
            required: "Este campo es obligatorio."
        },
        porcentaje: {
            required: "Este campo es obligatorio."
        },
        descuento_valores: {
            required: "Este campo es obligatorio."
        }
    }
});

