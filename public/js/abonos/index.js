var abonos_table = $('#abonos-table').DataTable({
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
    ],

    "buttons": [
    'pageLength',
    'excelHtml5',
    'csvHtml5'
    ],

    "paging": true,
    "language": {
        "sdecimal":        ".",
        "sthousands":      ",",
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],

    "columns": [ {
        "title": "#",
        "data": "id",
        "width" : "5%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Fecha",
        "data": "fecha_documento",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    
    {
        "title": "Serie",
        "data": "serie",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    
    {
        "title": "Correlativo",
        "data": "correlativo_documento",
        "width" : "5%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },


    {
        "title": "Tipo Abono",
        "data": "tipo_abono",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Cliente",
        "data": "cliente",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },  

    {
        "title": "Total",
        "data": "total",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return  'Q. ' + Number.parseFloat((data)).toFixed(2);
        },
    },  

    {
        "title": "Estado",
        "data": "estado",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Creado por",
        "data": "crea",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    
     
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "10%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

            if((full.estado_id == 1) && (full.tipo_abono_id == 2)) {
                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-left col-lg-4'>" + 
                "<a href='"+urlActual+"/show/"+full.id+"' class='show-factura' >" + 
                "<i class='fa fa-btn fa-eye' title='Ver Factura'></i>" + 
                "</a>" + "</div>" + 
                "<div class='float-center col-lg-4'>" + 
                "<a href='/abonos/pdf_notacredito/" + full.id + "' class='pdfnotacredito'" + "' target='_blank'" + ">" +
                "<i class='fas fa-print' title='Imprimir Nota de Crédito'></i>" +
                "</a>" + "</div>" +
                "<div class='float-right col-lg-4'>" + 
                "<a href='#' class='remove-abono' data-method='delete' data-id='"+full.id+"' data-target='#modalConfirmarAccion' data-toggle='modal'>" + 
                "<i class='fas fa-calendar-times' title='Anular Abono'></i>" + 
                "</a>" + "</div>";
            }else if((full.estado_id == 1) && (full.tipo_abono_id !== 2)){
                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-left col-lg-6'>" + 
                "<a href='"+urlActual+"/show/"+full.id+"' class='show-abono' >" + 
                "<i class='fa fa-btn fa-eye' title='Ver Abono'></i>" + 
                "</a>" + "</div>" +
                "<div class='float-right col-lg-6'>" + 
                "<a href='#' class='remove-abono' data-method='delete' data-id='"+full.id+"' data-target='#modalConfirmarAccion' data-toggle='modal'>" + 
                "<i class='fas fa-calendar-times' title='Anular Abono'></i>" + 
                "</a>" + "</div>";
            }else if (full.estado_id == 4){
                if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){
                    return "<div id='" + full.id + "' class='text-center'>" + 
                    "<div class='float-left col-lg-12'>" + 
                    "<a href='"+urlActual+"/show/"+full.id+"' class='show-abono' >" + 
                    "<i class='fa fa-btn fa-eye' title='Ver Abono'></i>" + 
                    "</a>" + "</div>";
                }else{
                    return "<div id='" + full.id + "' class='text-center'>" + "</div>";
                }    
            }    
        },
        "responsivePriority": 5
    }]
});

//Confirmar Contraseña para borrar
$("#btnConfirmarAccion").click(function(event) {
    event.preventDefault();
	if ($('#ConfirmarAccionForm').valid()) {
		confirmarAccion();
	} else {
		validator.focusInvalid();
	}
});


function confirmarAccion(button) {
    $('.loader').fadeIn();	
    var formData = $("#ConfirmarAccionForm").serialize();
    var id = $("#idConfirmacion").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
		url: APP_URL+"/abonos/" + id + "/delete",
		data: formData,
		dataType: "json",
		success: function(data) {
            $('.loader').fadeOut(225);
			$('#modalConfirmarAccion').modal("hide");
			abonos_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('El Abono se Anuló Correctamente!!');
		},
		error: function(errors) {
            $('.loader').fadeOut(225);
            if(errors.responseText !=""){
                var errors = JSON.parse(errors.responseText);
                if (errors.password_actual != null) {
                    $("input[name='password_actual'] ").after("<label class='error' id='ErrorPassword_actual'>"+errors.password_actual+"</label>");
                }
                else{
                    $("#ErrorPassword_actual").remove();
                }
            }
		}
	});
}

