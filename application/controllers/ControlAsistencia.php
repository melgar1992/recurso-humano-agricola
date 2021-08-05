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
    public function obtenerAsistenciaAjax()
    {
        $id_control_asistencia = $this->input->post('id_control_asistencia');
        $asistencia = $this->Control_asistencia_model->obtenerAsistencia($id_control_asistencia);
        echo json_encode($asistencia);
    }
    public function ingresar_asistencia()
    {
        $this->form_validation->set_rules('id_contrato', 'id_contrato', 'trim|xss_clean|required');
        $this->form_validation->set_rules('fecha_hora_ingreso', 'fecha_hora_ingreso', 'trim|xss_clean');
        $this->form_validation->set_rules('fecha_hora_salida', 'fecha_hora_salida', 'trim|xss_clean');
        $this->form_validation->set_rules('observaciones', 'observaciones', 'trim|xss_clean');

        $id_contrato = $this->input->post('id_contrato');
        $id_usuario = $this->session->userdata('id_usuario');
        $fecha_hora_ingreso = $this->input->post('fecha_hora_ingreso');
        $fecha_hora_salida = $this->input->post('fecha_hora_salida');
        $observaciones = $this->input->post('observaciones');
        $ultima_edicion = date('Y-m-d H:i:s');

        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos',
                );
            } else {
                $existeAsistenciaEntreTiempo = $this->Control_asistencia_model->existeAsistenciaEntreTiempo($id_contrato, $fecha_hora_ingreso, $fecha_hora_salida);
                if ($existeAsistenciaEntreTiempo['respuesta'] == false) {
                    $datos = array(
                        'id_contrato' => $id_contrato,
                        'id_usuario' => $id_usuario,
                        'fecha_hora_ingreso' => $fecha_hora_ingreso,
                        'fecha_hora_salida' => $fecha_hora_salida,
                        'observaciones' => $observaciones,
                        'ultima_edicion' => $ultima_edicion,
                    );
                    $id_control_asistencia = $this->Control_asistencia_model->ingresarControl($datos);
                    $asistencia = $this->Control_asistencia_model->obtenerAsistencia($id_control_asistencia);
                    $respuesta = array(
                        'respuesta' => 'Exitoso',
                        'datos' => $asistencia,
                        'message' => 'Se guardo correctamente',
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'Error',
                        'mensaje' => $existeAsistenciaEntreTiempo['mensaje'],
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
}
