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

    //traemos todos los autos
    public function getAll() {
        try {
            // Obtener todos los autos del modelo
            $vehicles = $this->model->getAll();
            if ($vehicles) {
                $response = [
                    "status" => 200,
                    "data" => $vehicles
                ];
                // Si hay autos, devolverlas con un código 200 (éxito)
                $this->view->response($response, 200);
            } else {
                // Si no hay autos, devolver un mensaje con un código 404
                $this->view->response("No hay autos en la base de datos", 404);
            }
        } catch (Exception) {
            $this->view->response("Error de servidor", 500);
        }
    }
    

// traemos un auto por ID
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

 //Agregar AUTO   
 public function addAuto() {
    $autoNuevo = $this->getData();
    $lastId = $this->model->insertar(
            $autoNuevo->modelo, 
            $autoNuevo->anio, 
            $autoNuevo->precio,
            $autoNuevo->color, 
            $autoNuevo->vendido);

    $this->view->response("Se insertó correctamente con id: $lastId", 200);

}

//borrar auto
public function borrarAuto($params = null) {
        $id = $params[':ID'];
        
        $vehicle = $this->model->get($id);
        if ($vehicle) {
            $this->model->delete($id);

            $this->view->response("vehiculo $id, eliminado", 200);
        } else {
            $this->view->response("vehiculo $id, no encontrado", 404);
        }
    }

    //marcar como vendido un auto 
    public function autoVendido($params = null) {
        $id = $params[':ID'];
        $vehicle = $this->model->get($id);
        if ($vehicle) {
            $vendido = $vehicle->vendido;
            $this->model->vendido($id);

            $this->view->response("auto $vehicle, vendido", 200);
        } else {
            $this->view->response("auto $id, no encontrado", 404);
        }
    }    

    //traemos todos los vehiculos de una marca (lo hacemos por ID)
    public function getAllxMarca($params = null){
        $id = $params[':ID'];
        $vehicles= $this->model->getAllByMarca($id);
        try {
            if($vehicles){
                $response = [
                    "status" => 200,
                    "data" => $vehicles
                ];
                $this->view->response($vehicles, 200);
       
            }else
                $this->view->response("No hay autos en la base de datos", 404);
        
           
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
            }
    }

// Editar un vehiculo
public function editarVehiculo($params = NULL){
    $id = $params[':ID'];
    $vehicle = $this->model->get($id);

    try {
        if ($vehicle) {
            // Obtén los datos enviados en la solicitud
            $inputData = json_decode(file_get_contents("php://input"));

            // Asignar los datos del vehículo desde la solicitud
            $modelo = $inputData->modelo ?? $vehicle->modelo;
            $anio = $inputData->anio ?? $vehicle->anio;
            $precio = $inputData->precio ?? $vehicle->precio;
            $color = $inputData->color ?? $vehicle->color;
            $vendido = $inputData->vendido ?? $vehicle->vendido;

            // Actualizar el vehículo en la base de datos
            $this->model->edit($id, $modelo, $anio, $precio, $color, $vendido);

            $this->view->response("Vehículo actualizado correctamente con id: $id", 200);
        } else {
            $this->view->response("Vehículo no encontrado", 404);
        }
    } catch (\Throwable $th) {
        // Manejo de errores
        $this->view->response("Error al actualizar el vehículo: " . $th->getMessage(), 500);
    }
}





}    