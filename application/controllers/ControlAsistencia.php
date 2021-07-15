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
            'contratos' => $this->Contrato_model->obtenerContratosOrdenApellidos(),
        );

        $this->loadView("ControlAsistencia", "formularios/control_asistencia/control_asistencia_form", $data);
    }
    public function obtenerAsistencias()
    {
        $asistencias = $this->Control_asistencia_model->obtenerAsistencias();
        echo json_encode($asistencias);
    }
}
