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
                    'mensaje' => 'Ocurrio un problema al validar los datos',
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
}
