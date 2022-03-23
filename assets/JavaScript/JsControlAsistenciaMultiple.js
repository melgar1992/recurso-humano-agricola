$(document).ready(function () {
	$('#btn-agregar').click(function (e) {
		e.preventDefault();
		var now = new Date();
		empleado = $('#empleado').val();
		fechaValidar = $('#fecha').val();
		fecha = $('#fecha').val();
		fecha = fecha + 'T' + '07' + ':00';
		if (empleado != '' && fechaValidar != '') {
			empleado = empleado.split('.');
			id_empleado = empleado[0];
			nombre = empleado[1];
			cargo = empleado[2];
			html = "<tr>";
			html += "<td>" + nombre + "</td>";
			html += "<td>" + cargo + "</td>";
			html += "<td hidden><input type='hidden' class='id_contrato' id='id_contrato[]' name = 'id_contrato[]' value ='" + id_empleado + "'></td>"
			html += '<td><input type="datetime-local" class="fecha_hora_ingreso" id="fecha_hora_ingreso[]" name="fecha_hora_ingreso[]" value = ' + fecha + ' required="required"></td>';
			html += '<td><input type="datetime-local" class= "fecha_hora_ingreso" id="fecha_hora_salida[]" name="fecha_hora_salida[]" value = ' + fecha + ' required="required"></td>';
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
		console.log('entro!!');

		id_contrato = new Array;
		fecha_hora_ingreso = new Array;
		fecha_hora_salida = new Array;
		observaciones = new Array;

		id_contrato2 = document.formasistencia.elements['id_contrato[]'];
		fecha_hora_ingreso2 = document.formasistencia.elements['fecha_hora_ingreso[]'];
		fecha_hora_salida2 = document.formasistencia.elements['fecha_hora_salida[]'];
		observaciones2 = document.formasistencia.elements['observaciones[]'];

        if (typeof id_contrato2 != 'undefined') {
            id_contrato2.forEach(id_contrato2 => {
                id_contrato.push(id_contrato2.value);
                fecha_hora_ingreso.push(fecha_hora_ingreso2.value);
                fecha_hora_salida.push(fecha_hora_salida2.value);
                observaciones.push(observaciones2.value);
            });
        } else {
            swal({
				title: 'Cuidado',
				text: 'Tiene que ingresar asistencia para poder guardar',
				type: 'warning'
			});
        }
        console.log(fecha_hora_ingreso, fecha_hora_salida);
        console.log(id_contrato);
        fecha_hora_ingreso.forEach(index =>{
            if (validarFechas(fecha_hora_ingreso[index], fecha_hora_salida[index])) {
                
            } else {
                swal({
                    title: 'Fechas',
                    text: 'La salida tiene que ser depues del ingreso',
                    type: 'error'
                });
            }
        })
        console.log(fecha_hora_ingreso);
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
        return false;
    }
    else {
        return true;
    }

  }
