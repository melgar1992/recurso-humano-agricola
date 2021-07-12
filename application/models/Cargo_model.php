<?php
class Cargo_model extends CI_Model
{

    public function obtenerCargos()
    {
        $this->db->select('*');
        $this->db->where('estado', '1');
        return $this->db->get('cargo')->result_array();
    }
    public function obetenerCargoId($id_cargo)
    {
        $this->db->select('*');
        $this->db->where('id_cargo', $id_cargo);
        return $this->db->get('cargo')->row_array();
    }
    public function ingresarCargo($nombre, $tipo_pago, $sueldo_mensual, $sueldo_hora, $hora_extra, $hora_feriada)
    {
        $datos = array(
            'nombre' => $nombre,
            'tipo_pago' => $tipo_pago,
            'sueldo_mensual' => $sueldo_mensual,
            'sueldo_hora' => $sueldo_hora,
            'hora_extra' => $hora_extra,
            'hora_feriada' => $hora_feriada,
            'estado' => '1',
        );
        $this->db->insert('cargo', $datos);
        return $this->db->insert_id();
    }
    public function editarCargo($id_cargo, $nombre, $tipo_pago, $sueldo_mensual, $sueldo_hora, $hora_extra, $hora_feriada)
    {
        $datos = array(
            'nombre' => $nombre,
            'tipo_pago' => $tipo_pago,
            'sueldo_mensual' => $sueldo_mensual,
            'sueldo_hora' => $sueldo_hora,
            'hora_extra' => $hora_extra,
            'hora_feriada' => $hora_feriada,
        );
        $this->db->where('id_cargo', $id_cargo);
        $this->db->update('cargo', $datos);
    }
}
