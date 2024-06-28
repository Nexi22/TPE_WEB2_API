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
        if (isset($_GET['atribute']) && isset($_GET['order'])) {
                $user = $this->model->getAll($_GET['atribute'], $_GET['order']);
                
            }else{
                $user = $this->model->getAll();  
            }
            if($user){
                $this->view->response($user, 200);
            }else{
                $this->view->response("No hay vehiculos en la base de datos", 404);
            }
        }

    public function getUsuario($params = null) {
        $id = $params[':ID'];
        try {
            $usuario = $this->model->get($id);
            if($usuario){
                $response = [
                "status" => 200,
                "usuario" => $usuario
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
            $this->view->response("Error del servidor", 500);
        }
    
    }  

    public function newUser() {
        $UsuarioNuevo = $this->getData();
        $hashedPassword = password_hash($UsuarioNuevo->password, PASSWORD_DEFAULT);
    
        $lastId = $this->model->addUser(
            $UsuarioNuevo->email, 
            $hashedPassword, 
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
