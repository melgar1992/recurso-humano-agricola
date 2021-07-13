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
        $data = array();

        $this->loadView("Contrato", "formularios/contrato/contrato_form", $data);
    }
}
