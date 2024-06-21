<?php
require_once "app/model/model.php";

class AutenticacionModel extends Model {
    
    function obtenerUsuario($email){
        $db = $this->createConexion();
        
        $consulta = $db-> prepare("SELECT * FROM usuario WHERE email = ? ");
        $consulta->execute([$email]);
        $usuario = $consulta->fetch(PDO::FETCH_OBJ);
        return $usuario;
    }

    
}
