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
    public function ControlAsistenciaMultiple()
    {
        $data = array(
            'contratos' => $this->Contrato_model->obtenerContratosOrdenApellidos(),
        );

        $this->loadView("ControlAsistenciaMultiple", "formularios/control_asistencia/control_asistencia_multiple", $data);
    }
    public function faltasEmpleados()
    {
        $data = array(
            'contratos' => $this->Contrato_model->obtenerContratosOrdenApellidos(),
        );

        $this->loadView("FaltasEmpleados", "formularios/control_asistencia/falta_form", $data);
    }
    public function obtenerAsistencias()
    {
        $asistencias = $this->Control_asistencia_model->obtenerAsistencias();
        echo json_encode($asistencias);
    }
    public function obtenerFaltas()
    {
        $asistencias = $this->Control_asistencia_model->obtenerFaltas();
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
        $fecha = date('Y-m-d', strtotime($fecha_hora_ingreso));
        $calendario = $this->Calendario_model->obtenerFeriadoFecha($fecha);
        (isset($calendario)) ? $feriado = '1' : $feriado = '0';
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
                        'feriado' => $feriado,
                        'observaciones' => $observaciones,
                        'ultima_edicion' => $ultima_edicion,
                        'falta' => '0',

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
    public function ingresar_asistencia_multiple()
    {
        $id_contrato = $this->input->post('id_contrato');
        $id_usuario = $this->session->userdata('id_usuario');
        $fecha_hora_ingreso = $this->input->post('fecha_hora_ingreso');
        $fecha_hora_salida = $this->input->post('fecha_hora_salida');
        $observaciones = $this->input->post('observaciones');
        $ultima_edicion = date('Y-m-d H:i:s');
        try {
            if (isset($id_contrato)) {
                for ($i = 0; $i < count($id_contrato); $i++) {
                    $fecha = date('Y-m-d', strtotime($fecha_hora_ingreso[$i]));
                    $calendario = $this->Calendario_model->obtenerFeriadoFecha($fecha);
                    (isset($calendario)) ? $feriado = '1' : $feriado = '0';
                    $datos = array(
                        'id_contrato' => $id_contrato[$i],
                        'id_usuario' => $id_usuario,
                        'fecha_hora_ingreso' => $fecha_hora_ingreso[$i],
                        'fecha_hora_salida' => $fecha_hora_salida[$i],
                        'feriado' => $feriado,
                        'observaciones' => $observaciones[$i],
                        'ultima_edicion' => $ultima_edicion,
                        'falta' => '0',
                    );
                    $this->Control_asistencia_model->ingresarControl($datos);
                }
                $respuesta = array(
                    'respuesta' => 'Exitoso',
                    'mensaje' => 'Se guardo correctamente',
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema, no llego ninguna dato',
                );
            }
        } catch (Exception $th) {
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
            );
        }

        echo json_encode($respuesta);
    }
    public function ingresarFalta()
    {
        $this->form_validation->set_rules('id_contrato', 'id_contrato', 'trim|xss_clean|required');
        $this->form_validation->set_rules('fecha_falta', 'fecha_falta', 'trim|xss_clean');
        $this->form_validation->set_rules('observaciones', 'observaciones', 'trim|xss_clean');

        $id_contrato = $this->input->post('id_contrato');
        $id_usuario = $this->session->userdata('id_usuario');
        $fecha_falta = $this->input->post('fecha_falta');
        $observaciones = $this->input->post('observaciones');
        $ultima_edicion = date('Y-m-d H:i:s');
        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos',
                );
            } else {

                $datos = array(
                    'id_contrato' => $id_contrato,
                    'id_usuario' => $id_usuario,
                    'fecha_falta' => $fecha_falta,
                    'observaciones' => $observaciones,
                    'ultima_edicion' => $ultima_edicion,
                    'falta' => '1',
                );
                $id_control_asistencia = $this->Control_asistencia_model->ingresarControl($datos);
                $asistencia = $this->Control_asistencia_model->obtenerAsistencia($id_control_asistencia);
                $respuesta = array(
                    'respuesta' => 'Exitoso',
                    'datos' => $asistencia,
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
    public function editarFalta()
    {
        $this->form_validation->set_rules('id_contrato', 'id_contrato', 'trim|xss_clean|required');
        $this->form_validation->set_rules('fecha_falta', 'fecha_falta', 'trim|xss_clean');
        $this->form_validation->set_rules('observaciones', 'observaciones', 'trim|xss_clean');

        $id_control_asistencia = $this->input->post('id_control_asistencia');
        $id_contrato = $this->input->post('id_contrato');
        $id_usuario = $this->session->userdata('id_usuario');
        $fecha_falta = $this->input->post('fecha_falta');
        $observaciones = $this->input->post('observaciones');
        $ultima_edicion = date('Y-m-d H:i:s');
        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos',
                );
            } else {

                $datos = array(
                    'id_contrato' => $id_contrato,
                    'id_usuario' => $id_usuario,
                    'fecha_falta' => $fecha_falta,
                    'observaciones' => $observaciones,
                    'ultima_edicion' => $ultima_edicion,
                    'falta' => '1',
                );
                $this->Control_asistencia_model->editarControl($id_control_asistencia, $datos);
                $asistencia = $this->Control_asistencia_model->obtenerAsistencia($id_control_asistencia);
                $respuesta = array(
                    'respuesta' => 'Exitoso',
                    'datos' => $asistencia,
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
    public function editar_asistencia()
    {
        $this->form_validation->set_rules('id_contrato', 'id_contrato', 'trim|xss_clean|required');
        $this->form_validation->set_rules('fecha_hora_ingreso', 'fecha_hora_ingreso', 'trim|xss_clean');
        $this->form_validation->set_rules('fecha_hora_salida', 'fecha_hora_salida', 'trim|xss_clean');
        $this->form_validation->set_rules('observaciones', 'observaciones', 'trim|xss_clean');


        $id_control_asistencia = $this->input->post('id_control_asistencia');
        $id_contrato = $this->input->post('id_contrato');
        $id_usuario = $this->session->userdata('id_usuario');
        $fecha_hora_ingreso = $this->input->post('fecha_hora_ingreso');
        $fecha_hora_salida = $this->input->post('fecha_hora_salida');
        $observaciones = $this->input->post('observaciones');
        $ultima_edicion = date('Y-m-d H:i:s');

        $fecha_hora_ingreso = str_replace('T', ' ', $fecha_hora_ingreso);
        $fecha_hora_salida = str_replace('T', ' ', $fecha_hora_salida);

        $fecha = date('Y-m-d', strtotime($fecha_hora_ingreso));
        $calendario = $this->Calendario_model->obtenerFeriadoFecha($fecha);
        (isset($calendario)) ? $feriado = '1' : $feriado = '0';


        $fecha_hora_ingreso = date('Y-m-d H:i', strtotime($fecha_hora_ingreso));
        $fecha_hora_salida = date('Y-m-d H:i', strtotime($fecha_hora_salida));


        $asistencia = $this->Control_asistencia_model->obtenerAsistencia($id_control_asistencia);

        $fecha_actual_ingreso = date('Y-m-d H:i', strtotime($asistencia['fecha_hora_ingreso']));
        $fecha_actual_salida = date('Y-m-d H:i', strtotime($asistencia['fecha_hora_salida']));

        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos',
                );
            } else {
                if ($asistencia['id_contrato'] == $id_contrato && $fecha_actual_ingreso <= $fecha_hora_ingreso && $fecha_actual_salida >= $fecha_hora_salida) {
                    $datos = array(
                        'id_contrato' => $id_contrato,
                        'id_usuario' => $id_usuario,
                        'fecha_hora_ingreso' => $fecha_hora_ingreso,
                        'fecha_hora_salida' => $fecha_hora_salida,
                        'feriado' => $feriado,
                        'observaciones' => $observaciones,
                        'ultima_edicion' => $ultima_edicion,
                    );
                    $this->Control_asistencia_model->editarControl($id_control_asistencia, $datos);
                    $asistencia = $this->Control_asistencia_model->obtenerAsistencia($id_control_asistencia);
                    $respuesta = array(
                        'respuesta' => 'Exitoso',
                        'datos' => $asistencia,
                        'message' => 'Se edito correctamente',
                    );
                } elseif ($asistencia['id_contrato'] != $id_contrato) {
                    $existeAsistenciaEntreTiempo = $this->Control_asistencia_model->existeAsistenciaEntreTiempo($id_contrato, $fecha_hora_ingreso, $fecha_hora_salida);
                    if ($existeAsistenciaEntreTiempo['respuesta'] == false) {
                        $datos = array(
                            'id_contrato' => $id_contrato,
                            'id_usuario' => $id_usuario,
                            'fecha_hora_ingreso' => $fecha_hora_ingreso,
                            'fecha_hora_salida' => $fecha_hora_salida,
                            'feriado' => $feriado,
                            'observaciones' => $observaciones,
                            'ultima_edicion' => $ultima_edicion,
                        );
                        $this->Control_asistencia_model->editarControl($id_control_asistencia, $datos);
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
                } else {
                    $existeAsistenciaEntreTiempo = $this->Control_asistencia_model->existeAsistenciaEntreTiempoExceptoId($id_control_asistencia, $id_contrato, $fecha_hora_ingreso, $fecha_hora_salida);
                    if ($existeAsistenciaEntreTiempo['respuesta'] == false) {
                        $datos = array(
                            'id_contrato' => $id_contrato,
                            'id_usuario' => $id_usuario,
                            'fecha_hora_ingreso' => $fecha_hora_ingreso,
                            'fecha_hora_salida' => $fecha_hora_salida,
                            'feriado' => $feriado,
                            'observaciones' => $observaciones,
                            'ultima_edicion' => $ultima_edicion,
                        );
                        $this->Control_asistencia_model->editarControl($id_control_asistencia, $datos);
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
            }
        } catch (Exception  $th) {
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
            );
        }
        echo json_encode($respuesta);
    }
    public function eliminar($id_control_asistencia)
    {
        $this->Control_asistencia_model->eliminar($id_control_asistencia);
        $respuesta = array(
            'respuesta' => 'Exitoso',
            'message' => 'Se elimino la asistencia'
        );
        echo json_encode($respuesta);
    }
}
