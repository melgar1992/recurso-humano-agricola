<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contrato extends BaseController
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

        $this->loadView("Contrato", "formularios/contrato/contrato_form", $data);
    }
    public function obtenerCargosAjax()
    {
        $cargos = $this->Contrato_model->obtenerContratos();
        echo json_encode($cargos);
    }
}
