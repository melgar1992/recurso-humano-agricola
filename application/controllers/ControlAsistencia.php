<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ControlAsistencia extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array(
            'empleados' => $this->Empleado_model->obtenerEmpleados(),
            'cargos' => $this->Cargo_model->obtenerCargos(),
        );

        $this->loadView("ControlAsistencia", "formularios/control_asistencia/control_asistencia_form", $data);
    }
}
