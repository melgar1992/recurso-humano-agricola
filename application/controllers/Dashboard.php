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
      'contratosVigentes' => $this->Contrato_model->obtenerContratosVigentes(),
      'BalanceEmpleados' => $this->Reporte_model->obtenerBalanceDelMesEmpleados(),
      'year' => $this->Reporte_model->obtenerAnosTrabajo(),
    );

    $this->loadView("Dashboard", "dashboards/dashboard", $data);
  }
  public function reporteContrato()
  {
    $id_contrato = $this->input->post('id_contrato');
    $fechaIni = $this->input->post('fechaIni');
    $fechaFin = $this->input->post('fechaFin');

    $datos['contrato'] = $this->Contrato_model->obtenerContrato($id_contrato);
    $datos['ingresosAsistenciaContrato'] = $this->Reporte_model->obtenerIngresosContratoEntreFecha($id_contrato, $fechaIni, $fechaFin);
    $datos['ingresosDirectoContrato'] = $this->Reporte_model->obtenerIngresosDirectoEntreFecha($id_contrato, $fechaIni, $fechaFin);
    $datos['pagosContrato'] = $this->Reporte_model->obtenerpagosEntreFecha($id_contrato, $fechaIni, $fechaFin);
		$this->load->view('reportes/reporteContrato', $datos);

  }
  public function tablaHorasEmpleadosMes()
  {
    $horasMesEmpleados = $this->Reporte_model->obtenerHorasEmpleadosPorMes();
    echo json_encode($horasMesEmpleados);
  }
  public function horasTrabajadasXMes()
  {
    $year = $this->input->post('year');
    $horasMes = $this->Reporte_model->obtenerSumaHoraTrabajadasMes($year);
    echo json_encode($horasMes);
  }
}
