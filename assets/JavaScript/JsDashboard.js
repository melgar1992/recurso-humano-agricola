$(document).ready(function () {
	document.title = 'Sistema Agricola Dashboard';
	let year = new Date();
	year = year.getFullYear();
	GenerarGraficoHorasTrabajadas(year);
	let tablaAsistencia = $('#tablaHorasMes').DataTable({
		responsive: true,
		pageLength: 25,
		dom: "Bfrtip",
		ordering: false,
		ajax: {
			url: base_url + "Dashboard/tablaHorasEmpleadosMes",
			dataSrc: ""
		},
		columns: [{
				data: 'nombre_completo'
			},
			{
				data: 'ci'
			},
			{
				data: 'hora_trabajadas'
			},
			{
				data: 'mes',
			},
		],
		// columnDefs: [{
		//     targets: -1,
		//     data: 'mes',
		//     render: function (data, type, row, meta) {
		//         return mes.at(data - 1);
		//     }
		// }],
		buttons: [{
				extend: 'excelHtml5',
				title: "Listado de empleados",
				exportOptions: {
					columns: [0, 1, 2, 3],
				}

			},
			{
				extend: 'print',
				title: "Listado de empleados",
				exportOptions: {
					columns: [0, 1, 2, 3],

				}
			}
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
	let tablaContratosActivos = $('#tablaEmpleadosActivos').DataTable({
		responsive: true,
		pageLength: 25,
		dom: "Bfrtip",
		ajax: {
			url: base_url + "Contrato/obtenerContratosVigentes",
			dataSrc: ""
		},
		columns: [{
				data: 'id_contrato',
				width: '50px'
			},
			{
				data: 'nombre_completo'
			},
			{
				data: 'cargo_nombre'
			},
			{
				data: 'sueldo_mensual',
				render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ')
			},
			{
				data: 'sueldo_hora',
				render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ')
			},
			{
				data: 'hora_extra',
				render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ')
			},
			{
				data: 'hora_feriada',
				render: $.fn.dataTable.render.number(',', '.', 2, 'Bs ')
			},
			{
				data: 'tipo_pago'
			},
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
	//Generar de nuevo el grafico cuando se cambia de ano
	$('#year').on('change', function () {
		yearselected = $(this).val();	
		GenerarGraficoHorasTrabajadas(yearselected);
	});

});

function resetGrafico() {
	$('#GraficoHT').remove(); // this is my <canvas> element
	$('#graficoHorasTrabajadas').append('<canvas id="GraficoHT" ></canvas>');
}

function GenerarGraficoHorasTrabajadas(year) {
	$.ajax({
		type: "POST",
		url: base_url + "/Dashboard/horasTrabajadasXMes",
		data: {
			year: year
		},
		dataType: "json",
		success: function (datos) {
			resetGrafico();
			GraficoHorasTrabadajas(datos);
		}
	});
}

function GraficoHorasTrabadajas(data) {

	// var f = document.getElementById("GraficoHT");
	var f = document.getElementById("GraficoHT").getContext('2d');
	new Chart(f, {
		type: "line",
		data: {
			labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
			datasets: [{
				label: "Horas trabajadas",
				backgroundColor: "rgba(38, 185, 154, 0.31)",
				borderColor: "rgba(38, 185, 154, 0.7)",
				pointBorderColor: "rgba(38, 185, 154, 0.7)",
				pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
				pointHoverBackgroundColor: "#fff",
				pointHoverBorderColor: "rgba(220,220,220,1)",
				pointBorderWidth: 1,
				data: data,
			}]
		},
		options: {
			maintainAspectRatio: false,
		}

	});
}
