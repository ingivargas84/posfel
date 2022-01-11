$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#RptLib_VentasForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        folio: {
            required: true,
        }
    },
    messages: {
        folio: {
            required: "Este campo es obligatorio, ingresar el número de folio"
        }
    }
});

