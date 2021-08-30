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
        sum(porPagarHoraExtra) as TotalHoraExtra');
        $this->db->from('tabla_asistencia_ingresos');
        $this->db->where('id_contrato', $id_contrato);
        $this->db->where('fecha_hora_ingreso >=', $fechaIni);
        $this->db->where('fecha_hora_ingreso <=', $fechaFin);
        return $this->db->get()->result_array();

    }
}