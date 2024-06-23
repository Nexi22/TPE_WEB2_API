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
                // Obtener todos los usuarios del modelo
                $users = $this->model->getAll();
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

        //Traemos todos los usuarios
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


       //borrar Marca
    public function deleteUser($params = null) {
        $id = $params[':ID'];
    
        $usuario = $this->model->get($id);
        if ($usuario) {
            $this->model->delete($id);

            $this->view->response("usuario $id, eliminada", 200);
        } else {
            $this->view->response("usuario $id, no encontrada", 404);
        }
    }
    }
