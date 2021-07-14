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
            { data: 'nombre_completo' },
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
    // limpiar al cerrar
    $('#modal-contrato').on('hidden.bs.modal', function () {
        LimpiarFormulario();
    });
    $('#formcontrato').submit(function (e) {
        e.preventDefault();
        id_empleado = $.trim($('#id_empleado').val());
        id_cargo = $.trim($('#id_cargo').val());
        $('#modal-cargo').modal('hide');

        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "Contrato/ingresar_contrato",
                data: {
                    id_empleado: id_empleado,
                    id_cargo: id_cargo,

                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_contrato = respuesta['datos']['id_contrato'];
                        ci = respuesta['datos']['ci'];
                        nombre_completo = respuesta['datos']['nombre_completo'];
                        cargo_nombre = respuesta['datos']['cargo_nombre'];
                        sueldo_mensual = respuesta['datos']['sueldo_mensual'];
                        sueldo_hora = respuesta['datos']['sueldo_hora'];
                        hora_extra = respuesta['datos']['hora_extra'];
                        hora_feriada = respuesta['datos']['hora_feriada'];
                        tabla.row.add({
                            "id_contrato": id_contrato,
                            "ci": ci,
                            "nombre_completo": nombre_completo,
                            "cargo_nombre": cargo_nombre,
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
                url: base_url + "Cargo/editarCargo",
                data: {
                    id_cargo: id_cargo,
                    nombre: nombre,
                    tipo_pago: tipo_pago,
                    sueldo: sueldo,
                    sueldo_hora: sueldo_hora,
                    hora_extra: hora_extra,
                    hora_feriada: hora_feriada,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_cargo = respuesta['datos']['id_cargo'];
                        nombre = respuesta['datos']['nombre'];
                        tipo_cargo = respuesta['datos']['tipo_cargo'];
                        sueldo_mensual = respuesta['datos']['sueldo_mensual'];
                        sueldo_hora = respuesta['datos']['sueldo_hora'];
                        hora_extra = respuesta['datos']['hora_extra'];
                        hora_feriada = respuesta['datos']['hora_feriada'];
                        tabla.row(fila).data({
                            "id_cargo": id_cargo,
                            "nombre": nombre,
                            "tipo_pago": tipo_pago,
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
});

function LimpiarFormulario() {
    $('#modal-contrato').modal('hide');
    $('.modal-title').text('Formulario contrato');
    $("#id_empleado option:selected").removeAttr("selected");
    $("#id_empleado option:selected").removeAttr("selected");
    $('#formcontrato').trigger('reset');
    opcion = '';
};