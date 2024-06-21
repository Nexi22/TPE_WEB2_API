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
    public function getAll(){
        try {
            // Obtener todos los autos del modelo
            $marcas = $this->model->getAll();
            if($marcas){
                $response = [
                "status" => 200,
                "data" => $marcas
               ];
                $this->view->response($marcas, 200);
          
            }
                
            else
                 $this->view->response("No hay marcas en la base de datos", 404);
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
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
                    "message" => "No existe la marcaen la base de datos."
                ];
                $this->view->response($response, 404);

            }
        } catch (Exception $e) {
            // En caso de error del servidor, devolver un mensaje con un código 500 (error del servidor)
            $this->view->response("Error de servidor", 500);
        }

    }  

    //Agregar Marca   
 public function addMarca() {
    $MarcaNueva = $this->getData();
    $lastId = $this->model->insertar(
            $MarcaNueva->nombre, 
            $MarcaNueva->pais_de_origen, 
            $MarcaNueva->$ano_de_fundacion,
            $MarcaNueva->descripcion);

    $this->view->response("Se insertó correctamente con id: $lastId", 200);

}

//borrar Marca
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

    //editar marca
    public function editarMarca($params = NULL){
        $id = $params[':ID'];
        $marca=$this->model->get($id);
        try {
            if($marca){
                $lastId = $this->model->edit(
                    $marca->nombre, 
                    $marca->pais_de_origen, 
                    $marca->ano_de_fundacion,
                    $marca->descripcion);
            }
        } catch (\Throwable $th) {
       
        }

    }


}   