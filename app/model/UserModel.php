<?php
require_once "app/model/model.php";

class UserModel extends model{

    function getAll(){
        $db = $this->createConexion(); 
        $consulta = $db->prepare("SELECT * FROM usuario");
        $consulta->execute();
        $usuarios = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    }

    function getAllASC(){
        $db = $this->createConexion(); 
        $consulta = $db->prepare("SELECT * FROM usuario ORDER BY id ASC;");
        $consulta->execute();
        $usuarios = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    }

     //traemos una usuario en especifico
     function get($id){
        //abrimos la conexion;
        $db = $this->createConexion();
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM usuario WHERE id = ?");
        $sentencia->execute([$id]);
        $usuario = $sentencia->fetch(PDO::FETCH_OBJ);
        return $usuario;
    }
    

    function delete($id){
        $db = $this->createConexion();
        $resultado= $db->prepare("DELETE FROM usuario WHERE id = ?");
        $resultado->execute([$id]); // ejecuta
    }
}