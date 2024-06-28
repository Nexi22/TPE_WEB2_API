<?php
require_once('app/model/UserModel.php');
require_once('app/view/JSONView.php');

class UserApiController {
    private $model;
    private $view;
    private $data;

    public function __construct(){
        $this->model = new UserModel();
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
    }

    public function getData(){
        return json_decode($this->data);
    }

        //Traemos todos los usuarios
        public function getAll() {
            $order = 'ASC'; // Valor predeterminado de orden ascendente
        
            // Verificar si se especifica orden descendente
            if (isset($_GET['direccion']) && strtolower($_GET['direccion']) === 'desc') {
                $order = 'DESC';
            }
            // Verificar filtros
            if (isset($_GET['id'])) {
                $id_usuario = $_GET['id'];
                $usuario = $this->model->get($id_usuario);
                $this->view->response($usuario, 200);
    
            } elseif (isset($_GET['email'])) {
                $email = $_GET['email'];
                $usuario = $this->model->getByEmail($email);
                $this->view->response($usuario, 200);
    
            } elseif (isset($_GET['rol'])) {
                $rol = $_GET['rol'];
                $usuarios = $this->model->getAllByRol($rol, $order);
                $this->view->response($usuarios, 200);
            } else {
                // Si no se especifica ningún parámetro, obtener todos los usuarios con el orden especificado
                $usuarios = $this->model->getAll($order);
                if ($usuarios) {
                    $this->view->response($usuarios, 200);
                } else {
                    $this->view->response("NO HAY USUARIOS EN LA BASE DE DATOS.", 404);
                }
            }
        }

    public function getUsuario($params = null) {
        $id = $params[':ID'];
        try {
            $usuario = $this->model->get($id);
            if($usuario){
                $response = [
                "status" => 200,
                "message" => $usuario
                ];
                $this->view->response($response, 200);
            }
            else{
                $response = [
                    "status" => 404,
                    "message" => "No existe el usuario en  la base de datos."
                ];
                $this->view->response($response, 404);
    
            }
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
        }
    
    }  

    public function newUser() {
        $UsuarioNuevo = $this->getData();
    
        $lastId = $this->model->addUser(
            $UsuarioNuevo->email, 
            $UsuarioNuevo->password, 
            $UsuarioNuevo->rol,
        );
        if ($lastId) {
            $this->view->response("Se insertó correctamente el usuario con el id: $lastId", 201);
        } else {
            $this->view->response("Error al insertar el usuario", 500);
        }
    }

    //Borrar Usuario
    public function deleteUser($params = null) {
        $id = $params[':ID'];
    
        $usuario = $this->model->get($id);
        if ($usuario) {
            $this->model->delete($id);

            $this->view->response("usuario $id, eliminado", 200);
        } else {
            $this->view->response("usuario $id, no encontrado", 404);
        }
    }
}
