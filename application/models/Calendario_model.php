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

}