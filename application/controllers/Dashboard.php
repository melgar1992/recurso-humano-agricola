<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends BaseController
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

    $this->loadView("Dashboard", "dashboards/dashboard", $data);
  }
  public function reporteContrato()
  {
    $id_contrato = $this->input->post('id_contrato');
    $fechaIni = $this->input->post('fechaIni');
    $fechaFin = $this->input->post('fechaFin');

    $datos['contrato'] = $this->Contrato_model->obtenerContrato($id_contrato);

  }
}
