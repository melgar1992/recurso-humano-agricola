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
        $this->db->limit(200);
        return $this->db->get()->result_array();
    }
    public function obtenerAsistencia($id_control_asistencia)
    {
        $this->db->select('coa.*, concat(em.apellidos," " ,em.nombres) as nombre_completo, em.nombres as empleado_nombres, em.apellidos as empleado_apellidos, em.ci, em.telefono, em.direccion, 
        ca.nombre as cargo_nombre, ca.tipo_pago, ca.sueldo_mensual, ca.sueldo_hora, ca.hora_extra, ca.hora_feriada');
        $this->db->from('control_asistencia coa');
        $this->db->join('contrato co', 'co.id_contrato = coa.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
        $this->db->join('cargo ca', 'ca.id_cargo = co.id_cargo');
        $this->db->where('coa.id_control_asistencia', $id_control_asistencia);
        return $this->db->get()->row_array()();
    }
    public function existeAsistenciaEntreTiempo($id_contrato, $fecha_hora_ingreso, $fecha_hora_salida)
    {

        $this->db->select('*');
        $this->db->from('control_asistencia');
        $this->db->where('id_contrato', $id_contrato);
        $this->db->where("fecha_hora_ingreso BETWEEN $fecha_hora_ingreso AND $fecha_hora_salida", NULL, FALSE);
        $this->db->or_where("fecha_hora_salida BETWEEN $fecha_hora_ingreso AND $fecha_hora_salida", NULL, FALSE);
        $resultadoEntreHora = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('control_asistencia');
        $this->db->where('id_contrato', $id_contrato);
        $this->db->where("fecha_hora_ingreso <=", $fecha_hora_ingreso);
        $this->db->where("fecha_hora_salida >=", $fecha_hora_salida);
        $resultadoDentroHora = $this->db->get()->result_array();

        if (isset($resultadoEntreHora) || isset($resultadoDentroHora)) {
            $respuesta = array(
                'respuesta' => true,
                'mensaje' => 'El Contrato del empleado sigue trabajando entre los tiempos!!'
            );
            return $respuesta;
        } else {
            $respuesta = array(
                'respuesta' => false,
                'mensaje' => ''
            );
            return $respuesta;
        }
    }
}
