<?php
require_once('app/model/MarcaModel.php');
require_once('app/view/JSONView.php');

class MarcaApiController {

    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new marcaModel();
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    //traemos todas las marcas    
    public function getAll() {    
        if (isset($_GET['atribute']) && isset($_GET['order'])) {
            $marcas = $this->model->getAll($_GET['atribute'], $_GET['order']);
            
        }else{
            $marcas = $this->model->getAll();  
        }
        if($marcas){
            $this->view->response($marcas, 200);
        }else{
            $this->view->response("No hay vehiculos en la base de datos", 404);
        }
    }
    
    // traemos una marca por ID
    public function getMarca($params = null) {
        $id = $params[':ID'];
        try {
            $marca = $this->model->get($id);
            if($marca){
                $response = [
                "status" => 200,
                "message" => $marca
               ];
                $this->view->response($response, 200);

            }
            else{
                $response = [
                    "status" => 404,
                    "message" => "No existe la marca en la base de datos."
                ];
                $this->view->response($response, 404);

            }
        } catch (Exception $e) {
            // En caso de error del servidor, devolver un mensaje con un código 500 (error del servidor)
            $this->view->response("Error de servidor", 500);
        }

    }  

    public function addMarca() {
        try {
            // Obtener los datos enviados para la nueva marca
            $marcaNueva = $this->getData();
    
            // Obtener los datos específicos de la nueva marca
            $nombre = $marcaNueva->nombre;
            $pais_de_origen = $marcaNueva->pais_de_origen;
            $ano_de_fundacion = $marcaNueva->ano_de_fundacion;
            $descripcion = $marcaNueva->descripcion;
    
            // Insertar la nueva marca en la base de datos y obtener el último ID insertado
            $lastId = $this->model->insertar($nombre, $pais_de_origen, $ano_de_fundacion, $descripcion);
    
            // Responder con un mensaje de éxito y el ID de la marca insertada
            $this->view->response("Se insertó correctamente con id: $lastId", 200);
    
        } catch (Exception $e) {
            // Manejo de errores en caso de excepción
            $this->view->response("Error al insertar la marca: " . $e->getMessage(), 404);
        }
    }
    

    //Borrar Marca
    public function borrarMarca($params = null) {
        $id = $params[':ID'];
    
        $marca = $this->model->get($id);
        if ($marca) {
            $this->model->delete($id);

            $this->view->response("marca $id, eliminada", 200);
        } else {
            $this->view->response("marca $id, no encontrada", 404);
        }
    }

    //Editar Marca
    public function editarMarca($params = NULL) {
        $id = $params[':ID'];
        $editMarca = $this->getData();
        $marca = $this->model->get($id);

        try {
            if ($marca) {
                $nombre = $editMarca->nombre;
                $pais_de_origen = $editMarca->pais_de_origen; 
                $ano_de_fundacion = $editMarca->ano_de_fundacion;
                $descripcion = $editMarca->descripcion;

                $this->model->edit($nombre, $pais_de_origen, $ano_de_fundacion, $descripcion, $id);

                // Responder con un mensaje de éxito
                $this->view->response("Marca actualizada correctamente", 200);
            } else {
                // Responder con un mensaje de error si la marca no existe
                $this->view->response("No se encontró la marca", 404);
            }
        }   catch (Exception $e) {
            $this->view->response("Error de conexión: " . $e->getMessage(), 500);
        }
    }
}   