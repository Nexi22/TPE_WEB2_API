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
        try {
            // Obtener parámetros de paginación de la solicitud
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $pageSize = isset($_GET['pageSize']) ? (int)$_GET['pageSize'] : 10;

            // Calcular el desplazamiento (offset) para la consulta SQL
            $offset = ($page - 1) * $pageSize;

            // Obtener los usuarios paginados del modelo
            $users = $this->model->getPaginated($offset, $pageSize);

            // Obtener el número total de usuarios para calcular el total de páginas
            $totalUsers = $this->model->countAll();
            $totalPages = ceil($totalUsers / $pageSize);

            if ($users) {
                $response = [
                    "status" => 200,
                    "data" => $users,
                    "totalUsers" => $totalUsers,
                    "totalPages" => $totalPages,
                    "currentPage" => $page,
                    "pageSize" => $pageSize
                ];
                $this->view->response($response, 200);
            } else {
                $this->view->response("No hay usuarios en la base de datos", 404);
            }
        } catch (Exception $e) {
            $this->view->response("Error de servidor: " . $e->getMessage(), 500);
        }
    }

    //Traemos todos los usuarios de forma ascendente
    public function getAllASC() {
        try {
            // Obtener todos los usuarios del modelo
            $users = $this->model->getAllASC();
            if ($users) {
                $response = [
                    "status" => 200,
                    "data" => $users
                ];
                // Si hay usuarios, devolverlos con un código 200 (éxito)
                $this->view->response($response, 200);
            } else {
                // Si no hay usuarios, devolver un mensaje con un código 404
                $this->view->response("No hay usuarios en la base de datos", 404);
            }
        } catch (Exception) {
            $this->view->response("Error de servidor", 500);
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
