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

    function getUser($id){
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM usuario WHERE id = ?");
        $consulta->execute([$id]);
        $usuario = $consulta->fetch(PDO::FETCH_OBJ);
        return $usuario;
    }
}