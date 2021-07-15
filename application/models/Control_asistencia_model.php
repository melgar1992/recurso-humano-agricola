<?php
class Control_asistencia_model extends CI_Model
{

    public function obtenerAsistencias()
    {
        $this->db->select('coa.*, concat(em.apellidos," " ,em.nombres) as nombre_completo, em.nombres as empleado_nombres, em.apellidos as empleado_apellidos, em.ci, em.telefono, em.direccion, 
        ca.nombre as cargo_nombre, ca.tipo_pago, ca.sueldo_mensual, ca.sueldo_hora, ca.hora_extra, ca.hora_feriada');
        $this->db->from('control_asistencia coa');
        $this->db->join('contrato co', 'co.id_contrato = coa.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
        $this->db->join('cargo ca', 'ca.id_cargo = co.id_cargo');
        return $this->db->get()->result_array();
    }
}
