<?php
require_once('app/model/VehicleModel.php');
require_once('app/view/JSONView.php');
require_once('app/model/marcaModel.php');

class AutoApiController {

    private $model;
    private $view;
    private $modelMarca;
    private $data;

    public function __construct() {
        $this->model = new VehicleModel();
        $this->view = new JSONView();
        $this->modelMarca = new marcaModel();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getAll() {    
        if (isset($_GET['atribute']) && isset($_GET['order'])) {
            $vehicles = $this->model->getAll($_GET['atribute'], $_GET['order']);
        }else{
            $vehicles = $this->model->getAll();  
        }
        if($vehicles){
            $this->view->response($vehicles, 200);
        }else{
            $this->view->response("No hay vehiculos en la base de datos", 404);
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

       $marca= $this->modelMarca->get($autoNuevo->id_marca);
        if($marca){

            $lastId = $this->model->insertar(
                $autoNuevo->modelo, 
                $autoNuevo->anio, 
                $autoNuevo->precio,
                $autoNuevo->color, 
                $autoNuevo->vendido,
                $autoNuevo->id_marca 
            );
            if ($lastId) {
                $this->view->response("Se insertó  el vehiculo correctamente con id: $lastId", 201);
            } else {
                $this->view->response("Error al insertar el vehiculo", 404);
            }
        }else{
            $this->view->response("No se puede agregar un vehiculo sin una marca existente", 404);
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

    // Editar un vehiculo
    public function editarVehiculo($params = NULL){
        $id = $params[':ID'];
        $editAuto = $this->getData();
        $marca= $this->modelMarca->get($editAuto->id_marca);
        $vehiculo = $this->model->get($id);
        
        try {
            if($vehiculo){
                if($marca){
                    $modelo = $editAuto->modelo;
                    $anio = $editAuto->anio;
                    $precio = $editAuto->precio;
                    $color = $editAuto->color;
                    $vendido = $editAuto->vendido;
                            
                    // Actualizar el vehículo en la base de datos
                    $this->model->edit($id, $modelo, $anio, $precio, $color, $vendido);
                    $this->view->response("Vehículo actualizado correctamente con id: $id", 201);
                }else{
                    $this->view->response("No existe la marca con id $editAuto->id_marca en la base de datos", 404);
                }
            }else{
                $this->view->response("No existe el vehiculo en la base de datos", 404);

            }
        }catch (\Throwable $th) {
            // Manejo de errores
            $this->view->response("Error de conexión: " . $th->getMessage(), 500);
        }
    } 


}    