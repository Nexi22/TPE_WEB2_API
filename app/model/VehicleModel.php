<?php
require_once "app/model/model.php";

class VehicleModel extends model{

    function getAll($atribute = null, $order = null) {
        $db = $this->createConexion();
        if($atribute){
            $sql = "SELECT * FROM auto ORDER BY $atribute $order";
        }else{
            $sql = "SELECT * FROM auto";
        }
        $consulta = $db->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function get($id){
        $db = $this->createConexion();
        $sentencia = $db->prepare("SELECT * FROM auto WHERE id_auto = ?");
        $sentencia->execute([$id]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    //Agregar AUTO   
    function insertar($modelo, $anio, $precio, $color, $vendido, $id) {
        $db = $this->createConexion();
        $consulta = $db->prepare("INSERT INTO auto (modelo, anio, precio, color, vendido, id_marca) VALUES (?, ?, ?, ?, ?, ?)");
        $consulta->execute([$modelo, $anio, $precio, $color, $vendido, $id]);
        // Retornar el ID del último  insertado
        return $db->lastInsertId();
    }

    //Borrar un vehiculo
    function delete($id){
        $db = $this->createConexion();
        $resultado= $db->prepare("DELETE FROM auto WHERE id_auto = ?");
        $resultado->execute([$id]); // ejecuta
    }  

    // Editar un vehiculo
    function edit($id, $modelo, $anio, $precio, $color, $vendido) {
        $db = $this->createConexion();
        $resultado = $db->prepare("UPDATE auto SET modelo = ?, anio = ?, precio = ?, color = ?, vendido = ?  WHERE id_auto = ?");
        $resultado->execute([$modelo, $anio, $precio, $color, $vendido, $id]);
    }
}
