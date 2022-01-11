$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#ImportacionForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        numero_hoja: {
            required: true,
        },
        numero_pedido: {
            required: true,
        },
        poliza: {
            required: true,
        },
        orden_compra_id: {
            required: true,
            select: 'default'
        },
        proveedor_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        numero_hoja: {
            required: "Este campo es obligatorio."
        },
        numero_pedido: {
            required: "Este campo es obligatorio."
        },
        poliza: {
            required: "Este campo es obligatorio."
        },
        orden_compra_id: {
            required: "Este campo es obligatorio."
        },
        proveedor_id: {
            required: "Este campo es obligatorio.",
        }
    }
});
