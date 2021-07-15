<?php
class Contrato_model extends CI_Model
{

    public function obtenerContratos()
    {
        $this->db->select('co.*, concat(em.nombres," " ,em.apellidos) as nombre_completo, em.nombres as empleado_nombres, em.apellidos as empleado_apellidos, em.ci, em.telefono, em.direccion, 
        ca.nombre as cargo_nombre, ca.tipo_pago, ca.sueldo_mensual, ca.sueldo_hora, ca.hora_extra, ca.hora_feriada');
        $this->db->from('contrato co');
        $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
        $this->db->join('cargo ca', 'ca.id_cargo = co.id_cargo');
        $this->db->where('co.estado', '1');
        $this->db->where('ca.estado', '1');
        $this->db->where('em.estado', '1');
        return $this->db->get()->result_array();
    }
    public function obtenerContratosOrdenApellidos()
    {
        $this->db->select('co.*, concat(em.apellidos," " ,em.nombres) as nombre_completo, em.nombres as empleado_nombres, em.apellidos as empleado_apellidos, em.ci, em.telefono, em.direccion, 
        ca.nombre as cargo_nombre, ca.tipo_pago, ca.sueldo_mensual, ca.sueldo_hora, ca.hora_extra, ca.hora_feriada');
        $this->db->from('contrato co');
        $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
        $this->db->join('cargo ca', 'ca.id_cargo = co.id_cargo');
        $this->db->where('co.estado', '1');
        $this->db->where('ca.estado', '1');
        $this->db->where('em.estado', '1');
        $this->db->order_by('nombre_completo');
        return $this->db->get()->result_array();
    }
    public function obtenerContrato($id_contrato)
    {
        $this->db->select('co.*, concat(em.nombres," " ,em.apellidos) as nombre_completo, em.nombres as empleado_nombres, em.apellidos as empleado_apellidos, em.ci, em.telefono, em.direccion, 
        ca.nombre as cargo_nombre, ca.tipo_pago, ca.sueldo_mensual, ca.sueldo_hora, ca.hora_extra, ca.hora_feriada');
        $this->db->from('contrato co');
        $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
        $this->db->join('cargo ca', 'ca.id_cargo = co.id_cargo');
        $this->db->where('co.id_contrato', $id_contrato);
        return $this->db->get()->row_array();
    }
    public function existeContrato($id_empleado, $id_cargo)
    {
        $this->db->select('id_contrato');
        $this->db->where('id_empleado', $id_empleado);
        $this->db->where('id_cargo', $id_cargo);
        $this->db->where('co.estado', '1');
        $this->db->where('ca.estado', '1');
        $this->db->where('em.estado', '1');
        $contrato = $this->db->get('contrato')->row_array();

        if (isset($contrato)) {
            return true;
        } else {
            return false;
        }
    }
    public function ingresarContrato($id_empleado, $id_cargo)
    {
        $datos = array(
            'id_empleado' => $id_empleado,
            'id_cargo' => $id_cargo,
            'estado' => '1',
        );
        $this->db->insert('contrato', $datos);
        return $this->db->insert_id();
    }
    public function editarContrato($id_contrato, $id_empleado, $id_cargo)
    {
        $datos = array(
            'id_empleado' => $id_empleado,
            'id_cargo' => $id_cargo,
        );
        $this->db->where('id_contrato', $id_contrato);
        $this->db->update('contrato', $datos);
    }
    public function eliminarContrato($id_contrato)
    {
        $datos = array(
            'estado' => '0',
        );
        $this->db->where('id_contrato', $id_contrato);
        $this->db->update('contrato', $datos);
    }
}
