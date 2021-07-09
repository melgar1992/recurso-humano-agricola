<?php 
class Empleado_model extends CI_Model
{
    public function obtenerEmpleados()
    {
        $this->db->select('*');
        $this->db->from('empleados');
        $this->db->order_by('apellidos');
        $this->db->where('Estado','1');
        return $this->db->get()->result_array();
    }

    public function ingresarEmpleado($ci, $nombres, $apellidos, $telefono, $direccion)
    {
        $datos = array(
            'ci' => $ci,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'estado' => '1',
        );
        $this->db->insert('empleados', $datos);
        return $this->db->insert_id();
    }
    public function obtenerEmpleadoId($id_empleado)
    {
        $this->db->select('*');
        $this->db->where('id_empleado', $id_empleado);
        return $this->db->get('empleados')->row_array();
    }
    
}
