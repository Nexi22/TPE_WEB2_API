<?php
require_once "app/model/model.php";

class UserModel extends model{

    function getAll($order = 'ASC') {
        $db = $this->createConexion();
        $orderSql = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $consulta = $db->prepare("SELECT * FROM usuario ORDER BY id $orderSql");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    function get($id){
        $db = $this->createConexion();
        $sentencia = $db->prepare("SELECT * FROM usuario WHERE id = ?");
        $sentencia->execute([$id]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    function getByEmail($email) {
        $db = $this->createConexion();
        $sentencia = $db->prepare("SELECT * FROM usuario WHERE email = ?");
        $sentencia->execute([$email]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }
    
    function getAllByRol($rol, $order = 'ASC') {
        $db = $this->createConexion();
        $orderSql = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $sentencia = $db->prepare("SELECT * FROM usuario WHERE rol = ? ORDER BY id $orderSql");
        $sentencia->execute([$rol]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
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