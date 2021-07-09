<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empleado extends BaseController
{

  function __construct()
  {
    parent::__construct();
  }


  public function index()
  {

    $data = array();

    $this->loadView("Empleado", "formularios/empleado/empleado_form", $data);
  }
  public function obtenerEmpleadosTablaEmpleados()
  {
    $empleados = $this->Empleado_model->obtenerEmpleados();
    echo json_encode($empleados);
  }
  public function obtenerEmpleadoAjax()
  {
    $id_empleado = $this->input->post('id_empleado');
    $empleado = $this->Empleado_model->obtenerEmpleadoId($id_empleado);
    $respuesta = (array) $empleado;
    echo json_encode($respuesta);
  }

  public function ingresar_empleado()
  {
    $this->form_validation->set_rules('ci', 'ci', 'trim|is_unique[empleados.ci]');
    $this->form_validation->set_rules('nombres', 'nombres', 'trim|required');
    $this->form_validation->set_rules('apellidos', 'apellidos', 'trim|required');
    $this->form_validation->set_rules('telefono', 'telefono', 'trim');
    $this->form_validation->set_rules('direccion', 'direccion', 'trim');
    try {
      if ($this->form_validation->run() === false) {
        $error = form_error('ci');
        $respuesta = array(
          'respuesta' => 'Error',
          'mensaje' => 'Ocurrio un problema al validar los datos' . $error,
        );
      } else {
        $ci = $this->input->post('ci');
        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');
        $telefono = $this->input->post('telefono');
        $direccion = $this->input->post('direccion');

        $id_empleado = $this->Empleado_model->ingresarEmpleado($ci, $nombres, $apellidos, $telefono, $direccion);
        $empleado = $this->Empleado_model->obtenerEmpleadoId($id_empleado);

        $respuesta = array(
          'respuesta' => 'Exitoso',
          'datos' => array(
            'id_empleado' => $empleado['id_empleado'],
            'ci' => $empleado['ci'],
            'nombres' => $empleado['nombres'],
            'apellidos' => $empleado['apellidos'],
            'telefono' => $empleado['telefono'],
            'direccion' => $empleado['direccion'],
          ),
          'message' => 'Se guardo correctamente',
        );
      }
    } catch (\Throwable $th) {
      $respuesta = array(
        'respuesta' => 'Error',
        'mensaje' => $th,
      );
    }
    echo json_encode($respuesta);
  }
  public function editarEmpleado()
  {
    $id_empleado = $this->input->post('id_empleado');
    $ci = $this->input->post('ci');
    $nombres = $this->input->post('nombres');
    $apellidos = $this->input->post('apellidos');
    $telefono = $this->input->post('telefono');
    $direccion = $this->input->post('direccion');
    $empleado = $this->Empleado_model->obtenerEmpleadoId($id_empleado);
    if ($ci == $empleado['ci']) {
      $is_unique = '';
    } else {
      $is_unique = '|is_unique[cliente.CI]';
    }


    $this->form_validation->set_rules('ci', 'ci', 'trim' . $is_unique);
    $this->form_validation->set_rules('nombres', 'nombres', 'trim|required');
    $this->form_validation->set_rules('apellidos', 'apellidos', 'trim|required');
    $this->form_validation->set_rules('telefono', 'telefono', 'trim');
    $this->form_validation->set_rules('direccion', 'direccion', 'trim');
    try {
      if ($this->form_validation->run() === false) {
        $error = form_error('ci');
        $respuesta = array(
          'respuesta' => 'Error',
          'mensaje' => 'Ocurrio un problema al validar los datos' . $error,
        );
      } else {

        $id_empleado = $this->Empleado_model->ingresarEmpleado($ci, $nombres, $apellidos, $telefono, $direccion);
        $empleado = $this->Empleado_model->obtenerEmpleadoId($id_empleado);

        $respuesta = array(
          'respuesta' => 'Exitoso',
          'datos' => array(
            'id_empleado' => $empleado['id_empleado'],
            'ci' => $empleado['ci'],
            'nombres' => $empleado['nombres'],
            'apellidos' => $empleado['apellidos'],
            'telefono' => $empleado['telefono'],
            'direccion' => $empleado['direccion'],
          ),
          'message' => 'Se guardo correctamente',
        );
      }
    } catch (\Throwable $th) {
      $respuesta = array(
        'respuesta' => 'Error',
        'mensaje' => $th,
      );
    }
    echo json_encode($respuesta);
  }
}
