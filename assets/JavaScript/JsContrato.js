$(document).ready(function () {
    opcion = '';
    document.title = 'Sistema Agricola| Contrato';
    var tabla = $('#tablaEmpleados').DataTable({
        responsive: true,
        pageLength: 25,
        dom: "Bfrtip",
        ajax: { url: base_url + "Contrato/obtenerContratosAjax", dataSrc: "" },
        columns: [
            { data: 'id_contrato', width: '50px' },
            { data: 'ci' },
            {data: 'nombre_completo'},
            { data: 'cargo_nombre' },
            { data: 'sueldo_mensual', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 'sueldo_hora', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 'hora_extra', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 'hora_feriada', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 8, width: '120px' }
        ],
        buttons: [{
            extend: 'excelHtml5',
            title: "Listado de empleados",
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
            }

        },
        {
            extend: 'print',
            title: "Listado de empleados",
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],

            }
        }
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
});