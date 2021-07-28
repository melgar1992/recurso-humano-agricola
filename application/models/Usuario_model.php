<?php
class Usuario_model extends CI_Model
{

    public function login($username, $password)
    {
        $this->db->select('usuarios.*, roles.*');
        $this->db->where("username", $username);
        // $this->db->where("password", $password);
        $this->db->where("estado", "1");
        $this->db->join('roles', 'roles.id_roles = usuarios.id_roles');


        $resultado = $this->db->get("usuarios");
        $res2 = $resultado->row();
        if ($resultado->num_rows() > 0 && $this->encryption->decrypt($res2->password) == $password) {
            return  $resultado->row();
        } else {
            return false;
        }
    }
    public function getUsuarios()
    {
        $this->db->select('u.*, concat(u.apellidos," " ,u.nombres) as nombre_completo, r.*');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'r.id_roles = u.id_roles');
        $this->db->where('u.estado', '1');
        $this->db->where('r.estado', '1');
        return $this->db->get()->result_array();
    }
    public function validarCi($ci)
    {
        $this->db->select('u.estado, u.carnet_identidad');
        $this->db->from('usuarios u');
        $this->db->where('u.carnet_identidad', $ci);
        $this->db->where('u.estado', '1');

        $resultado = $this->db->get();

        $row = $resultado->row();

        if (isset($row)) {
            return false;
        } else {
            return true;
        }
    }
    public function guardarUsuario($datosUsuario, $rol)
    {
        $this->db->where('nombre', $rol);
        $resultado = $this->db->get('roles')->row();

        $datosUsuario['id_roles'] = $resultado->id_roles;

        return $this->db->insert('usuarios', $datosUsuario);
    }
    public function getUsuario($id_usuario)
    {
        $this->db->select('u.*, r.nombre as tiporol');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'r.id_roles = u.id_roles');
        $this->db->where('u.estado', '1');
        $this->db->where('u.id_usuarios', $id_usuario);
        $resultado = $this->db->get()->row();

        if (isset($resultado)) {
            return $resultado;
        } else {
            return false;
        }
    }
    public function actualizar($id_usuarios, $rol, $datos)
    {
        $this->db->where('nombre', $rol);
        $rol = $this->db->get('roles')->row();
        $datos['id_roles'] = $rol->id_roles;

        $this->db->where('id_usuarios', $id_usuarios);
        return $this->db->update('usuarios', $datos);
    }
    public function borrar($id_usuarios, $datos)
    {
        $this->db->where('id_usuarios', $id_usuarios);
        return $this->db->update('usuarios', $datos);
    }

    // Funciones de Roles

    public function obtenerRoles()
    {
        $this->db->select('*');
        $this->db->from('roles ');
        $this->db->where('estado', '1');
        return $this->db->get()->result_array();
    }
    public function obtenerNombresDeColumnasRoles()
    {
        return $this->db->list_fields('roles');
    }
    public function obtenerRol($id_roles)
    {
        $this->db->select('*');
        $this->db->from('roles ');
        $this->db->where('id_roles', $id_roles);
        return $this->db->get()->row_array();
    }
    public function ingresarRoll($nombre, $descripcion, $dashboard, $empleados, $calendario, $asistencias, $pago, $usuarios)
    {
        $data = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'dashboard' => $dashboard,
            'empleados' => $empleados,
            'calendario' => $calendario,
            'asistencias' => $asistencias,
            'usuarios' => $usuarios,
            'pago' => $pago,
            'estado' => '1',
        );
        $this->db->insert('roles', $data);
        return $this->db->insert_id();
    }
    public function editarRol($id_roles, $nombre, $descripcion, $dashboard, $empleados, $calendario, $asistencias, $pago, $usuarios)
    {
        $data = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'dashboard' => $dashboard,
            'empleados' => $empleados,
            'calendario' => $calendario,
            'asistencias' => $asistencias,
            'usuarios' => $usuarios,
            'pago' => $pago,
        );
        $this->db->where('id_roles', $id_roles);
        $this->db->update('roles', $data);
    }
    public function eliminarRol($id_roles)
    {
        $data = array(
            'estado' => '0',
            'nombre' => '',
        );
        $this->db->where('id_roles', $id_roles);
        $this->db->update('roles', $data);
    }
}
