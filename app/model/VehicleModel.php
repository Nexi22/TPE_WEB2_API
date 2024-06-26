<?php
require_once "app/model/model.php";

class VehicleModel extends model{

        // Método para obtener los vehiculos paginados
    public function getPaginated($offset, $limit) {
        // Crear la conexión y preparar la consulta con LIMIT y OFFSET
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM auto LIMIT :limit OFFSET :offset");
        $consulta->bindParam(':limit', $limit, PDO::PARAM_INT);
        $consulta->bindParam(':offset', $offset, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }
    
    // Método para contar el número total de autos
    public function countAll() {
        // Crear la conexión y preparar la consulta para contar registros
        $db = $this->createConexion();
        $consulta = $db->query("SELECT COUNT(*) as total FROM auto");
        return $consulta->fetch(PDO::FETCH_OBJ)->total;
    }

    //traemos todos los autos
    function getAll($orderBy, $orderDir){
        //CREO LA CONEXION Y ENVIO LA CONSULTA A LA DB
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM auto ORDER BY $orderBy $orderDir");
        $consulta->execute();
        $vehicles = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $vehicles;
    }

    // traemos un auto por ID
    function get($id){
        //abrimos la conexion;
        $db = $this->createConexion();
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM auto WHERE id_auto = ?");
        $sentencia->execute([$id]);
        $vehicle = $sentencia->fetch(PDO::FETCH_OBJ);
        return $vehicle;
    }
    

    //Agregar AUTO   
    function insertar($modelo, $anio, $precio, $color, $id) {
        try {
            $db = $this->createConexion();
            $consulta = $db->prepare("INSERT INTO auto (modelo, anio, precio, color, vendido, id_marca) VALUES (?, ?, ?, ?, ?, ?)");
            $consulta->execute([$modelo, $anio, $precio, $color, 0, $id]);
    
            // Retornar el ID del último  insertado
            return $db->lastInsertId();
        } catch (PDOException $e) {
            // Manejo de excepciones
            error_log("Error en la inserción: " . $e->getMessage());
            return false;
        }
    }
    

    //Borrar un vehiculo
    function delete($id){
        $db = $this->createConexion();
         $resultado= $db->prepare("DELETE FROM auto WHERE id_auto = ?");
        $resultado->execute([$id]); // ejecuta
     }

     //vehiculo vendido
     function vendido($id){ 
        $db = $this->createConexion();
        $resultado= $db->prepare("UPDATE auto SET vendido = ? WHERE id_auto = ?");
        $resultado->execute([1,$id]); // ejecuta
    }   

    //traemos todos los vehiculos por marca
    function getAllByMarca($id){
        //abrimos la conexion;
        $db = $this->createConexion();
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM auto WHERE id_marca = ?");
        $sentencia->execute([$id]);
        $vehicles = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $vehicles;
    }
    


    // editar un vehiculo
    function edit($id, $modelo, $anio, $precio, $color, $vendido) {
        $db = $this->createConexion();
        $resultado = $db->prepare("UPDATE auto SET modelo = ?, anio = ?, precio = ?, color = ?, vendido = ?  WHERE id_auto = ?");
        $resultado->execute([$modelo, $anio, $precio, $color, $vendido, $id]);
    }

 
}
