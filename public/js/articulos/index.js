var articulos_table = $('#articulos-table').DataTable({
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
        "title": "Código Artículo",
        "data": "codigo_articulo",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    

    {
        "title": "Descripción",
        "data": "articulo",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

       
    {
        "title": "Estado",
        "data": "estado",
        "width" : "5%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Existencias",
        "data": "existencia",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Precio",
        "data": "precio_quetzales",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return  'Q. ' + Number.parseFloat((full.precio_quetzales)).toFixed(2);
        },
    },

    {
        "title": "Precio 10%",
        "data": "precio_quetzales",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return  'Q. ' + Number.parseFloat((full.precio_quetzales * 0.9)).toFixed(2);
        },
    },

    {
        "title": "Precio 20%",
        "data": "precio_quetzales",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return  'Q. ' + Number.parseFloat((full.precio_quetzales * 0.8)).toFixed(2);
        },
    },
     
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "15%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

            if(full.estado_id == 1){
                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-center col-lg-3'>" + 
                "<a href='"+urlActual+"/edit/"+full.id+"' class='edit-articulo' >" + 
                "<i class='fa fa-btn fa-edit' title='Editar Artículo'></i>" + 
                "</a>" + "</div>" + 
                "<div class='float-center col-lg-3'>" + 
                "<a href='"+urlActual+"/show/"+full.id+"' class='show-articulo' >" + 
                "<i class='fa fa-btn fa-eye' title='Ver Artículo'></i>" + 
                "</a>" + "</div>" +
                "<div class='float-center col-lg-3'>" + 
                "<a href='"+urlActual+"/"+full.id+"/desactivar' class='desactivar-articulo'"+ "data-method='post' data-id='"+full.id+"' >" + 
                "<i class='fa fa-thumbs-down' title='Desactivar Artículo'></i>" + 
                "</a>" + "</div>" +
                "<div class='float-center col-lg-3'>" + 
                "<a href='#' class='remove-articulo' data-method='delete' data-id='"+full.id+"' data-target='#modalConfirmarAccion' data-toggle='modal'>" + 
                "<i class='fas fa-trash-alt' title='Eliminar Artículo'></i>" + 
                "</a>" + "</div>";
    
            }else if (full.estado_id == 2){
                if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){
                    return "<div id='" + full.id + "' class='text-center'>" + 
                    "<div class='float-right col-lg-12'>" + 
                    "<a href='"+urlActual+"/"+full.id+"/activar' class='activar-articulo'"+ "data-method='post' data-id='"+full.id+"' >" + 
                    "<i class='fa fa-thumbs-up' title='Activar Artículo'></i>" + 
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
		url: APP_URL+"/articulos/" + id + "/delete",
		data: formData,
		dataType: "json",
		success: function(data) {
            $('.loader').fadeOut(225);
			$('#modalConfirmarAccion').modal("hide");
			articulos_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('El Artículo se Eliminó Correctamente!!');
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


$(document).on('click', 'a.desactivar-articulo', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Desactivación de Artículo', 'Esta seguro de Desactivar el artículo', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                articulos_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Artículo Desactivado con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});



$(document).on('click', 'a.activar-articulo', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Activación de Artículo', 'Esta seguro de activar el artículo', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                articulos_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Artículo Activado con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});

