<?php
require_once('app/model/VehicleModel.php');
require_once('app/view/JSONView.php');

class AutoApiController {

    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new VehicleModel();
        $this->view = new JSONView();

        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getAll() {

        try {
            // Obtener todos los autos del modelo
            $vehicles = $this->model->getAll();
            if($vehicles){
                $response = [
                "status" => 200,
                "data" => $vehicles
               ];
                $this->view->response($vehicles, 200);
            //    $this->view->response($tareas, 200);

            }
                 // Si hay autos, devolverlas con un código 200 (éxito)
            else
                // Si no hay autos, devolver un mensaje con un código 404 (no encontrado)
                 $this->view->response("No hay autos en la base de datos", 404);
        } catch (Exception $e) {
            // En caso de error del servidor, devolver un mensaje con un código 500 (error del servidor)
            $this->view->response("Error de servidor", 500);
        }
    }


    public function getAuto($params = null) {
        $id = $params[':ID'];

        try {
            // Obtiene un auto del modelo
            $vehicle = $this->model->get($id);
            // Si existe la tarea, la retorna con un código 200 (éxito)
            if($vehicle){
                $response = [
                "status" => 200,
                "message" => $vehicle
               ];
                $this->view->response($response, 200);
            //    $this->view->response($tareas, 200);

            }
            else{
                $response = [
                    "status" => 404,
                    "message" => "No existe el auto en la base de datos."
                ];
                $this->view->response($response, 404);

            }
        } catch (Exception $e) {
            // En caso de error del servidor, devolver un mensaje con un código 500 (error del servidor)
            $this->view->response("Error de servidor", 500);
        }

    }  

    




}    