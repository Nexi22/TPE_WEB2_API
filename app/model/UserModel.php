<?php
require_once "app/model/model.php";

class UserModel extends model{

    // Método para obtener los usuarios paginadas
    public function getPaginated($offset, $limit) {
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM usuario LIMIT :limit OFFSET :offset");
        $consulta->bindParam(':limit', $limit, PDO::PARAM_INT);
        $consulta->bindParam(':offset', $offset, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }
        
        // Método para contar el número total de usuarios
    public function countAll() {
        $db = $this->createConexion();
            $consulta = $db->query("SELECT COUNT(*) as total FROM usuario");
        return $consulta->fetch(PDO::FETCH_OBJ)->total;
    }

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
        $db= $this->createConexion();
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM usuario WHERE id = ?");
        $sentencia->execute([$id]);
        $usuario = $sentencia->fetch(PDO::FETCH_OBJ);
        return $usuario;
    }

    //Añadir un usuario nuevo
    public function addUser($email, $password, $rol){
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $db = $this->createConexion();
            $consulta = $db->prepare("INSERT INTO usuario (email, password, rol) VALUES (?, ?, ?)");
            $consulta->execute([$email, $hashedPassword, $rol]);
    
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error en la inserción del usuario" . $e->getMessage());
            return false;
        }
    }
    
    function delete($id){
        $db = $this->createConexion();
        $resultado= $db->prepare("DELETE FROM usuario WHERE id = ?");
        $resultado->execute([$id]); // ejecuta
    }
}