<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pago_empleados extends BaseController
{

    public function pago_empleado()
    {
  
      $data = array();
  
      $this->loadView("Pago_empleado", "formularios/pago_empleado/pago_empleado_form", $data);
    }
}