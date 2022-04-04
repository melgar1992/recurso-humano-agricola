$(document).ready(function () {
	$('#btn-agregar').click(function (e) {
		e.preventDefault();
		var now = new Date();
		empleado = $('#empleado').val();
		fechaValidar = $('#fecha').val();
		fecha = $('#fecha').val();
		fechaini = fecha + 'T' + '07' + ':30';
		fechafin = fecha + 'T' + '12' + ':30';
		if (empleado != '' && fechaValidar != '') {
			empleado = empleado.split('.');
			id_empleado = empleado[0];
			nombre = empleado[1];
			cargo = empleado[2];
			html = "<tr>";
			html += "<td>" + nombre + "</td>";
			html += "<td>" + cargo + "</td>";
			html += "<td hidden><input type='hidden' class='' id='id_contrato[]' name = 'id_contrato[]' value ='" + id_empleado + "'></td>"
			html += '<td><input type="datetime-local" class="" id="fecha_hora_ingreso[]" name="fecha_hora_ingreso[]" value = ' + fechaini + ' required="required"></td>';
			html += '<td><input type="datetime-local" class= "" id="fecha_hora_salida[]" name="fecha_hora_salida[]" value = ' + fechafin + ' required="required"></td>';
			html += '<td><input type="text" minlength="0" maxlength="45" class= "observaciones" id="observaciones[]" name="observaciones[]"></td>';
			html += "<td><button type='button' class='btn btn-danger btn-remove-asistencia'><span class='fa fa-remove'></span></button></td>";
			html += "</tr>";
			$("#tablaAsistencia tbody").append(html);
		} else {
			swal({
				title: 'Error',
				text: 'Tiene que seleccionar un empleado y seleccionar una fecha!',
				type: 'error'
			});
		}
	});
	$(document).on("click", ".btn-remove-asistencia", function () {
		$(this).closest("tr").remove();

	});
	$(document).on('submit', '#formasistencia', function (e) {
		e.preventDefault();
		$("#btn-guardar").attr("disabled", true);
		id_contrato = new Array;
		fecha_hora_ingreso = new Array;
		fecha_hora_salida = new Array;
		observaciones = new Array;
		fechas_validas = Boolean;

		id_contrato2 = document.formasistencia.elements['id_contrato[]'];
		fecha_hora_ingreso2 = document.formasistencia.elements['fecha_hora_ingreso[]'];
		fecha_hora_salida2 = document.formasistencia.elements['fecha_hora_salida[]'];
		observaciones2 = document.formasistencia.elements['observaciones[]'];

		if (typeof id_contrato2 != 'undefined') {

			if (typeof id_contrato2.length === 'undefined') {
				id_contrato.push(id_contrato2.value);
				fecha_hora_ingreso.push(fecha_hora_ingreso2.value);
				fecha_hora_salida.push(fecha_hora_salida2.value);
				observaciones.push(observaciones2.value);
				fechas_validas = validarFechas(fecha_hora_ingreso, fecha_hora_salida)
			} else {
				for (i = 0; i < id_contrato2.length; i++) {
					id_contrato.push(id_contrato2[i].value);
					fecha_hora_ingreso.push(fecha_hora_ingreso2[i].value);
					fecha_hora_salida.push(fecha_hora_salida2[i].value);
					observaciones.push(observaciones2[i].value);
					fechas_validas = validarFechas(fecha_hora_ingreso[i], fecha_hora_salida[i]);
					if (fechas_validas === false) {
						break;
					}

				};
			}
			if (fechas_validas) {
				$.ajax({
					type: "POST",
					url: base_url + "ControlAsistencia/ingresar_asistencia_multiple",
					data: {
						id_contrato: id_contrato,
						fecha_hora_ingreso: fecha_hora_ingreso,
						fecha_hora_salida: fecha_hora_salida,
						observaciones: observaciones,
					},
					dataType: "json",
					success: function (respuesta) {
						if (respuesta['respuesta'] === 'Exitoso') {
							Swal.fire({
								title: 'Se guardo!',
								text: "Se guardo todo correctamente!",
								type: 'success',
								showCancelButton: false,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Ok'
							}).then((result) => {
								if (result.value) {
									window.location.href = base_url + "ControlAsistencia";
								}
							})
						} else {
							swal({
								title: 'Error',
								text: 'Ups algo malo sucedio ' + respuesta['mensaje'],
								type: 'error'
							});
							$("#btn-guardar").attr("disabled", false);

						}
					}
				});
			} else {
				swal({
					title: 'Fechas',
					text: 'La salida tiene que ser depues del ingreso',
					type: 'error'
				});
				$("#btn-guardar").attr("disabled", false);
			}

		} else {
			swal({
				title: 'Cuidado',
				text: 'Tiene que ingresar asistencia para poder guardar',
				type: 'warning'
			});
			$("#btn-guardar").attr("disabled", false);

		}

	});
});

function addZero(i) {
	if (i < 10) {
		i = "0" + i
	}
	return i;
}

function validarFechas(fecha_hora_ingreso, fecha_hora_salida) {

	if (fecha_hora_ingreso <= fecha_hora_salida) {
		return true;
	} else {
		return false;
	}

}
