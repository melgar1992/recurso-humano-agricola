<?php
class Calendario_model extends CI_Model
{

    public function obtenerFeriados()
    {
        $this->db->select('*');
        return $this->db->get('calendario')->result_array();
    }
    public function obtenerFeriadosId($id_calendario)
    {
        $this->db->select('*');
        $this->db->where('id_calendario', $id_calendario);
        return $this->db->get('calendario')->row_array();
    }
    public function obtenerFeriadoFecha($fecha)
    {
        $this->db->select('*');
        $this->db->where('feriado', $fecha);
        return $this->db->get('calendario')->row_array();
    }
    public function ingresarFeriado($feriado, $nombre)
    {
        $datos = array(
            'feriado' => $feriado,
            'nombre' => $nombre,
        );
        $this->db->insert('calendario', $datos);
        return $this->db->insert_id();
    }
    public function editarFeriado($id_calendario, $feriado, $nombre)
    {
        $datos = array(
            'feriado' => $feriado,
            'nombre' => $nombre,
        );
        $this->db->where('id_calendario', $id_calendario);
        $this->db->update('calendario', $datos);
    }
    public function eliminarFeriado($id_calendario)
    {
        $this->db->where('id_calendario', $id_calendario);
        $this->db->delete('calendario');
    }
}
