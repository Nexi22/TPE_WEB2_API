<?php
require_once "config.php";

// Hacemos la conexión con la base de datos
class Model {
    protected $conexion;
    
    public function __construct() {
        $this->conexion = $this->createConexion();
        $this->deploy();
    }

    function createConexion() {
        try {
            $db = new PDO("mysql:host=".MYSQL_HOST.";charset=utf8", MYSQL_USER, MYSQL_PASS);
            
            $this->createOrUseDatabase($db);
        
        } catch (Exception $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
        return $db;
    }

    // En este paso vemos si está la base de datos, si no está crea la base de datos
    private function createOrUseDatabase($db) {
        $query = $db->query("SHOW DATABASES LIKE '".MYSQL_DB."'");
        $databaseExists = $query->rowCount() > 0;

        if (!$databaseExists) {
            $db->query("CREATE DATABASE ".MYSQL_DB."");
        }
        
        $db->query("USE ".MYSQL_DB."");
    }

    // Función que permite la creación de tablas o entidades
    function deploy() {
        $this->createTables(); 
        $this->createUsuarios();          
    }

    function createTables() {
        // En la variable sql se coloca su código de creación de tablas
        // se hizo la creacion 'sqls' para iterar mas abajo con un forech para que cree todas las tablas
        $sql = 
            "CREATE TABLE IF NOT EXISTS `usuario` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `email` varchar(250) NOT NULL,
                `password` varchar(250) NOT NULL,
                `rol` varchar(20) NOT NULL,
                PRIMARY KEY (`id`)
            );
            
            
           
            CREATE TABLE IF NOT EXISTS `marca` (
                `id_marca` int(11) NOT NULL AUTO_INCREMENT,
                `nombre` varchar(250) NOT NULL,
                `pais_de_origen` varchar(250) NOT NULL,
                `ano_de_fundacion` int(250) NOT NULL,
                `descripcion` varchar(250) NOT NULL,
                PRIMARY KEY (`id_marca`)
            );

            CREATE TABLE IF NOT EXISTS `auto` (
                `id_auto` int(11) NOT NULL AUTO_INCREMENT,
                `modelo` varchar(50) NOT NULL,
                `anio` int(4) NOT NULL,
                `precio` int(30) NOT NULL,
                `color` varchar(20) NOT NULL,
                `vendido` tinyint(1) NOT NULL,
                `id_marca` int(11) NOT NULL,
                PRIMARY KEY (`id_auto`)
            );
     
            alter TABLE auto ADD CONSTRAINT fk_auto_marca FOREIGN KEY (id_marca) REFERENCES marca(id_marca);
            ";
        
            $this->conexion->query($sql);
    }

    function createUsuarios() {
        $insertUsuarios = "INSERT IGNORE INTO `usuario` (`email`, `password`, `rol`) VALUES
            ('webadmin', '$2y$10$5NAqV3QBUNcOxloaz1jaA.1ChRcKZ4leDgU6j1P9OHiqANHUpuH.a', 'admin'),
            ('prueba', '$2y$10$7Au7E2hNhKfF1XS1xif7qeh58A7B3DjtaWsAYgZA9.Nplop2RInGy', 'user')";

        $this->conexion->query($insertUsuarios);
    }
}
?>
