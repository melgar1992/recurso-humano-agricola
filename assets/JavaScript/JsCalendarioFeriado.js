$(document).ready(function () {
    opcion = '';
    document.title = 'Sistema Agricola| Feriado';
    var tabla = $('#tablaEmpleados').DataTable({
        responsive: true,
        pageLength: 25,
        ajax: { url: base_url + "Calendario/obtenerFeriadosAjax", dataSrc: "" },
        columns: [
            { data: 'id_calendario' },
            { data: 'feriado' },
            { data: 'nombre' },
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
      // limpiar al cerrar
      $('#modal-form').on('hidden.bs.modal', function () {
        LimpiarFormulario();
    });
     //Botton editar cargo
     $(document).on('click', '#btn-editar', function () {
        fila = $(this).closest('tr');
        id_calendario = parseInt(fila.find('td:eq(0)').text());
        $('.modal-title').text('Editar Feriado');
        $('#modal-form').modal('show');
        $.ajax({
            type: "POST",
            url: base_url + "Calendario/obtenerFeriadoAjax",
            data: {
                id_calendario: id_calendario
            },
            dataType: "json",
            success: function (respuesta) {
                $('#nombre').val(respuesta['nombre']);
                $('#feriado').val(respuesta['feriado']);

            }
        });
        opcion = 'editar';

    });
    //ingresar o editar Feriado
    $('#formulario').submit(function (e) {
        e.preventDefault();
        nombre = $.trim($('#nombre').val());
        feriado = $.trim($('#feriado').val());
         $('#modal-form').modal('hide');

        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "Calendario/ingresarFeriado",
                data: {
                    nombre: nombre,
                    feriado: feriado,
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
    //Eliminar feriado
    $(document).on('click', '#btn-borrar', function () {
        Swal.fire({
            title: 'Esta seguro de elimar?',
            text: "El Feriado se eliminara, una vez eliminado no se recuperara!",
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
                    url: base_url + "Calendario/eliminarFeriado/" + id,
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
    $('.modal-title').text('Formulario Feriado');
    $('#formulario').trigger('reset');
    opcion = '';
};
