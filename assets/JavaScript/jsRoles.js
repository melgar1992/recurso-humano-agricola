$(document).ready(function () {
    opcion = '';
    document.title = 'Sistema Agricola| Roles';
    var tabla = $('#tablaRoles').DataTable({
        responsive: true,
        pageLength: 25,
        ajax: { url: base_url + "Usuarios/obtenerRolesAjax", dataSrc: "" },
        columns: [
            { data: 'id_roles' },
            { data: 'nombre' },
            { data: 'descripcion' },
            { data: 4 }
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
    // limpiar al borrar
    $('#bt-reset-form').on('click', function () {
        $("#dashboard").iCheck("uncheck");
        $("#empleados").iCheck("uncheck");
        $("#calendario").iCheck("uncheck");
        $("#asistencias").iCheck("uncheck");
        $("#pago").iCheck("uncheck");
        $("#usuarios").iCheck("uncheck");
        $('.modal-title').text('Formulario Rol');
        $('#formulario').trigger('reset');
        opcion = '';
    });
     // limpiar al cerrar
     $('#modal-form').on('hidden.bs.modal', function () {
        LimpiarFormulario();
    });
    //ingresar o editar Rol
    $('#formulario').submit(function (e) {
        e.preventDefault();
        nombre = $.trim($('#nombre').val());
        descripcion = $.trim($('#descripcion').val());
        dashboard = $.trim($('#dashboard').prop('checked'));
        empleados = $.trim($('#empleados').prop('checked'));
        calendario = $.trim($('#calendario').prop('checked'));
        asistencias = $.trim($('#asistencias').prop('checked'));
        pago = $.trim($('#pago').prop('checked'));
        usuarios = $.trim($('#usuarios').prop('checked'));


         $('#modal-form').modal('hide');

        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "Usuarios/guardarRol",
                data: {
                    nombre: nombre,
                    descripcion: descripcion,
                    dashboard: dashboard,
                    empleados: empleados,
                    calendario: calendario,
                    asistencias: asistencias,
                    pago: pago,
                    usuarios: usuarios,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_calendario = respuesta['datos']['id_calendario'];
                        nombre = respuesta['datos']['nombre'];
                        feriado = respuesta['datos']['feriado'];
                        tabla.row.add({
                            "id_calendario": id_calendario,
                            "nombre": nombre,
                            "feriado": feriado,
                        }).draw();
                        swal({
                            title: 'Guardar',
                            text: respuesta['message'],
                            type: 'success'
                        });
                        LimpiarFormulario();
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
                url: base_url + "Calendario/editarFeriado",
                data: {
                    id_calendario: id_calendario,
                    nombre: nombre,
                    feriado: feriado,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_calendario = respuesta['datos']['id_calendario'];
                        nombre = respuesta['datos']['nombre'];
                        feriado = respuesta['datos']['feriado'];
                        tabla.row(fila).data({
                            "id_calendario": id_calendario,
                            "nombre": nombre,
                            "feriado": feriado,
                        }).draw();
                        swal({
                            title: 'Editado',
                            text: respuesta['message'],
                            type: 'success'
                        });
                        LimpiarFormulario();
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
    $('#modal-form').modal('hide');
    $("#dashboard").iCheck("uncheck");
    $("#empleados").iCheck("uncheck");
    $("#calendario").iCheck("uncheck");
    $("#asistencias").iCheck("uncheck");
    $("#pago").iCheck("uncheck");
    $("#usuarios").iCheck("uncheck");
    $('.modal-title').text('Formulario Rol');
    $('#formulario').trigger('reset');
    opcion = '';
};