var clientes_table = $('#clientes-table').DataTable({
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
    "order": [0, 'asc'],

    "columns": [ {
        "title": "Codigo",
        "data": "codigo",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    
    {
        "title": "Nombre",
        "data": "nombre_comercial",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "NIT",
        "data": "nit",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Teléfono",
        "data": "telefono",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Correo Electrónico",
        "data": "correo_electronico",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Estado",
        "data": "estado_id",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            if(data == 1){
                return ('Activo')
            }else{
                return ('Inactivo')
            }
        
        },
    },

    {
        "title": "Vendedor",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (full.nombres + " " + full.apellidos);},
    },
     
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "20%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

            if(full.estado_id == 1){
                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-left col-lg-3'>" + 
                "<a href='"+urlActual+"/edit/"+full.id+"' class='edit-clientes' >" + 
                "<i class='fa fa-btn fa-edit' title='Editar Clientes'></i>" + 
                "</a>" + "</div>" + 
                "<div class='float-center col-lg-3'>" + 
                "<a href='"+urlActual+"/show/"+full.id+"' class='show-clientes' >" + 
                "<i class='fa fa-btn fa-eye' title='Ver Cliente'></i>" + 
                "</a>" + "</div>" +
                "<div class='float-right col-lg-3'>" + 
                "<a href='"+urlActual+"/"+full.id+"/desactivar' class='desactivar-cliente'"+ "data-method='post' data-id='"+full.id+"' >" + 
                "<i class='fa fa-thumbs-down' title='Desactivar Clientes'></i>" + 
                "</a>" + "</div>" +
                "<div class='float-right col-lg-3'>" + 
                "<a href='#' class='remove-cliente' data-method='delete' data-id='"+full.id+"' data-target='#modalConfirmarAccion' data-toggle='modal'>" + 
                "<i class='fas fa-trash-alt' title='Eliminar Clientes'></i>" + 
                "</a>" + "</div>";
    
            }else{
                if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){
                    return "<div id='" + full.id + "' class='text-center'>" + 
                    "<div class='float-right col-lg-6'>" + 
                    "<a href='"+urlActual+"/"+full.id+"/activar' class='activar-cliente'"+ "data-method='post' data-id='"+full.id+"' >" + 
                    "<i class='fa fa-thumbs-up' title='Activar Clientes'></i>" + 
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
		url: APP_URL+"/clientes/" + id + "/delete",
		data: formData,
		dataType: "json",
		success: function(data) {
            $('.loader').fadeOut(225);
			$('#modalConfirmarAccion').modal("hide");
			clientes_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('El Cliente se Desactivó Correctamente!!');
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


$(document).on('click', 'a.desactivar-cliente', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Desactivación de Cliente', 'Esta seguro de Desactivar el cliente', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                clientes_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Cliente Desactivado con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});



$(document).on('click', 'a.activar-cliente', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Activar Cliente', 'Esta seguro de activar el cliente', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                clientes_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Cliente Activado con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});

