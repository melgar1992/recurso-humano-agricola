$(document).ready(function () {
    opcion = '';
    document.title = 'Sistema Agricola| Empleado';
    var tabla = $('#tablaEmpleados').DataTable({
        responsive: true,
        dom: "Blfrtip",
        ajax: { url: base_url + "Empleado/obtenerEmpleadosTablaEmpleados", dataSrc: "" },
        columns: [
            { data: 'id_empleado', width: '50px' },
            { data: 'ci' },
            { data: 'nombres' },
            { data: 'apellidos' },
            { data: 'telefono', width: '150px' },
            { data: 5, width: '120px' }
        ],
        buttons: [{
            extend: 'excelHtml5',
            title: "Listado de empleados",
            exportOptions: {
                columns: [1, 2, 3, 4],
            }

        },
        {
            extend: 'pdfHtml5',
            title: "Listado de empleados",
            exportOptions: {
                columns: [1, 2, 3, 4],

            }
        },
        {
            extend: 'print',
            title: "Listado de empleados",
            exportOptions: {
                columns: [1, 2, 3, 4],

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
    //cerrar ventana modal
    $('#btn-cerrar').on('click', function () {
		LimpiarFormulario();
	});
    // limpiar al cerrar
    $('#modal-empleados').on('hidden.bs.modal', function(){
        LimpiarFormulario();
    });
    //Botton editar empleado
    $(document).on('click', '#btn-editar', function () {
        fila = $(this).closest('tr');
        id_empleado = parseInt(fila.find('td:eq(0)').text());
        $('.modal-title').text('Editar empleado');
        $('#modal-empleados').modal('show');
        $.ajax({
            type: "POST",
            url: base_url + "/Empleado/obtenerEmpleadoAjax",
            data: {
                id_empleado: id_empleado
            },
            dataType: "json",
            success: function (respuesta) {
                $('#ci').val(respuesta['ci']);
                $('#nombres').val(respuesta['nombres']);
                $('#apellidos').val(respuesta['apellidos']);
                $('#telefono').val(respuesta['telefono']);
                $('#direccion').text(respuesta['direccion']);
            }
        });
        opcion = 'editar';

    });

    //Ingresar o editar Empleado
    $('#formEmpleados').submit(function (e) {
        e.preventDefault();
        ci = $.trim($('#ci').val());
        nombres = $.trim($('#nombres').val());
        apellidos = $.trim($('#apellidos').val());
        telefono = $.trim($('#telefono').val());
        direccion = $.trim($('#direccion').val());
        $('#modal-empleados').modal('hide');

        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "Empleado/ingresar_empleado",
                data: {
                    ci: ci,
                    nombres: nombres,
                    apellidos: apellidos,
                    telefono: telefono,
                    direccion: direccion,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_empleado = respuesta['datos']['id_empleado'];
                        ci = respuesta['datos']['ci'];
                        nombres = respuesta['datos']['nombres'];
                        apellidos = respuesta['datos']['apellidos'];
                        telefono = respuesta['datos']['telefono'];
                        direccion = respuesta['datos']['direccion'];
                        tabla.row.add({ "id_empleado": id_empleado, "ci": ci, "nombres": nombres, "apellidos": apellidos, "telefono": telefono }).draw();
                        swal({
                            title: 'Guardar',
                            text: respuesta['respuesta'],
                            type: 'success'
                        });
                        $('#formEmpleados').trigger('reset');
                    } else {
                        swal({
                            title: 'Error',
                            text: respuesta['mensaje'],
                            type: 'error'
                        });
                    }
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: base_url + "Empleado/editarEmpleado",
                data: {
                    id_empleado: id_empleado,
                    ci: ci,
                    nombres: nombres,
                    apellidos: apellidos,
                    telefono: telefono,
                    direccion: direccion,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_empleado = respuesta['datos']['id_empleado'];
                        ci = respuesta['datos']['ci'];
                        nombres = respuesta['datos']['nombres'];
                        apellidos = respuesta['datos']['apellidos'];
                        telefono = respuesta['datos']['telefono'];
                        direccion = respuesta['datos']['direccion'];
                        tabla.row.add({ "id_empleado": id_empleado, "ci": ci, "nombres": nombres, "apellidos": apellidos, "telefono": telefono }).draw();
                        swal({
                            title: 'Guardar',
                            text: respuesta['respuesta'],
                            type: 'success'
                        });
                        $('#formEmpleados').trigger('reset');
                    } else {
                        swal({
                            title: 'Error',
                            text: respuesta['mensaje'],
                            type: 'error'
                        });
                    }
                }
            });
        }
    });
});
function LimpiarFormulario() {
	$('#modal-empleados').modal('hide');
	$('#formEmpleados').trigger('reset');
	$('.modal-title').text('Formulario empleado');
	$('#direccion').text('');
	opcion = '';
};