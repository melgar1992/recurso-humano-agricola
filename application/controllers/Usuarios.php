<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends BaseController
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $data = array(
            'roles' => $this->Usuario_model->obtenerRoles(),
        );
        $this->loadView('Usuarios', 'formularios/usuario/usuario_form', $data);
    }
    public function obtenerUsuariosAjax()
    {
        $usuarios = $this->Usuario_model->getUsuarios();
        echo json_encode($usuarios);
    }
    public function ingresarUsuario()
    {
        $id_roles = $this->input->post('id_roles');
        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');
        $ci = $this->input->post('ci');
        $telefono = $this->input->post('telefono');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $telefono = $this->input->post('telefono');

        $this->form_validation->set_rules("nombres", "nombres", "required");
        $this->form_validation->set_rules("apellidos", "apellidos", "required");
        $this->form_validation->set_rules("ci", "ci", "required");
        $this->form_validation->set_rules("telefono", "telefono", "required");
        $this->form_validation->set_rules("username", "username", "required|is_unique[usuarios.username]");
        $this->form_validation->set_rules("password', 'password', 'required");
        $this->form_validation->set_rules('id_roles', 'id_roles', 'required');

        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos',
                );
            } else {
                $datosUsuario = array(
                    'id_roles' => $id_roles,
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'ci' => $ci,
                    'telefono' => $telefono,
                    'username' => $username,
                    'password' => $this->encryption->encrypt($password),
                    'fecha_ingreso' => date('Y-m-d'),
                    'estado' => '1',
                );
                $id_usuario = $this->Usuario_model->guardarUsuario($datosUsuario);
                $usuario = $this->Usuario_model->getUsuario($id_usuario);
                $respuesta = array(
                    'respuesta' => 'Exitoso',
                    'datos' => $usuario,
                    'mensaje' => 'Se guardo correctamente',
                );
            }
        } catch (Exception  $th) {
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
            );
        }
        echo json_encode($respuesta);
    }

    public function obtenerUsuario()
    {
        $id_usuario = $this->input->post('id_usuario');
        $usuario = $this->Usuario_model->getUsuario($id_usuario);
        echo json_encode($usuario);
    }

    public function actualizarUsuario()
    {
        $id_usuario = $this->input->post('id_usuario');
        $id_roles = $this->input->post('id_roles');
        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');
        $ci = $this->input->post('ci');
        $telefono = $this->input->post('telefono');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $telefono = $this->input->post('telefono');

        $usuario_actual = $this->Usuario_model->getUsuario($id_usuario);

        if ($username == $usuario_actual['username']) {
            $is_uniqueUsername = '';
        } else {
            $is_uniqueUsername = '|is_unique[usuarios.username]';
        }

        $this->form_validation->set_rules("nombres", "nombres", "required");
        $this->form_validation->set_rules("apellidos", "apellidos", "required");
        $this->form_validation->set_rules("ci", "ci", "required");
        $this->form_validation->set_rules("telefono", "telefono", "required");
        $this->form_validation->set_rules("username", "username", "required" . $is_uniqueUsername);
        $this->form_validation->set_rules("password', 'password', 'required");
        $this->form_validation->set_rules('id_roles', 'id_roles', 'required');
        try {
            if ($this->form_validation->run()) {
                $datos = array(
                    'id_roles' => $id_roles,
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'ci' => $ci,
                    'telefono' => $telefono,
                    'username' => $username,
                    'estado' => '1',
                );
                if ($password != '') {
                    $datos['password'] = $this->encryption->encrypt($password);
                }
                if ($this->Usuario_model->actualizar($id_usuario, $datos)) {
                    $usuario = $this->Usuario_model->getUsuario($id_usuario);
                    $respuesta = array(
                        'respuesta' => 'Exitoso',
                        'datos' => $usuario,
                        'mensaje' => 'Se guardo correctamente',
                    );
                } else {
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos o el nombre del usuario ya existe!',
                );
            }
        } catch (Exception  $th) {
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
            );
        }
        echo json_encode($respuesta);
    }
    public function borrar($id_usuarios)
    {
        $datos = array(
            'username' => '',
            'estado' => '0',
            'fecha_salida' => date('Y-m-d'),
        );
        $this->Usuario_model->borrar($id_usuarios, $datos);
        echo 'Formularios/Usuarios';
    }

    // Roles de usuarios

    public function Roles()
    {
        $data = array(
            'nombreRoles' => $this->Usuario_model->obtenerNombresDeColumnasRoles(),
        );
        $this->loadView('Roles', 'formularios/roles/roles_form', $data);
    }
    public function obtenerRolesAjax()
    {
        $roles = $this->Usuario_model->obtenerRoles();
        echo json_encode($roles);
    }
    public function obtenerRolAjax()
    {
        $id_roles = $this->input->post('id_roles');
        $rol = $this->Usuario_model->obtenerRol($id_roles);
        echo json_encode($rol);
    }
    public function guardarRol()
    {
        $nombre = $this->input->post('nombre');
        $descripcion = $this->input->post('descripcion');
        $dashboard = $this->input->post('dashboard');
        $empleados = $this->input->post('empleados');
        $calendario = $this->input->post('calendario');
        $asistencias = $this->input->post('asistencias');
        $pago = $this->input->post('pago');
        $usuarios = $this->input->post('usuarios');


        $this->form_validation->set_rules('nombre', 'nombre', 'trim|xss_clean|required|is_unique[roles.nombre]');
        $this->form_validation->set_rules('descripcion', 'descripcion', 'trim|xss_clean|required');



        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos o nombre del roll ya existe!',
                );
            } else {
                $id_roles = $this->Usuario_model->ingresarRoll($nombre, $descripcion, $dashboard, $empleados, $calendario, $asistencias, $pago, $usuarios);
                $rol = $this->Usuario_model->obtenerRol($id_roles);
                $respuesta = array(
                    'respuesta' => 'Exitoso',
                    'datos' => $rol,
                    'message' => 'Se guardo correctamente',
                );
            }
        } catch (Exception  $th) {
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
            );
        }
        echo json_encode($respuesta);
    }
    public function editarRol()
    {
        $id_roles = $this->input->post('id_roles');
        $nombre = $this->input->post('nombre');
        $descripcion = $this->input->post('descripcion');
        $dashboard = $this->input->post('dashboard');
        $empleados = $this->input->post('empleados');
        $calendario = $this->input->post('calendario');
        $asistencias = $this->input->post('asistencias');
        $pago = $this->input->post('pago');
        $usuarios = $this->input->post('usuarios');

        $rol = $this->Usuario_model->obtenerRol($id_roles);
        if ($nombre == $rol['nombre']) {
            $is_unique = '';
        } else {
            $is_unique = '|is_unique[roles.nombre]';
        }
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|xss_clean|required' . $is_unique);
        $this->form_validation->set_rules('descripcion', 'descripcion', 'trim|xss_clean|required');
        try {
            if ($this->form_validation->run() === false) {
                $respuesta = array(
                    'respuesta' => 'Error',
                    'mensaje' => 'Ocurrio un problema al validar los datos o el nombre ya existe',
                );
            } else {
                $this->Usuario_model->editarRol($id_roles, $nombre, $descripcion, $dashboard, $empleados, $calendario, $asistencias, $pago, $usuarios);
                $rol = $this->Usuario_model->obtenerRol($id_roles);
                $respuesta = array(
                    'respuesta' => 'Exitoso',
                    'datos' => $rol,
                    'message' => 'Se edito correctamente',
                );
            }
        } catch (Exception  $th) {
            $respuesta = array(
                'respuesta' => 'Error',
                'mensaje' => 'Ocurrio un problema' + $th->getMessage(),
            );
        }
        echo json_encode($respuesta);
    }
    public function eliminarRol($id_roles)
    {
        $this->Usuario_model->eliminarRol($id_roles);
        $respuesta = array(
            'respuesta' => 'Exitoso',
            'message' => 'Se elimino al empleado'
        );
        echo json_encode($respuesta);
    }
}
