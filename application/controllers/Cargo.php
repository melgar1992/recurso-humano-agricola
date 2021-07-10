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

        $this->loadView('Cargo','formularios/cargo/cargo_form', $data);
    }
}
