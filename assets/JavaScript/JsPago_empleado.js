$(document).ready(function () {
    opcion = '';
    document.title = 'Sistema Agricola| Pago Empleados';
    var tabla = $('#tabla').DataTable({
        responsive: true,
        pageLength: 25,
        dom: "Blfrtip",
        ajax: { url: base_url + "Pago_empleados/obtenerPagosAjax", dataSrc: "" },
        columns: [
            { data: 'id_pagos_empleados' },
            { data: 'fecha' },
            { data: 'nombre_completo' },
            { data: 'cargo_nombre' },
            { data: 'detalle' },
            { data: 'haber', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 7 }
        ],
        buttons: [{
            extend: 'excelHtml5',
            title: "Listado de pago",
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6],
            }

        },
        {
            extend: 'print',
            title: "Listado de pago",
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6],

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
     $('#modal-form').on('hidden.bs.modal', function () {
        LimpiarFormulario();
    });
    //Botton editar empleado
    $(document).on('click', '#btn-editar', function () {
        fila = $(this).closest('tr');
        id_pagos_empleados = parseInt(fila.find('td:eq(0)').text());
        LimpiarFormulario()
        $('.modal-title').text('Editar pago');
        $('#modal-form').modal('show');
        $.ajax({
            type: "POST",
            url: base_url + "Pago_empleados/obtenerPagoEmpleadoAjax",
            data: {
                id_pagos_empleados: id_pagos_empleados
            },
            dataType: "json",
            success: function (respuesta) {
                $("#id_contrato option[value=" + respuesta['id_contrato'] + "]").attr("selected", true);
                $('#haber').val(Number(respuesta['haber']).toFixed(2));
                $('#detalle').text(respuesta['detalle']);
                $('#fecha').val(respuesta['fecha']);
            }
        });
        opcion = 'editar';

    });
    //ingresar o editar Feriado
    $('#formulario').submit(function (e) {
        e.preventDefault();
        id_contrato = $.trim($('#id_contrato').val());
        haber = $.trim($('#haber').val());
        detalle = $.trim($('#detalle').val());
        fecha = $.trim($('#fecha').val());
         $('#modal-form').modal('hide');

        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "Pago_empleados/ingresarPagoEmpleado",
                data: {
                    id_contrato: id_contrato,
                    haber: haber,
                    detalle: detalle,
                    fecha: fecha,
                },
                dataType: "json",
                success: function (respuesta) {
                    if (respuesta['respuesta'] === 'Exitoso') {
                        id_pagos_empleados = respuesta['datos']['id_pagos_empleados'];
                        id_contrato = respuesta['datos']['id_contrato'];
                        nombre_completo = respuesta['datos']['nombre_completo'];
                        cargo_nombre = respuesta['datos']['cargo_nombre'];
                        haber = respuesta['datos']['haber'];
                        detalle = respuesta['datos']['detalle'];
                        fecha = respuesta['datos']['fecha'];
                        tabla.row.add({
                            "id_pagos_empleados": id_pagos_empleados,
                            "id_contrato": id_contrato,
                            "nombre_completo": nombre_completo,
                            "cargo_nombre": cargo_nombre,
                            "haber": haber,
                            "detalle": detalle,
                            "fecha": fecha,
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
    $('.modal-title').text('Formulario pago de empleados');
    $("#id_contrato option:selected").removeAttr("selected");
    $('#formulario').trigger('reset');
    opcion = '';
};