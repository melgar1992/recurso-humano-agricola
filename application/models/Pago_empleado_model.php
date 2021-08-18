<?php
class Pago_empleado_model extends CI_Model
{
    public function obtenerPagosEmpleados()
    {
        $this->db->select('pe.*, concat(em.nombres," " ,em.apellidos) as nombre_completo, em.nombres as empleado_nombres, em.apellidos as empleado_apellidos, em.ci, em.telefono, em.direccion,
        ca.nombre as cargo_nombre, ca.tipo_pago, ca.sueldo_mensual, ca.sueldo_hora, ca.hora_extra, ca.hora_feriada');
        $this->db->from('pagos_empleados pe');
        $this->db->join('contrato c', 'c.id_contrato = pe.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado = c.id_empleado');
        $this->db->join('cargo ca', 'ca.id_cargo = c.id_cargo');
        $this->db->where('haber >', 0);
        $this->db->limit(200);

        return $this->db->get()->result_array();
    }
    public function obtenerPagoEmpleado($id_pagos_empleados)
    {
        $this->db->select('pe.*, concat(em.nombres," " ,em.apellidos) as nombre_completo, em.nombres as empleado_nombres, em.apellidos as empleado_apellidos, em.ci, em.telefono, em.direccion,
        ca.nombre as cargo_nombre, ca.tipo_pago, ca.sueldo_mensual, ca.sueldo_hora, ca.hora_extra, ca.hora_feriada');
        $this->db->from('pagos_empleados pe');
        $this->db->join('contrato c', 'c.id_contrato = pe.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado = c.id_empleado');
        $this->db->join('cargo ca', 'ca.id_cargo = c.id_cargo');
        $this->db->where('id_pagos_empleados ', $id_pagos_empleados);
        return $this->db->get()->row_array();
    }
    public function ingresarPagoEmpleado($datos)
    {
        $this->db->insert('pagos_empleados', $datos);
        return $this->db->insert_id();
    }
    public function editarPagoEmpleado($id_pagos_empleados, $datos)
    {
        $this->db->where('id_pagos_empleados', $id_pagos_empleados);
        $this->db->update('pagos_empleados', $datos);
    }
    public function eliminarPago($id_pagos_empleados)
    {
        $this->db->where('id_pagos_empleados', $id_pagos_empleados);
        $this->db->delete('pagos_empleados');
    }
}
