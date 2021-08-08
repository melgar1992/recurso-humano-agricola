$(document).ready(function () {
    opcion = '';
    document.title = 'Sistema Agricola| Asistencia';
    var tabla = $('#tablaAsistencia').DataTable({
        responsive: true,
        pageLength: 25,
        dom: "Bfrtip",
        ajax: { url: base_url + "ControlAsistencia/obtenerAsistencias", dataSrc: "" },
        columns: [
            { data: 'id_control_asistencia', width: '50px' },
            { data: 'nombre_completo' },
            { data: 'cargo_nombre' },
            { data: 'fecha_hora_ingreso' },
            { data: 'fecha_hora_salida' },
            { data: 'observaciones' },
            { data: 6, width: '120px' }
        ],
        buttons: [{
            extend: 'excelHtml5',
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
                fecha_hora_ingreso = respuesta['fecha_hora_ingreso'];
                fecha_hora_salida = respuesta['fecha_hora_salida'];
                fecha_hora_ingreso = fecha_hora_ingreso.replace(/ /, 'T');
                fecha_hora_salida = fecha_hora_salida.replace(/ /, 'T');

                $("#id_contrato option[value=" + respuesta['id_contrato'] + "]").attr("selected", true);
                $('#fecha_hora_ingreso').val(fecha_hora_ingreso);
                $('#fecha_hora_salida').val(fecha_hora_salida);
                $('#observaciones').text(respuesta['observaciones']);

            }
        });
        opcion = 'editar';

    });
    $('#formasistencia').submit(function (e) {
        e.preventDefault();
        id_contrato = $.trim($('#id_contrato').val());
        fecha_hora_ingreso = $.trim($('#fecha_hora_ingreso').val());
        fecha_hora_salida = $.trim($('#fecha_hora_salida').val());
        observaciones = $.trim($('#observaciones').val());
        if (fecha_hora_salida <= fecha_hora_ingreso) {
            swal({
                title: 'Error',
                text: 'La hora de salida no puede ser antes de la ingreso',
                type: 'error'
            });

        }
        else {
            if (opcion != 'editar') {
                $.ajax({
                    type: "POST",
                    url: base_url + "ControlAsistencia/ingresar_asistencia",
                    data: {
                        id_contrato: id_contrato,
                        fecha_hora_ingreso: fecha_hora_ingreso,
                        fecha_hora_salida: fecha_hora_salida,
                        observaciones: observaciones,
                    },
                    dataType: "json",
                    success: function (respuesta) {
                        if (respuesta['respuesta'] === 'Exitoso') {
                            id_control_asistencia = respuesta['datos']['id_control_asistencia'];
                            nombre_completo = respuesta['datos']['nombre_completo'];
                            cargo_nombre = respuesta['datos']['cargo_nombre'];
                            observaciones = respuesta['datos']['observaciones'];
                            fecha_hora_ingreso = respuesta['datos']['fecha_hora_ingreso'];
                            fecha_hora_salida = respuesta['datos']['fecha_hora_salida'];
                            tabla.row.add({
                                "id_control_asistencia": id_control_asistencia,
                                "nombre_completo": nombre_completo,
                                "cargo_nombre": cargo_nombre,
                                "fecha_hora_ingreso": fecha_hora_ingreso,
                                "fecha_hora_salida": fecha_hora_salida,
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
                    url: base_url + "ControlAsistencia/editar_asistencia",
                    data: {
                        id_control_asistencia: id_control_asistencia,
                        id_contrato: id_contrato,
                        fecha_hora_ingreso: fecha_hora_ingreso,
                        fecha_hora_salida: fecha_hora_salida,
                        observaciones: observaciones,
                    },
                    dataType: "json",
                    success: function (respuesta) {
                        if (respuesta['respuesta'] === 'Exitoso') {
                            id_control_asistencia = respuesta['datos']['id_control_asistencia'];
                            nombre_completo = respuesta['datos']['nombre_completo'];
                            cargo_nombre = respuesta['datos']['cargo_nombre'];
                            observaciones = respuesta['datos']['observaciones'];
                            fecha_hora_ingreso = respuesta['datos']['fecha_hora_ingreso'];
                            fecha_hora_salida = respuesta['datos']['fecha_hora_salida'];
                            tabla.row(fila).data({
                                "id_control_asistencia": id_control_asistencia,
                                "nombre_completo": nombre_completo,
                                "cargo_nombre": cargo_nombre,
                                "fecha_hora_ingreso": fecha_hora_ingreso,
                                "fecha_hora_salida": fecha_hora_salida,
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
        }

    });
});
function LimpiarFormulario() {
    $('#modal-asistencia').modal('hide');
    $('.modal-title').text('Formulario asistencia');
    $('#observaciones').text('');
    $("#id_contrato option:selected").removeAttr("selected");
    $('#formasistencia').trigger('reset');
    opcion = '';
};