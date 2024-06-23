<?php
require_once "app/model/model.php";

class VehicleModel extends model{

       //traemos todos los autos
    function getAll(){
        //CREO LA CONEXION Y ENVIO LA CONSULTA A LA DB
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM auto");
        $consulta->execute();
        $vehicles = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $vehicles;
    }

    function getAllDESC(){
        //CREO LA CONEXION Y ENVIO LA CONSULTA A LA DB
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM auto ORDER BY id_auto DESC");
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
    function insertar($modelo, $anio, $precio, $color, $id){
            $db = $this->createConexion();
            $consulta = $db->prepare("INSERT INTO auto (modelo, anio, precio, color, vendido, id_marca) VALUES (?, ?, ?, ?, ?, ?)");
            $consulta->execute([$modelo, $anio, $precio, $color, 0, $id]);
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
    


    // editamos 
     
    function edit($modelo, $anio, $precio, $color, $id) {
        $db = $this->createConexion();
        $resultado = $db->prepare("UPDATE auto SET modelo = ?, anio = ?, precio = ?, color = ?  WHERE id_auto = ?");
        $resultado->execute([$modelo, $anio, $precio, $color, $id]);
    }

 
}
