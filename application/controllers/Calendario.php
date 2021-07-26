<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendario extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }


    public function calendarioFeriadoForm()
    {
        $data = array();
        $this->loadView("CalendarioFeriado", "formularios/calendario/calendarioFeriado", $data);
    }
    public function obtenerFeriadosAjax()
    {
        $feriados = $this->Calendario_model->obtenerFeriados();
        echo json_encode($feriados);
    }
    public function obtenerFeriadoAjax()
    {
        $id_calendario = $this->input->post('id_calendario');;
        $feriado = $this->Calendario_model->obtenerFeriadosId($id_calendario);
        echo json_encode($feriado);
    }
    public function ingresarFeriado()
    {
        $feriado = $this->input->post('feriado');
        $nombre = $this->input->post('nombre');

        $this->form_validation->set_rules('feriado', 'feriado', 'trim|xss_clean|required|is_unique[calendario.feriado]');
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|xss_clean|required');
        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos o la fecha ya existe',
                );
            } else {
                $id_calendario = $this->Calendario_model->ingresarFeriado($feriado, $nombre);
                $feriado = $this->Calendario_model->obtenerFeriadosId($id_calendario);
                $respuesta = array(
                    'respuesta' => 'Exitoso',
                    'datos' => $feriado,
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
    public function editarFeriado()
    {
        $id_calendario = $this->input->post('id_calendario');
        $feriado = $this->input->post('feriado');
        $nombre = $this->input->post('nombre');
        $calendarioFeriado = $this->Calendario_model->obtenerFeriadosId($id_calendario);
        if ($feriado == $calendarioFeriado['feriado']) {
            $is_unique = '';
        } else {
            $is_unique = '|is_unique[calendario.feriado]';
        }
        $this->form_validation->set_rules('feriado', 'feriado', 'trim|xss_clean|required' . $is_unique);
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|xss_clean|required');
        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos o la fecha ya existe',
                );
            } else {
                $this->Calendario_model->editarFeriado($id_calendario, $feriado, $nombre);
                $calendarioFeriado = $this->Calendario_model->obtenerFeriadosId($id_calendario);
                $respuesta = array(
                    'respuesta' => 'Exitoso',
                    'datos' => $calendarioFeriado,
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
}
