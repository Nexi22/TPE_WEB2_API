<?php
require_once "app/model/model.php";

class marcaModel extends model {
    
    function mostrarFormMarca(){
        $db = $this->createConexion();
    }   

    function getALLMarcas(){
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM marca");
        $consulta->execute();
        $marcas = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $marcas;
    }

    function insertarMarca($nombre, $pais_de_origen, $ano_de_fundacion, $descripcion){
        //CREA LA CONEXION A LA DB
        $db = $this->createConexion();
        //MANDAS LA CONSULTA
        $consulta = $db->prepare("INSERT INTO marca (nombre, pais_de_origen, ano_de_fundacion, descripcion) VALUES (?, ?, ?, ?)");
        //EJECUTAS
        $consulta->execute([$nombre, $pais_de_origen, $ano_de_fundacion, $descripcion]);
    }

    function get($id){
        //abrimos la conexion;
        $db = $this->createConexion();
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM marca WHERE id_marca = ?");
        $sentencia->execute([$id]);
        $marca = $sentencia->fetch(PDO::FETCH_OBJ);
        return $marca;
    }

    function getNombreMarca(){
        //abrimos la conexion;
        $db = $this->createConexion();
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT id_marca, nombre FROM marca");
        $sentencia->execute();
        $marca = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $marca;
    }
    
    function getMarcaByID($id){
        //abrimos la conexion;
        $db = $this->createConexion();       //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM marca WHERE id_marca = ?");
        $sentencia->execute([$id]);
        $marca = $sentencia->fetch(PDO::FETCH_OBJ);
        return $marca;
    }

    function getMarcaByFilter($id){
        //abrimos la conexion;
        $db = $this->createConexion();       //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM marca WHERE id_marca = ?");
        $sentencia->execute([$id]);
        $marcas = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $marcas;
    }

    
    function borrarMarca($id){
        $db = $this->createConexion();
        $resultado= $db->prepare("DELETE FROM marca WHERE id_marca = ?");
        $resultado->execute([$id]); // ejecuta
    }
    
    function editarMarca($nombre, $pais_de_origen, $ano_de_fundacion, $descripcion, $id_marca) {
        $db = $this->createConexion();
        $resultado = $db->prepare("UPDATE marca SET nombre = ?, pais_de_origen = ?, ano_de_fundacion = ?, descripcion = ? WHERE id_marca = ?");
        $resultado->execute([$nombre, $pais_de_origen, $ano_de_fundacion, $descripcion, $id_marca]);
    }
    



}


