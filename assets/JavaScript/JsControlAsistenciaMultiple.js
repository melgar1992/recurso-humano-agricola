$(document).ready(function () {
    
    $('#btn-agregar').click(function (e) { 
        e.preventDefault();
        empleado = $('#empleado').val();
        if (empleado != '') {
            empleado = empleado.split('.');
            id_empleado = empleado[0];
            nombre = empleado[1];
            cargo = empleado[2];
            console.log(id_empleado);
            console.log(nombre);
            console.log(cargo);
        } else {
            swal({
				title: 'Error',
				text: 'Tiene que seleccionar un empleado!',
				type: 'error'
			});
        }
    });
});