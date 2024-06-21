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

        public function deleteUser($id) {
            try {
                //Obtengo un usuario por ID
                $usuario = $this->model->GetUser($id);
                if ($usuario) {
                    $response = [
                        "status" => 200,
                        "data" =>$usuario
                    ];
                    //Si se obtiene un usuario, devolver un 200
                    $this->view->response($response, 200);
                }else{
                    //Si no se obtuvo ningun usuario, devolver un 404
                    $this->view->response("No hay usuarios en la base de datos", 404);
                }
            } catch (Exception) {
                $this->view->response("Error del servidor", 500);
            }
        }

    }
