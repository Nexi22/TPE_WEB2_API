<?php
require_once "app/model/model.php";

class VehicleModel extends model{

    function getAll(){
        //CREO LA CONEXION Y ENVIO LA CONSULTA A LA DB
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM auto");
        $consulta->execute();
        $vehicles = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $vehicles;
    }

    function get($id){
        //abrimos la conexion;
        $db = $this->createConexion();
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM auto WHERE id_auto = ?");
        $sentencia->execute([$id]);
        $vehicle = $sentencia->fetch(PDO::FETCH_OBJ);
        return $vehicle;
    }

    function getAutoyMarca(){
        //CREO LA CONEXION Y ENVIO LA CONSULTA A LA DB
        $db = $this->createConexion();
        $consulta = $db->prepare("SELECT * FROM auto a, marca m WHERE a.id_marca = M.id_marca");
        $consulta->execute();
        $vehicles = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $vehicles;
    }

    function insertar($modelo, $anio, $precio, $color, $id){
        $db = $this->createConexion();
        $consulta = $db->prepare("INSERT INTO auto (modelo, anio, precio, color, vendido, id_marca) VALUES (?, ?, ?, ?, ?, ?)");
        $consulta->execute([$modelo, $anio, $precio, $color, 0, $id]);
    }
     
    function vehiculoVendido($id){ //preguntarle al profe, no cambia a vendido
        $db = $this->createConexion();
        $resultado= $db->prepare("UPDATE auto SET vendido = ? WHERE id_auto = ?");
        $resultado->execute([1,$id]); // ejecuta
    }

    function borrarVehiculo($id){
        $db = $this->createConexion();
        $resultado= $db->prepare("DELETE FROM auto WHERE id_auto = ?");
        $resultado->execute([$id]); // ejecuta
    }

    function editarVehiculo($modelo, $anio, $precio, $color, $id) {
        $db = $this->createConexion();
        $resultado = $db->prepare("UPDATE auto SET modelo = ?, anio = ?, precio = ?, color = ?  WHERE id_auto = ?");
        $resultado->execute([$modelo, $anio, $precio, $color, $id]);
    }

   

    function getAllVehicleByMarca($id){
        //abrimos la conexion;
        $db = $this->createConexion();
        //Enviar la consulta
        $sentencia = $db->prepare("SELECT * FROM auto WHERE id_marca = ?");
        $sentencia->execute([$id]);
        $vehicles = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $vehicles;
    }
    
    function getVehiculosByMarcas(){
        $db = $this->createConexion();
        $sentencia = $db->prepare("SELECT * FROM auto a, marca m WHERE a.id_auto = m.id_marca");       
        $sentencia->execute([]);
        $vehiclesXmarca = $sentencia->fetchALL(PDO::FETCH_OBJ);
        return $vehiclesXmarca;
    }
    

    function mostrarFormVehiculo(){
        $db = $this->createConexion();
        
    }    
}
