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
}
