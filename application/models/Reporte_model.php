<?php
class Reporte_model extends CI_Model
{
    public function obtenerAnosTrabajo()
    {
        $this->db->select('year(fecha) as year');
        $this->db->from('jornada_dia');
        $this->db->group_by('year');   
        return $this->db->get()->result_array();
    }
    public function obtenerIngresosContratoEntreFecha($id_contrato, $fechaIni, $fechaFin)
    {
        $this->db->select('sum(horaNormal) as horaNormal,
        sum(horaExtras) as horaExtras,
        sum(horaFeriado) as horaFeriado,
        sum(porPagarFeriado) as TotalHoraFeriado, 
        sum(porPagarNormal) as TotalHoraNormal, 
        sum(porPagarHoraExtra) as TotalHoraExtra,
        (sum(porPagarFeriado) + sum(porPagarNormal)  + sum(porPagarHoraExtra)) as totalGanado');
        $this->db->from('jornada_dia');
        $this->db->where('id_contrato', $id_contrato);
        $this->db->where('fecha >=', $fechaIni);
        $this->db->where('fecha <=', $fechaFin);
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
    public function obtenerBalanceDelMesEmpleados()
    {
        $fechaIni = date('Y-01-01');
        $fechaFin = date('Y-m-t');

        $this->db->select('sum(hora_jornada) as hora_jornada,
        sum(horaExtras) as horaExtras,
        sum(horaFeriado) as horaFeriado,
        sum(porPagarFeriado) as TotalHoraFeriado, 
        sum(porPagarNormal) as TotalHoraNormal, 
        sum(porPagarHoraExtra) as TotalHoraExtra,
        (sum(porPagarFeriado) + sum(porPagarNormal)  + sum(porPagarHoraExtra)) as totalGanado');
        $this->db->from('jornada_dia');
        $this->db->where('fecha >=', $fechaIni);
        $this->db->where('fecha <=', $fechaFin);
        return $this->db->get()->row_array();
    }
    public function obtenerSumaHoraTrabajadasMes($year)
    {
        $horaTrabajadas = array(
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
        );

        $this->db->select('sum(hora_jornada) as hora_trabajadas, month(fecha) as mes');
        $this->db->from('jornada_dia');
        $this->db->where('fecha >=', $year . '-01-01');
        $this->db->where('fecha <=',$year . '-12-31');
        $this->db->group_by('mes');


        $datos = $this->db->get()->result_array();

        foreach ($datos as $dato ) {
            $horaTrabajadas[(int) $dato['mes'] - 1] = (float) $dato['hora_trabajadas'];
            
        }
        return $horaTrabajadas;
    }
    public function obtenerHorasEmpleadosPorMes()
    {
        $fechaIni = date('Y-01-01');
        $fechaFin = date('Y-m-t');
        // $fechaIni = date('Y-m-t', mktime(0, 0, 0, date("m"),   date("d"),   date("Y") - 1));

        $this->db->select('nombre_completo, ci, sum(hora_jornada) as hora_trabajadas, monthname(fecha) as mes, month(fecha) as mesNumero');
        $this->db->from('jornada_dia');
        $this->db->where('fecha >=', $fechaIni);
        $this->db->where('fecha <=', $fechaFin);
        $this->db->group_by('nombre_completo');
        $this->db->group_by('ci');
        $this->db->group_by('mes');
        $this->db->group_by('mesNumero');
        $this->db->order_by('mesNumero', 'DESC');

        return $this->db->get()->result_array();
    }
    public function obtenerAsistenciaEntreFecha($id_contrato, $fechaIni, $fechaFin)
    {
        $this->db->select('*');
        $this->db->from('jornada_dia');
        $this->db->where('id_contrato', $id_contrato);
        $this->db->where('fecha >=', $fechaIni);
        $this->db->where('fecha <=', $fechaFin);
        $this->db->order_by('fecha','ASC');

        return $this->db->get()->result_array();

    }
}
