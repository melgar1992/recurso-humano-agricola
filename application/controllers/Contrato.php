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
    public function obtenerContratosAjax()
    {
        $cargos = $this->Contrato_model->obtenerContratos();
        echo json_encode($cargos);
    }
    public function obtenerContrato()
    {
        $id_contrato = $this->input->post('id_contrato');;
        $cargo = $this->Contrato_model->obtenerContrato($id_contrato);
        echo json_encode($cargo);
    }
    public function ingresar_contrato()
    {
        $this->form_validation->set_rules('id_empleado', 'id_empleado', 'trim|xss_clean|is_unique[empleados.ci]');
        $this->form_validation->set_rules('id_cargo', 'id_cargo', 'trim|xss_clean|required');
        $id_empleado = $this->input->post('id_empleado');
        $id_cargo = $this->input->post('id_cargo');
        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos',
                );
            } else {
                if ($this->Contrato_model->existeContrato($id_empleado, $id_cargo)) {
                    $respuesta = array(
                        'respuesta' => 'Error',
                        'mensaje' => 'El contrato con este empleado ya existe!',
                    );
                } else {
                    $id_contrato = $this->Contrato_model->ingresarContrato($id_empleado, $id_cargo);
                    $contrato = $this->Contrato_model->obtenerContrato($id_contrato);
                    $respuesta = array(
                        'respuesta' => 'Exitoso',
                        'datos' => $contrato,
                        'message' => 'Se guardo correctamente',
                    );
                }
            }
        } catch (Exception  $th) {
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
            );
        }
        echo json_encode($respuesta);
    }

    public function editarContrato()
    {

        $this->form_validation->set_rules('id_empleado', 'id_empleado', 'trim|xss_clean|is_unique[empleados.ci]');
        $this->form_validation->set_rules('id_cargo', 'id_cargo', 'trim|xss_clean|required');
        $id_contrato = $this->input->post('id_contrato');
        $id_empleado = $this->input->post('id_empleado');
        $id_cargo = $this->input->post('id_cargo');
        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos',
                );
            } else {
                if ($this->Contrato_model->existeContrato($id_empleado, $id_cargo)) {
                    $respuesta = array(
                        'respuesta' => 'Error',
                        'mensaje' => 'El contrato con este empleado ya existe!',
                    );
                } else {
                    $this->Contrato_model->editarContrato($id_contrato, $id_empleado, $id_cargo);
                    $contrato = $this->Contrato_model->obtenerContrato($id_contrato);
                    $respuesta = array(
                        'respuesta' => 'Exitoso',
                        'datos' => $contrato,
                        'message' => 'Se edito correctamente',
                    );
                }
            }
        } catch (Exception  $th) {
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
            );
        }
        echo json_encode($respuesta);
    }
    public function eliminarContrato($id_contrato)
    {
        $this->Contrato_model->eliminarContrato($id_contrato);
        $respuesta = array(
            'respuesta' => 'Exitoso',
            'message' => 'Se elimino al empleado'
        );
        echo json_encode($respuesta);
    }
}
