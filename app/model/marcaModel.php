<?php
require_once "app/model/model.php";

class marcaModel extends model {
    
   //traemos todas las marcas
    function getAll(){
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM marca");
        $consulta->execute();
        $marcas = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $marcas;
    }

    function getAllDESC(){
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM marca ORDER BY id_marca DESC");
        $consulta->execute();
        $marcas = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $marcas;
    }

    //traemos una marca en especifico
    function get($id){
        //abrimos la conexion;
        $db = $this->createConexion();
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM marca WHERE id_marca = ?");
        $sentencia->execute([$id]);
        $marca = $sentencia->fetch(PDO::FETCH_OBJ);
        return $marca;
    }

    //insertamos una marca
    function insertar($nombre, $pais_de_origen, $ano_de_fundacion, $descripcion){
        //CREA LA CONEXION A LA DB
        $db = $this->createConexion();
        //MANDAS LA CONSULTA
        $consulta = $db->prepare("INSERT INTO marca (nombre, pais_de_origen, ano_de_fundacion, descripcion) VALUES (?, ?, ?, ?)");
        //EJECUTAS
        $consulta->execute([$nombre, $pais_de_origen, $ano_de_fundacion, $descripcion]);
        return $db->lastInsertId();
    }

    //Borrar una Marca
    function delete($id){
        $db = $this->createConexion();
        $resultado= $db->prepare("DELETE FROM marca WHERE id_marca = ?");
        $resultado->execute([$id]); // ejecuta
    }
    //  Editar Marca
    function edit($nombre, $pais_de_origen, $ano_de_fundacion, $descripcion, $id_marca) {
        $db = $this->createConexion();
        $resultado = $db->prepare("UPDATE marca SET nombre = ?, pais_de_origen = ?, ano_de_fundacion = ?, descripcion = ? WHERE id_marca = ?");
        $resultado->execute([$nombre, $pais_de_origen, $ano_de_fundacion, $descripcion, $id_marca]);
        return $db->lastInsertId();
    }


    // //preguntar
    // function getNombreMarca(){
    //     //abrimos la conexion;
    //     $db = $this->createConexion();
    //     //Enviar la consulta
    //     $sentencia = $db->prepare("SELECT id_marca, nombre FROM marca");
    //     $sentencia->execute();
    //     $marca = $sentencia->fetchAll(PDO::FETCH_OBJ);
    //     return $marca;
    // }
    
   
    

    
    
    
    
    



}


