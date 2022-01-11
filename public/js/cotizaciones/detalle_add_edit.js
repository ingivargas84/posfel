var detalleadd_table = $('#detalleadd-table').DataTable({
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [10, 25, 50, -1],
        ['10 filas', '25 filas', '50 filas', 'Mostrar todo']
    ],

    "buttons": [
        'pageLength',
    ],

    "paging": true,
    "language": {
        "sdecimal": ".",
        "sthousands": ",",
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún detalle agregado a esta compra.",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],

    "columns": [{
        "title": "articulo_id",
        "data": "articulo_id",
        "width": "10%",
        "visible": false,
        "className": "text-center",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },


        {
        "title": "Articulo",
        "data": "articulo",
        "width": "25%",
        "className": "text-center",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Cantidad",
        "data": "cantidad",
        "width": "15%",
        "className": "text-center",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Valor Unitario",
        "data": "precio_unitario",
        "width": "15%",
        "className": "text-right",
        "responsivePriority": 4,
        "render": function (data, type, full, meta) {
            return  'Q. ' + new Intl.NumberFormat('es-MX').format(data);
        },
    },

        {
        "title": "Subtotal",
        "data": "subtotal",
        "width": "15%",
        "responsivePriority": 2,
        "className": "text-right sub",
        "render": function (data, type, full, meta) {
            return  'Q. ' + new Intl.NumberFormat('es-MX').format(data);

        },
    },

    {
        "title": "Acciones",
        "orderable": false,
        "width": "15%",
        "className": "text-center",
        "render": function (data, type, full, meta) {
            return "<div class='float-right col-lg-12'>" +
                "<a href='#' class='remove-detail' data-method='delete' data-id='" + full.id + "'>" +
                "<i class='fas fa-trash-alt' title='Eliminar Detalle de Cotización'></i>" +
                "</a>" + "</div></div>";
        },
        "responsivePriority": 5
    }]

});

$(document).on('click', 'a.remove-detail', function (e) {
    e.preventDefault(); // does not go through with the link.
    var $this = $(this);
    alertify.confirm('Eliminar Detalle', 'Esta seguro de eliminar el detalle',
        function () {
            $('.loader').fadeIn();
            //removes the table row
            detalle_table.row($this.parents('tr')).remove().draw();

            //recalculates total after deletion
            if (!detalle_table.data().count()) {
                $('#total').val(null);
            }else{
                var total = 0;
                detalle_table.column(4).data().each(function(value, index) {
                total = total + parseFloat(value);
                $('#total').val(total.toFixed(2));
                });
            }
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.warning('Cancelar')
        });
});

