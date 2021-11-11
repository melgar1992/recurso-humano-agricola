$(document).ready(function () {
    opcion = '';
    document.title = 'Sistema Agricola| Contrato';
    var tabla = $('#tablaEmpleados').DataTable({
        pageLength: 25,
        dom: "Bfrtip",
        ajax: { url: base_url + "Contrato/obtenerContratosAjax", dataSrc: "" },
        columns: [
            { data: 'id_contrato', width: '50px' },
            { data: 'ci' },
            { data: 'nombre_completo' },
            { data: 'cargo_nombre' },
            { data: 'fecha_inicio' },
            { data: 'fecha_fin' },
            { data: 'sueldo_mensual', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 'sueldo_hora', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 'hora_extra', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 'hora_feriada', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 'id_contrato' }
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
            "data": 'id_contrato',
            "render": function (data, type, row, meta) {
                return "<div class='text-right'> <div class='btn-group'><button class='btn btn-warning btn-sm' value='" + data + "' id='btn-editar'><i class='fas fa-pencil-alt'></i> Editar</button><button class='btn btn-danger btn-sm' id='btn-borrar'><i class='fas fa-trash-alt'></i> Borrar</button></div></div>";
            }
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
    $('#modal-contrato').on('hidden.bs.modal', function () {
        LimpiarFormulario();
    });
    //Botton editar empleado
    $(document).on('click', '#btn-editar', function () {
        fila = $(this).closest('tr');
        id_contrato = parseInt(fila.find('td:eq(0)').text());
        LimpiarFormulario()
        $('.modal-title').text('Editar Contrato');
        $('#modal-contrato').modal('show');
        $.ajax({
            type: "POST",
            url: base_url + "Contrato/obtenerContrato",
            data: {
                id_contrato: id_contrato
            },
            dataType: "json",
            success: function (respuesta) {
                $("#id_empleado option[value=" + respuesta['id_empleado'] + "]").attr("selected", true);
                $("#id_cargo option[value=" + respuesta['id_cargo'] + "]").attr("selected", true);
                $('#fecha_inicio').val(respuesta['fecha_inicio']);
                $('#fecha_fin').val(respuesta['fecha_fin']);

            }
        });
        opcion = 'editar';

    });
    $('#formcontrato').submit(function (e) {
        e.preventDefault();
        id_empleado = $.trim($('#id_empleado').val());
        id_cargo = $.trim($('#id_cargo').val());
        fecha_inicio = $.trim($('#fecha_inicio').val());
        fecha_fin = $.trim($('#fecha_fin').val());
        $('#modal-cargo').modal('hide');

        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "Contrato/ingresar_contrato",
                data: {
                    id_empleado: id_empleado,
                    id_cargo: id_cargo,
                    fecha_inicio: fecha_inicio,
                    fecha_fin: fecha_fin,

                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_contrato = respuesta['datos']['id_contrato'];
                        ci = respuesta['datos']['ci'];
                        nombre_completo = respuesta['datos']['nombre_completo'];
                        cargo_nombre = respuesta['datos']['cargo_nombre'];
                        fecha_inicio = respuesta['datos']['fecha_inicio'];
                        fecha_fin = respuesta['datos']['fecha_fin'];
                        sueldo_mensual = respuesta['datos']['sueldo_mensual'];
                        sueldo_hora = respuesta['datos']['sueldo_hora'];
                        hora_extra = respuesta['datos']['hora_extra'];
                        hora_feriada = respuesta['datos']['hora_feriada'];
                        tabla.row.add({
                            "id_contrato": id_contrato,
                            "ci": ci,
                            "nombre_completo": nombre_completo,
                            "cargo_nombre": cargo_nombre,
                            "fecha_inicio": fecha_inicio,
                            "fecha_fin": fecha_fin,
                            "sueldo_mensual": sueldo_mensual,
                            "sueldo_hora": sueldo_hora,
                            "hora_extra": hora_extra,
                            "hora_feriada": hora_feriada
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
                url: base_url + "Contrato/editarContrato",
                data: {
                    id_contrato: id_contrato,
                    id_empleado: id_empleado,
                    id_cargo: id_cargo,
                    fecha_inicio: fecha_inicio,
                    fecha_fin: fecha_fin,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_contrato = respuesta['datos']['id_contrato'];
                        ci = respuesta['datos']['ci'];
                        nombre_completo = respuesta['datos']['nombre_completo'];
                        cargo_nombre = respuesta['datos']['cargo_nombre'];
                        fecha_inicio = respuesta['datos']['fecha_inicio'];
                        fecha_fin = respuesta['datos']['fecha_fin'];
                        sueldo_mensual = respuesta['datos']['sueldo_mensual'];
                        sueldo_hora = respuesta['datos']['sueldo_hora'];
                        hora_extra = respuesta['datos']['hora_extra'];
                        hora_feriada = respuesta['datos']['hora_feriada'];
                        tabla.row(fila).data({
                            "id_contrato": id_contrato,
                            "ci": ci,
                            "nombre_completo": nombre_completo,
                            "cargo_nombre": cargo_nombre,
                            "fecha_inicio": fecha_inicio,
                            "fecha_fin": fecha_fin,
                            "sueldo_mensual": sueldo_mensual,
                            "sueldo_hora": sueldo_hora,
                            "hora_extra": hora_extra,
                            "hora_feriada": hora_feriada
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
    //Eliminar Cargo
    $(document).on('click', '#btn-borrar', function () {
        Swal.fire({
            title: 'Esta seguro de elimar?',
            text: "El Cargo se eliminara, una vez eliminado no se recuperara!",
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
                    url: base_url + "Contrato/eliminarContrato/" + id,
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
    $('#modal-contrato').modal('hide');
    $('.modal-title').text('Formulario contrato');
    $("#id_empleado option:selected").removeAttr("selected");
    $("#id_cargo option:selected").removeAttr("selected");
    $('#formcontrato').trigger('reset');
    opcion = '';
};