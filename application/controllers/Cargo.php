<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cargo extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $data = array();

        $this->loadView('Cargo', 'formularios/cargo/cargo_form', $data);
    }
    public function obtenerCargosAjax()
    {
        $cargos = $this->Cargo_model->obtenerCargos();
        echo json_encode($cargos);
    }
    public function obtenerCargo()
    {
        $id_cargo = $this->input->post('id_cargo');
        $cargo = $this->Cargo_model->obetenerCargoId($id_cargo);
        echo json_encode((array) $cargo);
    }
    public function ingresar_cargo()
    {
        $nombre = $this->input->post('nombre');
        $tipo_pago = $this->input->post('tipo_pago');
        $sueldo_mensual = $this->input->post('sueldo');
        $sueldo_hora = $this->input->post('sueldo_hora');
        $hora_extra = $this->input->post('hora_extra');
        $hora_feriada = $this->input->post('hora_feriada');


        $this->form_validation->set_rules('nombre', 'nombre', 'trim|xss_clean|is_unique[cargo.nombre]');
        $this->form_validation->set_rules('tipo_pago', 'tipo_pago', 'trim|xss_clean|required');
        $this->form_validation->set_rules('sueldo', 'sueldo', 'trim|xss_clean|required');
        $this->form_validation->set_rules('sueldo_hora', 'sueldo_hora', 'trim|xss_clean|required');
        $this->form_validation->set_rules('hora_extra', 'hora_extra', 'trim|xss_clean|required');
        $this->form_validation->set_rules('hora_feriada', 'hora_feriada', 'trim|xss_clean|required');
        try {
            if ($this->form_validation->run() === false) {
                $error = form_error('nombre');
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos' . $error,
                );
            } else {

                $id_cargo = $this->Cargo_model->ingresarCargo($nombre, $tipo_pago, $sueldo_mensual, $sueldo_hora, $hora_extra, $hora_feriada);
                $cargo = $this->Cargo_model->obetenerCargoId($id_cargo);

                $respuesta = array(
                    'respuesta' => 'Exitoso',
                    'datos' => array(
                        'id_cargo' => $cargo['id_cargo'],
                        'nombre' => $cargo['nombre'],
                        'tipo_pago' => $cargo['tipo_pago'],
                        'sueldo_mensual' => $cargo['sueldo_mensual'],
                        'sueldo_hora' => $cargo['sueldo_hora'],
                        'hora_extra' => $cargo['hora_extra'],
                        'hora_feriada' => $cargo['hora_feriada'],

                    ),
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
    public function editarCargo()
    {
        $id_cargo = $this->input->post('id_cargo');
        $nombre = $this->input->post('nombre');
        $tipo_pago = $this->input->post('tipo_pago');
        $sueldo_mensual = $this->input->post('sueldo');
        $sueldo_hora = $this->input->post('sueldo_hora');
        $hora_extra = $this->input->post('hora_extra');
        $hora_feriada = $this->input->post('hora_feriada');

        $cargo = $this->Cargo_model->obetenerCargoId($id_cargo);
        if ($nombre == $cargo['nombre']) {
            $is_unique = '';
        } else {
            $is_unique = '|is_unique[cargo.nombre]';
        }

        $this->form_validation->set_rules('nombre', 'nombre', 'trim|xss_clean' . $is_unique);
        $this->form_validation->set_rules('tipo_pago', 'tipo_pago', 'trim|xss_clean|required');
        $this->form_validation->set_rules('sueldo', 'sueldo', 'trim|xss_clean|required');
        $this->form_validation->set_rules('sueldo_hora', 'sueldo_hora', 'trim|xss_clean|required');
        $this->form_validation->set_rules('hora_extra', 'hora_extra', 'trim|xss_clean|required');
        $this->form_validation->set_rules('hora_feriada', 'hora_feriada', 'trim|xss_clean|required');
        try {
            if ($this->form_validation->run() === false) {
                $error = form_error('nombre');
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos' . $error,
                );
            } else {

                $this->Cargo_model->editarCargo($id_cargo, $nombre, $tipo_pago, $sueldo_mensual, $sueldo_hora, $hora_extra, $hora_feriada);
                $cargo = $this->Cargo_model->obetenerCargoId($id_cargo);

                $respuesta = array(
                    'respuesta' => 'Exitoso',
                    'datos' => array(
                        'id_cargo' => $cargo['id_cargo'],
                        'nombre' => $cargo['nombre'],
                        'tipo_pago' => $cargo['tipo_pago'],
                        'sueldo_mensual' => $cargo['sueldo_mensual'],
                        'sueldo_hora' => $cargo['sueldo_hora'],
                        'hora_extra' => $cargo['hora_extra'],
                        'hora_feriada' => $cargo['hora_feriada'],

                    ),
                    'message' => 'Se edito correctamente',
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
    public function eliminarCargo($id_cargo)
    {
        $this->Cargo_model->eliminarCargo($id_cargo);
        $respuesta = array(
            'respuesta' => 'Exitoso',
            'message' => 'Se elimino al Cargo'
          );
          echo json_encode($respuesta);
    }
}
