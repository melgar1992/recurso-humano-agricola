$(document).ready(function() {
    opcion = '';
    document.title = 'Sistema Agricola| Usuario';
    var tabla = $('#tablaUsuarios').DataTable({
        responsive: true,
        pageLength: 25,
        ajax: { url: base_url + "Usuarios/obtenerUsuariosAjax", dataSrc: "" },
        columns: [
            { data: 'id_usuario' },
            { data: 'nombre_completo' },
            { data: 'ci' },
            { data: 'nombre' },
            { data: 'username' },
            { data: 'telefono' },

            { data: 3 }
        ],
        "order": [
            [0, "desc"]
        ],
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-right'> <div class='btn-group'><button class='btn btn-warning btn-sm' id='btn-editar'><i class='fas fa-pencil-alt'></i> Editar</button><button class='btn btn-danger btn-sm' id='btn-borrar'><i class='fas fa-trash-alt'></i> Borrar</button></div></div>",
        }],
        "language": {
            'lengthMenu': "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registro",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Ultimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior",

            },
            "sProcesing": "Procesando...",
        }
    });

})