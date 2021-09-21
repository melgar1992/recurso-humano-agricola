$(document).ready(function () {
	document.title = 'Sistema Agricola';
	var tablaAsistencia = $('#tablaDetalleAsistencia').DataTable({
		responsive: true,
		pageLength: 25,
		dom: "Bfrtip",
		ajax: {
			url: base_url + "ControlAsistencia/obtenerAsistencias",
			dataSrc: ""
		},
		columns: [{
				data: 'id_control_asistencia',
				width: '50px'
			},
			{
				data: 'nombre_completo'
			},
			{
				data: 'cargo_nombre'
			},
			{
				data: 'fecha_hora_ingreso'
			},
			{
				data: 'fecha_hora_salida'
			},
			{
				data: 'hora_trabajadas'
			},
			{
				data: 'observaciones'
			},
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
	$(document).on('click', '.btn-print', function () {

		$("#modal-detalle .modal-body").print({
			//Use Global styles
			globalStyles: true,
			//Add link with attrbute media=print
			mediaPrint: false,
			//Print in a hidden iframe
			iframe: true,
			//Don't print this

		});
	});
	$(document).on('submit', '#reporte-contrato', function (e) {
		e.preventDefault();
		id_contrato = $.trim($('#id_contrato').val());
		fechaIni = $.trim($('#fechaIni').val());
		fechaFin = $.trim($('#fechaFin').val());
		if (fechaIni < fechaFin) {
			$.ajax({
				type: "POST",
				url: base_url + "/Dashboard/reporteContrato",
				data: {
					id_contrato: id_contrato,
					fechaIni: fechaIni,
					fechaFin: fechaFin,
				},
				dataType: "html",
				success: function (respuesta) {
					$('#modal-detalle .modal-body').html(respuesta);
				}
			});
		} else {
			swal({
				title: 'Error de fecha',
				text: 'La fecha inicial no puede ser mayor que la final',
				type: 'error'
			});
		}
	});
});
