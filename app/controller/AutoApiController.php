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
        $order = 'ASC'; // Valor predeterminado de orden ascendente
    
        // Verificar si se especifica orden descendente
        if (isset($_GET['direccion']) && strtolower($_GET['direccion']) === 'desc') {
            $order = 'DESC';
        }
    
        // Verificar filtros
        if (isset($_GET['id_auto'])) {
            $id_auto = $_GET['id_auto'];
            $vehicle = $this->model->get($id_auto);
            $this->view->response($vehicle, 200);

        } elseif (isset($_GET['marca'])) {
            $marca = $_GET['marca'];
            $vehicles = $this->model->getAllByMarca($marca, $order);
            $this->view->response($vehicles, 200);

        } elseif (isset($_GET['precio'])) {
            $precio = $_GET['precio'];
            $vehicles = $this->model->getAllByPrecio($precio, $order);
            $this->view->response($vehicles, 200);

        } elseif (isset($_GET['anio'])) {
            $anio = $_GET['anio'];
            $vehicles = $this->model->getAllByAnio($anio, $order);
            $this->view->response($vehicles, 200);

        } elseif (isset($_GET['modelo'])) {
            $modelo = $_GET['modelo'];
            $vehicles = $this->model->getAllByModelo($modelo, $order);
            $this->view->response($vehicles, 200);

        } elseif (isset($_GET['color'])) {
            $color = $_GET['color'];
            $vehicles = $this->model->getAllByColor($color, $order);
            $this->view->response($vehicles, 200);

        } else {
            // Si no se especifica ningún parámetro, obtener todos los vehículos con el orden especificado
            $vehicles = $this->model->getAll($order);
            if ($vehicles) {
                $this->view->response($vehicles, 200);
            } else {
                $this->view->response("NO HAY VEHICULOS EN LA BASE DE DATOS.", 404);
            }
        }
    }
    

    // traemos un auto por ID
    public function getAuto($params = null) {
        $id = $params[':ID'];
        try {
            // Obtiene un auto del modelo
            $vehicle = $this->model->get($id);
            // Si existe el vehiculo, la retorna con un código 200 (éxito)
            if($vehicle){
                $response = [
                "status" => 200,
                "message" => $vehicle
               ];
                $this->view->response($response, 200);

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

    //AGREGAR AUTO A LA BASE DE DATOS  
    public function addAuto() {
        $autoNuevo = $this->getData();
    
        $lastId = $this->model->insertar(
            $autoNuevo->modelo, 
            $autoNuevo->anio, 
            $autoNuevo->precio,
            $autoNuevo->color, 
            $autoNuevo->id_marca 
        );
        if ($lastId) {
            $this->view->response("Se insertó  el vehiculo correctamente con id: $lastId", 201);
        } else {
            $this->view->response("Error al insertar el registro", 500);
        }
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

            $this->view->response("auto $vehicle, vendido", 201);
        } else {
            $this->view->response("auto $id, no encontrado", 400);
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

                $modelo = $inputData->modelo ?? $vehicle->modelo;
                $precio = $inputData->precio ?? $vehicle->precio;
                $color = $inputData->color ?? $vehicle->color;
                $vendido = $inputData->vendido ?? $vehicle->vendido;
                $anio = $inputData->anio ?? $vehicle->anio;
                
                // Actualizar el vehículo en la base de datos
                $this->model->edit($id, $modelo, $anio, $precio, $color, $vendido);
                $this->view->response("Vehículo actualizado correctamente con id: $id", 201);
                
            } else {
                $this->view->response("Vehículo no encontrado", 400);
            }
        } catch (\Throwable $th) {
            // Manejo de errores
            $this->view->response("Error al actualizar el vehículo: " . $th->getMessage(), 500);
        }
    }
}    