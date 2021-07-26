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
        $data = array(
        );
        $this->loadView("CalendarioFeriado", "formularios/calendario/calendarioFeriado", $data);
    }
    public function obtenerFeriadosAjax()
    {
        $feriados = $this->Calendario_model->obtenerFeriados();
        echo json_encode($feriados);
    }
}
