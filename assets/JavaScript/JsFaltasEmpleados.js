$(document).ready(function () {
    opcion = '';
    document.title = 'Sistema Agricola| Faltas';
    var tabla = $('#tablaAsistencia').DataTable({
        responsive: true,
        pageLength: 25,
        dom: "Bfrtip",
        ajax: { url: base_url + "ControlAsistencia/obtenerFaltas", dataSrc: "" },
        columns: [
            { data: 'id_control_asistencia', width: '50px' },
            { data: 'nombre_completo' },
            { data: 'cargo_nombre' },
            { data: 'fecha_falta' },
            { data: 'observaciones' },
            { data: 6, width: '120px' }
        ],
        buttons: [{
            extend: 'excelHtml5',
            title: "Listado de empleados",
            exportOptions: {
                columns: [1, 2, 3, 4, 5],
            }

        },
        {
            extend: 'print',
            title: "Listado de empleados",
            exportOptions: {
                columns: [1, 2, 3, 4, 5],

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
    // limpiar al cerrar
    $('#modal-asistencia').on('hidden.bs.modal', function () {
        LimpiarFormulario();
    });
    //Botton editar cargo
    $(document).on('click', '#btn-editar', function () {
        fila = $(this).closest('tr');
        id_control_asistencia = parseInt(fila.find('td:eq(0)').text());
        $('.modal-title').text('Editar Asistencia');
        $('#modal-asistencia').modal('show');
        $.ajax({
            type: "POST",
            url: base_url + "ControlAsistencia/obtenerAsistenciaAjax",
            data: {
                id_control_asistencia: id_control_asistencia
            },
            dataType: "json",
            success: function (respuesta) {
                fecha_falta = respuesta['fecha_falta'];

                $("#id_contrato option[value=" + respuesta['id_contrato'] + "]").attr("selected", true);
                $('#fecha_falta').val(fecha_falta);
                $('#observaciones').text(respuesta['observaciones']);

            }
        });
        opcion = 'editar';

    });
    $('#formasistencia').submit(function (e) {
        e.preventDefault();
        id_contrato = $.trim($('#id_contrato').val());
        fecha_falta = $.trim($('#fecha_falta').val());
        observaciones = $.trim($('#observaciones').val());

        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "ControlAsistencia/ingresarFalta",
                data: {
                    id_contrato: id_contrato,
                    fecha_falta: fecha_falta,
                    observaciones: observaciones,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_control_asistencia = respuesta['datos']['id_control_asistencia'];
                        nombre_completo = respuesta['datos']['nombre_completo'];
                        cargo_nombre = respuesta['datos']['cargo_nombre'];
                        observaciones = respuesta['datos']['observaciones'];
                        fecha_falta = respuesta['datos']['fecha_falta'];
                        tabla.row.add({
                            "id_control_asistencia": id_control_asistencia,
                            "nombre_completo": nombre_completo,
                            "cargo_nombre": cargo_nombre,
                            "fecha_falta": fecha_falta,
                            "observaciones": observaciones,
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
                url: base_url + "ControlAsistencia/editarFalta",
                data: {
                    id_control_asistencia: id_control_asistencia,
                    id_contrato: id_contrato,
                    fecha_falta: fecha_falta,
                    observaciones: observaciones,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_control_asistencia = respuesta['datos']['id_control_asistencia'];
                        nombre_completo = respuesta['datos']['nombre_completo'];
                        cargo_nombre = respuesta['datos']['cargo_nombre'];
                        observaciones = respuesta['datos']['observaciones'];
                        fecha_falta = respuesta['datos']['fecha_falta'];

                        tabla.row(fila).data({
                            "id_control_asistencia": id_control_asistencia,
                            "nombre_completo": nombre_completo,
                            "cargo_nombre": cargo_nombre,
                            "fecha_falta": fecha_falta,
                            "observaciones": observaciones,
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
            text: "el control se eliminara, una vez eliminado no se recuperara!",
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
                    url: base_url + "ControlAsistencia/eliminar/" + id,
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
    $('#modal-asistencia').modal('hide');
    $('.modal-title').text('Formulario Falta');
    $('#observaciones').text('');
    $("#id_contrato option:selected").removeAttr("selected");
    $('#formasistencia').trigger('reset');
    opcion = '';
};