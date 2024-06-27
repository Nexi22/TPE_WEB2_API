<?php
require_once "app/model/model.php";

class VehicleModel extends model{

    function getAll($order = 'ASC') {
        $db = $this->createConexion();
        $orderSql = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $consulta = $db->prepare("SELECT * FROM auto ORDER BY id_auto $orderSql");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function get($id){
        $db = $this->createConexion();
        $sentencia = $db->prepare("SELECT * FROM auto WHERE id_auto = ?");
        $sentencia->execute([$id]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    function getAllByModelo($modelo, $order = 'ASC') {
        $db = $this->createConexion();
        $orderSql = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $sentencia = $db->prepare("SELECT * FROM auto WHERE modelo = ? ORDER BY id_auto $orderSql");
        $sentencia->execute([$modelo]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }
    
    function getAllByAnio($anio, $order = 'ASC') {
        $db = $this->createConexion();
        $orderSql = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $sentencia = $db->prepare("SELECT * FROM auto WHERE anio = ? ORDER BY id_auto $orderSql");
        $sentencia->execute([$anio]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    function getAllByPrecio($precio, $order = 'ASC') {
        $db = $this->createConexion();
        $orderSql = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $sentencia = $db->prepare("SELECT * FROM auto WHERE precio = ? ORDER BY id_auto $orderSql");
        $sentencia->execute([$precio]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }
    
    function getAllByColor($color, $order = 'ASC') {
        $db = $this->createConexion();
        $orderSql = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $sentencia = $db->prepare("SELECT * FROM auto WHERE color = ? ORDER BY id_auto $orderSql");
        $sentencia->execute([$color]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    function getAllByMarca($marca, $order = 'ASC') {
        $db = $this->createConexion();
        $orderSql = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $sentencia = $db->prepare("SELECT * FROM auto WHERE marca = ? ORDER BY id_auto $orderSql");
        $sentencia->execute([$marca]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
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

    //Vehiculo vendido
    function vendido($id){ 
        $db = $this->createConexion();
        $resultado= $db->prepare("UPDATE auto SET vendido = ? WHERE id_auto = ?");
        $resultado->execute([1,$id]); // ejecuta
    }   


    // Editar un vehiculo
    function edit($id, $modelo, $anio, $precio, $color, $vendido) {
        $db = $this->createConexion();
        $resultado = $db->prepare("UPDATE auto SET modelo = ?, anio = ?, precio = ?, color = ?, vendido = ?  WHERE id_auto = ?");
        $resultado->execute([$modelo, $anio, $precio, $color, $vendido, $id]);
    }

 
}
