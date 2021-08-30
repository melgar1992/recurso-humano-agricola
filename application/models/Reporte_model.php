<?php
class Reporte_model extends CI_Model
{
    public function obtenerIngresosContratoEntreFecha($id_contrato, $fechaIni, $fechaFin)
    {
        $this->db->select('sum(horaNormal) as horaNormal,
        sum(horaExtras) as horaExtras,
        sum(horaFeriado) as horaFeriado,
        sum(porPagarFeriado) as TotalHoraFeriado, 
        sum(porPagarNormal) as TotalHoraNormal, 
        sum(porPagarHoraExtra) as TotalHoraExtra,
        (sum(porPagarFeriado) + sum(porPagarNormal)  + sum(porPagarHoraExtra)) as totalGanado');
        $this->db->from('tabla_asistencia_ingresos');
        $this->db->where('id_contrato', $id_contrato);
        $this->db->where('fecha_hora_ingreso >=', $fechaIni);
        $this->db->where('fecha_hora_ingreso <=', $fechaFin);
        return $this->db->get()->row_array();

    }
    public function obtenerIngresosDirectoEntreFecha($id_contrato, $fechaIni, $fechaFin)
    {
        $this->db->select('pe.*, concat(em.nombres," " ,em.apellidos) as nombre_completo, em.nombres as empleado_nombres, em.apellidos as empleado_apellidos, em.ci, em.telefono, em.direccion,
        ca.nombre as cargo_nombre, ca.tipo_pago, ca.sueldo_mensual, ca.sueldo_hora, ca.hora_extra, ca.hora_feriada');
        $this->db->from('pagos_empleados pe');
        $this->db->join('contrato c', 'c.id_contrato = pe.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado = c.id_empleado');
        $this->db->join('cargo ca', 'ca.id_cargo = c.id_cargo');
        $this->db->where('pe.id_contrato', $id_contrato);
        $this->db->where('debe !=', 'null');
        $this->db->where('fecha >=', $fechaIni);
        $this->db->where('fecha <=', $fechaFin);

        return $this->db->get()->result_array();
    }
    public function obtenerpagosEntreFecha($id_contrato, $fechaIni, $fechaFin)
    {
        $this->db->select('pe.*, concat(em.nombres," " ,em.apellidos) as nombre_completo, em.nombres as empleado_nombres, em.apellidos as empleado_apellidos, em.ci, em.telefono, em.direccion,
        ca.nombre as cargo_nombre, ca.tipo_pago, ca.sueldo_mensual, ca.sueldo_hora, ca.hora_extra, ca.hora_feriada');
        $this->db->from('pagos_empleados pe');
        $this->db->join('contrato c', 'c.id_contrato = pe.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado = c.id_empleado');
        $this->db->join('cargo ca', 'ca.id_cargo = c.id_cargo');
        $this->db->where('pe.id_contrato', $id_contrato);
        $this->db->where('haber !=', 'null');
        $this->db->where('fecha >=', $fechaIni);
        $this->db->where('fecha <=', $fechaFin);

        return $this->db->get()->result_array();
    }
}