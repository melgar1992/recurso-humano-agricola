$(document).ready(function () {
    opcion = '';
    document.title = 'Sistema Agricola| Cargo';
    var tabla = $('#tablaEmpleados').DataTable({
        responsive: true,
        pageLength: 25,
        dom: "Bfrtip",
        ajax: { url: base_url + "Cargo/obtenerCargosAjax", dataSrc: "" },
        columns: [
            { data: 'id_cargo' },
            { data: 'nombre' },
            { data: 'tipo_pago' },
            { data: 'sueldo_mensual', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 'sueldo_hora', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 'hora_extra', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 'hora_feriada', render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ') },
            { data: 7 }
        ],
        buttons: [{
            extend: 'excelHtml5',
            title: "Listado de empleados",
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6],
            }

        },

        {
            extend: 'print',
            title: "Listado de empleados",
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
    //Cuando se ingresa un sueldo mes
    $('#sueldo').change(function (e) {
        sueldo = Number($(this).val());
        sueldo_hora = calculoSueldoHora(sueldo);
        $('#sueldo_hora').val(sueldo_hora.toFixed(2));

    });
    //Cuando se ingresa un sueldo hora
    $('#sueldo_hora').change(function (e) {
        sueldo_hora = Number($(this).val());
        sueldo = calculoSueldoMes(sueldo_hora);
        $('#sueldo').val(sueldo.toFixed(2));

    });
    // limpiar al cerrar
    $('#modal-cargo').on('hidden.bs.modal', function () {
        LimpiarFormulario();
    });
    //Botton editar cargo
    $(document).on('click', '#btn-editar', function () {
        fila = $(this).closest('tr');
        id_cargo = parseInt(fila.find('td:eq(0)').text());
        $('.modal-title').text('Editar cargo');
        $('#modal-cargo').modal('show');
        $.ajax({
            type: "POST",
            url: base_url + "Cargo/obtenerCargo",
            data: {
                id_cargo: id_cargo
            },
            dataType: "json",
            success: function (respuesta) {
                $('#nombre').val(respuesta['nombre']);
                $('#nombres').val(respuesta['nombres']);
                $("#tipo_pago option:contains(" + respuesta['tipo_pago'] + ")").attr("selected", true);
                $('#sueldo').val(Number(respuesta['sueldo_mensual']).toFixed(2));
                $('#sueldo_hora').val(Number(respuesta['sueldo_hora']).toFixed(2));
                $('#hora_extra').val(Number(respuesta['hora_extra']).toFixed(2));
                $('#hora_feriada').val(Number(respuesta['hora_feriada']).toFixed(2));

            }
        });
        opcion = 'editar';

    });
    //ingresar o editar Cargo
    $('#formCargo').submit(function (e) {
        e.preventDefault();
        nombre = $.trim($('#nombre').val());
        tipo_pago = $.trim($('#tipo_pago').val());
        sueldo = $.trim($('#sueldo').val());
        sueldo_hora = $.trim($('#sueldo_hora').val());
        hora_extra = $.trim($('#hora_extra').val());
        hora_feriada = $.trim($('#hora_feriada').val());
        $('#modal-cargo').modal('hide');

        if (opcion != 'editar') {
            $.ajax({
                type: "POST",
                url: base_url + "Cargo/ingresar_cargo",
                data: {
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
                        tabla.row.add({
                            "id_cargo": id_cargo,
                            "nombre": nombre,
                            "tipo_pago": tipo_pago,
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
                    url: base_url + "Cargo/eliminarCargo/" + id,
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
function calculoSueldoHora(sueldo_mensual) {
    sueldo_hora = (sueldo_mensual / 30) / 8;
    return sueldo_hora;
}
function calculoSueldoMes(sueldo_hora) {
    sueldo = (sueldo_hora * 8) * 30;
    return sueldo;
}
function LimpiarFormulario() {
    $('#modal-cargo').modal('hide');
    $('.modal-title').text('Formulario cargo');
    $("#tipo_pago option:selected").removeAttr("selected");
    $('#formCargo').trigger('reset');
    opcion = '';
};