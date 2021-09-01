$(document).ready(function () {
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
            { data: 6 }
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
      // limpiar al cerrar
      $('#modal-form').on('hidden.bs.modal', function () {
        LimpiarFormulario();
    });
     //B
    //Botton editar cargo
    $(document).on('click', '#btn-editar', function () {
        fila = $(this).closest('tr');
        id_usuario = parseInt(fila.find('td:eq(0)').text());
        $('.modal-title').text('Editar Usuario');
        $('#password').removeAttr('required');
        $('#modal-form').modal('show');
        $.ajax({
            type: "POST",
            url: base_url + "Usuarios/obtenerUsuario",
            data: {
                id_usuario: id_usuario
            },
            dataType: "json",
            success: function (respuesta) {
                $('#ci').val(respuesta['ci']);
                $('#nombres').val(respuesta['nombres']);
                $('#apellidos').val(respuesta['apellidos']);
                $('#username').val(respuesta['username']);
                $('#nombre').val(respuesta['nombre']);
                $('#password').attr('placeholder','Cambiar nueva contraseña o no llenar para no cambiar')
                $("#id_roles option[value=" + respuesta['id_roles'] + "]").attr("selected", true);
                $('#telefono').val(respuesta['telefono']);

            }
        });
        opcion = 'editar';

    });
    //ingresar o editar Usuario
    $('#formulario').submit(function (e) {
        e.preventDefault();
        ci = $.trim($('#ci').val());
        nombres = $.trim($('#nombres').val());
        apellidos = $.trim($('#apellidos').val());
        username = $.trim($('#username').val());
        password = $.trim($('#password').val());
        id_roles = $.trim($('#id_roles').val());
        telefono = $.trim($('#telefono').val());
        $('#modal-form').modal('hide');

        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "Usuarios/ingresarUsuario",
                data: {
                    ci: ci,
                    nombres: nombres,
                    apellidos: apellidos,
                    username: username,
                    password: password,
                    id_roles: id_roles,
                    telefono: telefono,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_usuario = respuesta['datos']['id_usuario'];
                        nombre_completo = respuesta['datos']['nombre_completo'];
                        ci = respuesta['datos']['ci'];
                        nombre = respuesta['datos']['nombre'];
                        username = respuesta['datos']['username'];
                        telefono = respuesta['datos']['telefono'];
                        tabla.row.add({
                            "id_usuario": id_usuario,
                            "nombre_completo": nombre_completo,
                            "ci": ci,
                            "nombre": nombre,
                            "username": username,
                            "telefono": telefono,
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
                url: base_url + "Usuarios/actualizarUsuario",
                data: {
                    id_usuario: id_usuario,
                    ci: ci,
                    nombres: nombres,
                    apellidos: apellidos,
                    username: username,
                    password: password,
                    id_roles: id_roles,
                    telefono: telefono,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_usuario = respuesta['datos']['id_usuario'];
                        nombre_completo = respuesta['datos']['nombre_completo'];
                        ci = respuesta['datos']['ci'];
                        nombre = respuesta['datos']['nombre'];
                        username = respuesta['datos']['username'];
                        telefono = respuesta['datos']['telefono'];
                        tabla.row(fila).data({
                            "id_usuario": id_usuario,
                            "nombre_completo": nombre_completo,
                            "ci": ci,
                            "nombre": nombre,
                            "username": username,
                            "telefono": telefono,
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
    //Eliminar Usuario
    $(document).on('click', '#btn-borrar', function () {
        Swal.fire({
            title: 'Esta seguro de elimar?',
            text: "El Usuario se eliminara, una vez eliminado no se recuperara!",
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
                    url: base_url + "Usuarios/borrar/" + id,
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
})
function LimpiarFormulario() {
    $('#modal-form').modal('hide');
    $('.modal-title').text('Formulario Usuario');
    $("#id_roles option:selected").removeAttr("selected");
    $("#password").removeAttr("placeholder");
    $("#password").prop('required',true);
    $('#formulario').trigger('reset');
    opcion = '';
};
