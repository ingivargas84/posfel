$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#FacturaForm2').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        tipo_factura_id: {
            required: true,
            select: 'default'
        },
        fecha_documento: {
            required: true,
        },
        orden_compra: {
            required: true,
        },
        nit_cliente: {
            required: true,
        },
        descuento_porcentaje: {
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
        fecha_documento: {
            required: "Este campo es obligatorio."
        },
        orden_compra: {
            required: "Este campo es obligatorio."
        },
        nit_cliente: {
            required: "Este campo es obligatorio."
        },
        descuento_porcentaje: {
            required: "Este campo es obligatorio."
        },
        descuento_valores: {
            required: "Este campo es obligatorio."
        },
    }
});

