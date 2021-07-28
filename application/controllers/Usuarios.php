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
            'Usuarios' => $this->Usuario_model->getUsuarios(),
        );
        $this->loadView('Usuarios', '/forms/formularios/usuarios/list', $data);
    }

    public function guardarUsuario()
    {
        $nombres = $this->input->post('nombre');
        $apellidos = $this->input->post('apellidos');
        $ci = $this->input->post('ci');
        $telefono = $this->input->post('telefono');
        $nombre_usuario = $this->input->post('nombre_usuario');
        $contrasena = $this->input->post('contrasena');
        $fecha_ingreso = $this->input->post('fecha_ingreso');
        $roles = $this->input->post('roles');

        $this->form_validation->set_rules("nombre", "Nombre", "required");
        $this->form_validation->set_rules("apellidos", "Apellidos", "required");
        $this->form_validation->set_rules(
            'ci',
            'ci',
            array(
                'required',
                array('validarCi', array($this->Usuario_model, 'validarCi'))
            ),
            array('validarCi' => 'Carnet de identidad ya esta siendo ocupado')
        );
        $this->form_validation->set_rules("telefono", "telefono", "required");
        $this->form_validation->set_rules("nombre_usuario", "nombre_usuario", "required|is_unique[usuarios.username]");
        $this->form_validation->set_rules("contrasena', 'contrasena', 'trim|required");
        $this->form_validation->set_rules("fecha_ingreso", "fecha_ingreso", "required");
        $this->form_validation->set_rules('roles', 'roles', 'trim|required');


        if ($this->form_validation->run()) {
            $datosUsuario = array(
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'carnet_identidad' => $ci,
                'telefono' => $telefono,
                'username' => $nombre_usuario,
                'password' => $this->encryption->encrypt($contrasena),
                'fecha_ingreso' => $fecha_ingreso,
                'estado' => '1',
            );
            if ($this->Usuario_model->guardarUsuario($datosUsuario, $roles)) {
                redirect(base_url() . 'Formularios/Usuarios');
            } else {
                $this->session->set_flashdata("error", "No se pudo guardar los datos del usuario");
            }
        } else {
            $this->index();
        }
    }

    public function editar($id_usuario)
    {
        $data = array(
            'usuario' => $this->Usuario_model->getUsuario($id_usuario),
        );

        $this->loadView('Usuarios', '/forms/formularios/usuarios/editar', $data);
    }

    public function actualizarUsuario()
    {
        $id_usuarios = $this->input->post('id_usuarios');
        $nombres = $this->input->post('nombre');
        $apellidos = $this->input->post('apellidos');
        $ci = $this->input->post('ci');
        $telefono = $this->input->post('telefono');
        $nombre_usuario = $this->input->post('nombre_usuario');
        $contrasena = $this->input->post('contrasena');
        $fecha_ingreso = $this->input->post('fecha_ingreso');
        $roles = $this->input->post('roles');

        $usuario_actual = $this->Usuario_model->getUsuario($id_usuarios);

        $this->form_validation->set_rules("nombre", "Nombre", "required");
        $this->form_validation->set_rules("apellidos", "Apellidos", "required");
        if ($ci == $usuario_actual->carnet_identidad) {
        } else {
            $this->form_validation->set_rules(
                'ci',
                'ci',
                array(
                    'required',
                    array('validarCi', array($this->Usuario_model, 'validarCi'))
                ),
                array('validarCi' => 'Carnet de identidad ya esta siendo ocupado')
            );
        }
        if ($nombre_usuario == $usuario_actual->username) {
        } else {
            $this->form_validation->set_rules("nombre_usuario", "nombre_usuario", "required|is_unique[usuarios.username]");
        }


        $this->form_validation->set_rules("telefono", "telefono", "required");
        $this->form_validation->set_rules("fecha_ingreso", "fecha_ingreso", "required");
        $this->form_validation->set_rules('roles', 'roles', 'trim|required');

        if ($this->form_validation->run()) {
            $datos = array(
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'carnet_identidad' => $ci,
                'telefono' => $telefono,
                'username' => $nombre_usuario,
                'fecha_ingreso' => $fecha_ingreso,
                'estado' => '1',
            );
            if ($contrasena != '') {
                $datos['password'] = $this->encryption->encrypt($contrasena);
            }
            if ($this->Usuario_model->actualizar($id_usuarios, $roles, $datos)) {
                redirect(base_url() . "Formularios/Usuarios");
            } else {
                $this->session->set_flashdata("error", "No se pudo actualizar la informacion");
                redirect(base_url() . "forms/formularios/usuarios/editar" . $id_usuarios);
            }
        } else {
            $this->editar($id_usuarios);
        }
    }
    public function borrar($id_usuarios)
    {
        $datos = array(
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