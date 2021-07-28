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
    $('#bt-reset-form').on('click', function (e) {
        e.preventDefault();
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
    //Botton editar Roll
    $(document).on('click', '#btn-editar', function () {
        fila = $(this).closest('tr');
        id_roles = parseInt(fila.find('td:eq(0)').text());
        $('.modal-title').text('Editar Rol');
        $('#modal-form').modal('show');
        $.ajax({
            type: "POST",
            url: base_url + "Usuarios/obtenerRolAjax",
            data: {
                id_roles: id_roles
            },
            dataType: "json",
            success: function (respuesta) {
                $('#nombre').val(respuesta['nombre']);
                $('#descripcion').text(respuesta['descripcion']);
                (respuesta['dashboard'] === '1') ? $("#dashboard").iCheck("check") : $("#dashboard").iCheck("uncheck");
                (respuesta['empleados'] === '1') ? $("#empleados").iCheck("check") : $("#empleados").iCheck("uncheck");
                (respuesta['calendario'] === '1') ? $("#calendario").iCheck("check") : $("#calendario").iCheck("uncheck");
                (respuesta['asistencias'] === '1') ? $("#asistencias").iCheck("check") : $("#asistencias").iCheck("uncheck");
                (respuesta['pago'] === '1') ? $("#pago").iCheck("check") : $("#pago").iCheck("uncheck");
                (respuesta['usuarios'] === '1') ? $("#usuarios").iCheck("check") : $("#usuarios").iCheck("uncheck");


            }
        });
        opcion = 'editar';

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

        (dashboard === 'true') ? dashboard = '1' : dashboard = '0';
        (empleados === 'true') ? empleados = '1' : empleados = '0';
        (calendario === 'true') ? calendario = '1' : calendario = '0';
        (asistencias === 'true') ? asistencias = '1' : asistencias = '0';
        (pago === 'true') ? pago = '1' : pago = '0';
        (usuarios === 'true') ? usuarios = '1' : usuarios = '0';

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
                        id_roles = respuesta['datos']['id_roles'];
                        nombre = respuesta['datos']['nombre'];
                        descripcion = respuesta['datos']['descripcion'];
                        tabla.row.add({
                            "id_roles": id_roles,
                            "nombre": nombre,
                            "descripcion": descripcion,
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
                url: base_url + "Usuarios/editarRol",
                data: {
                    id_roles: id_roles,
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
                        id_roles = respuesta['datos']['id_roles'];
                        nombre = respuesta['datos']['nombre'];
                        descripcion = respuesta['datos']['descripcion'];
                        tabla.row(fila).data({
                            "id_roles": id_roles,
                            "nombre": nombre,
                            "descripcion": descripcion,
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
    $(document).on('click', '#btn-borrar', function () {
        Swal.fire({
            title: 'Esta seguro de elimar?',
            text: "El rol se eliminara, una vez eliminado no se recuperara, tambien los usuarios con este roll no podran entrar!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, deseo elimniar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {

                fila = $(this).closest('tr');
                id = parseInt(fila.find('td:eq(0)').text());

                $.ajax({
                    url: base_url + "Usuarios/eliminarRol/" + id,
                    type: 'POST',
                    dataType: "json",
                    success: function (respuesta) {
                        if (respuesta['respuesta'] === 'Exitoso') {
                            tabla.row(fila).remove().draw();
                            swal({
                                title: 'Eliminado',
                                text: 'Se borro correctamente',
                                type: 'success'
                            });
                        } else {
                            swal({
                                title: 'Error',
                                text: 'Ocurrio un error al eliminar',
                                type: 'error'
                            });
                        }

                    }
                })


            }
        })

    })
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