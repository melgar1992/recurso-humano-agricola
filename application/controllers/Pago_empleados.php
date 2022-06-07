<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pago_empleados extends BaseController
{

  public function pago_empleado()
  {

    $data = array(
      'contratos' => $this->Contrato_model->obtenerContratosOrdenApellidos(),
    );


    $this->loadView("Pago_empleado", "formularios/pago_empleado/pago_empleado_form", $data);
  }
  public function ingreso_directo_form()
  {

    $data = array(
      'contratos' => $this->Contrato_model->obtenerContratosOrdenApellidos(),
    );

    $this->loadView("IngresoDirecto", "formularios/pago_empleado/ingreso_directo_form", $data);
  }
  public function obtenerIngresosAjax()
  {
    $ingresos = $this->Pago_empleado_model->obtenerIngresosEmpleados();
    echo json_encode($ingresos);
  }
  public function obtenerPagosAjax()
  {
    $pagos = $this->Pago_empleado_model->obtenerPagosEmpleados();
    echo json_encode($pagos);
  }
  public function obtenerPagoEmpleadoAjax()
  {
    $id_pagos_empleados = $this->input->post('id_pagos_empleados');
    $pago = $this->Pago_empleado_model->obtenerPagoEmpleado($id_pagos_empleados);
    echo json_encode($pago);
  }
  public function boletaPago()
  {
    $id_pagos_empleados = $this->input->post('id_pagos_empleados');
    $pago = $this->Pago_empleado_model->obtenerPagoEmpleado($id_pagos_empleados);
    $this->load->view('reportes/boletaPago', $pago);
  }
  public function ingresarIngresoEmpleado()
  {
    $id_contrato = $this->input->post('id_contrato');
    $debe = $this->input->post('debe');
    $hora_trabajo = $this->input->post('hora_trabajo');
    $detalle = $this->input->post('detalle');
    $fecha = $this->input->post('fecha');

    $this->form_validation->set_rules('id_contrato', 'id_contrato', 'trim|xss_clean|required');
    $this->form_validation->set_rules('debe', 'debe', 'trim|xss_clean|required');
    $this->form_validation->set_rules('fecha', 'fecha', 'trim|xss_clean|required');
    try {
      if ($this->form_validation->run() === false) {
        $respuesta = array(
          'respuesta' => 'Error',
          'mensaje' => 'Ocurrio un problema al validar los datos',
        );
      } else {
        $datos = array(
          'id_contrato' => $id_contrato,
          'debe' => $debe,
          'hora_trabajo' => $hora_trabajo,
          'detalle' => $detalle,
          'fecha' => $fecha,
        );
        $id_pagos_empleados = $this->Pago_empleado_model->ingresarPagoEmpleado($datos);
        $pagoEmpleado = $this->Pago_empleado_model->obtenerPagoEmpleado($id_pagos_empleados);
        $respuesta = array(
          'respuesta' => 'Exitoso',
          'datos' => $pagoEmpleado,
          'message' => 'Se guardo correctamente',
        );
      }
    } catch (Exception  $th) {
      $respuesta = array(
        'respuesta' => 'Error',
        'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
      );
    }
    echo json_encode($respuesta);
  }
  public function ingresarPagoEmpleado()
  {
    $id_contrato = $this->input->post('id_contrato');
    $haber = $this->input->post('haber');
    $detalle = $this->input->post('detalle');
    $fecha = $this->input->post('fecha');

    $this->form_validation->set_rules('id_contrato', 'id_contrato', 'trim|xss_clean|required');
    $this->form_validation->set_rules('haber', 'haber', 'trim|xss_clean|required');
    $this->form_validation->set_rules('fecha', 'fecha', 'trim|xss_clean|required');
    try {
      if ($this->form_validation->run() === false) {
        $respuesta = array(
          'respuesta' => 'Error',
          'mensaje' => 'Ocurrio un problema al validar los datos',
        );
      } else {
        $datos = array(
          'id_contrato' => $id_contrato,
          'haber' => $haber,
          'detalle' => $detalle,
          'fecha' => $fecha,
        );
        $id_pagos_empleados = $this->Pago_empleado_model->ingresarPagoEmpleado($datos);
        $pagoEmpleado = $this->Pago_empleado_model->obtenerPagoEmpleado($id_pagos_empleados);
        $respuesta = array(
          'respuesta' => 'Exitoso',
          'datos' => $pagoEmpleado,
          'message' => 'Se guardo correctamente',
        );
      }
    } catch (Exception  $th) {
      $respuesta = array(
        'respuesta' => 'Error',
        'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
      );
    }
    echo json_encode($respuesta);
  }
  public function editarIngresoEmpleado()
  {
    $id_pagos_empleados = $this->input->post('id_pagos_empleados');
    $id_contrato = $this->input->post('id_contrato');
    $debe = $this->input->post('debe');
    $hora_trabajo = $this->input->post('hora_trabajo');
    $detalle = $this->input->post('detalle');
    $fecha = $this->input->post('fecha');

    $this->form_validation->set_rules('id_contrato', 'id_contrato', 'trim|xss_clean|required');
    $this->form_validation->set_rules('debe', 'debe', 'trim|xss_clean|required');
    $this->form_validation->set_rules('fecha', 'fecha', 'trim|xss_clean|required');
    try {
      if ($this->form_validation->run() === false) {
        $respuesta = array(
          'respuesta' => 'Error',
          'mensaje' => 'Ocurrio un problema al validar los datos',
        );
      } else {
        $datos = array(
          'id_contrato' => $id_contrato,
          'debe' => $debe,
          'hora_trabajo' => $hora_trabajo,
          'detalle' => $detalle,
          'fecha' => $fecha,
        );
        $this->Pago_empleado_model->editarPagoEmpleado($id_pagos_empleados, $datos);
        $pagoEmpleado = $this->Pago_empleado_model->obtenerPagoEmpleado($id_pagos_empleados);
        $respuesta = array(
          'respuesta' => 'Exitoso',
          'datos' => $pagoEmpleado,
          'message' => 'Se guardo correctamente',
        );
      }
    } catch (Exception  $th) {
      $respuesta = array(
        'respuesta' => 'Error',
        'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
      );
    }
    echo json_encode($respuesta);
  }
  public function editarPagoEmpleado()
  {
    $id_pagos_empleados = $this->input->post('id_pagos_empleados');
    $id_contrato = $this->input->post('id_contrato');
    $haber = $this->input->post('haber');
    $detalle = $this->input->post('detalle');
    $fecha = $this->input->post('fecha');

    $this->form_validation->set_rules('id_contrato', 'id_contrato', 'trim|xss_clean|required');
    $this->form_validation->set_rules('haber', 'haber', 'trim|xss_clean|required');
    $this->form_validation->set_rules('fecha', 'fecha', 'trim|xss_clean|required');
    try {
      if ($this->form_validation->run() === false) {
        $respuesta = array(
          'respuesta' => 'Error',
          'mensaje' => 'Ocurrio un problema al validar los datos',
        );
      } else {
        $datos = array(
          'id_contrato' => $id_contrato,
          'haber' => $haber,
          'detalle' => $detalle,
          'fecha' => $fecha,
        );
        $this->Pago_empleado_model->editarPagoEmpleado($id_pagos_empleados, $datos);
        $pagoEmpleado = $this->Pago_empleado_model->obtenerPagoEmpleado($id_pagos_empleados);
        $respuesta = array(
          'respuesta' => 'Exitoso',
          'datos' => $pagoEmpleado,
          'message' => 'Se guardo correctamente',
        );
      }
    } catch (Exception  $th) {
      $respuesta = array(
        'respuesta' => 'Error',
        'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
      );
    }
    echo json_encode($respuesta);
  }
  public function eliminarPagoEmpleado($id_pagos_empleados)
  {
    $this->Pago_empleado_model->eliminarPago($id_pagos_empleados);
    $respuesta = array(
      'respuesta' => 'Exitoso',
      'message' => 'Se elimino al empleado'
    );
    echo json_encode($respuesta);
  }
}
