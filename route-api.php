<?php
    require_once "libs/Router.php";
    require_once "app/controller/AutoApiController.php";
    require_once "app/controller/MarcaApiController.php";
    require_once "app/controller/UserApiController.php";

    $router = new Router();
    

    ////////// ROUTE DE VEHICULOS /////////////

    $router->addRoute('autos', 'GET', 'AutoApiController', 'getAll');//traemos todos los autos

    // $router->addRoute('autos/:ID', 'GET', 'AutoApiController', 'getAuto');//traemos un auto

    $router->addRoute('autos', 'POST', 'AutoApiController', 'addAuto');//agregamos un auto

    $router->addRoute('autos/:ID', 'DELETE', 'AutoApiController', 'borrarAuto');//borrar auto

    $router->addRoute('autos/:ID', 'PUT', 'AutoApiController', 'editarVehiculo');//editar auto
    
    $router->addRoute('autos/:ID', 'PUT', 'AutoApiController', 'autoVendido');//marcar como vendido el auto

    $router->addRoute('autos/:ID', 'PUT', 'AutoApiController', 'editarVehiculo');//editar auto


    ////////// ROUTE DE MARCAS /////////////

    $router->addRoute('marcas', 'GET', 'MarcaApiController', 'getAll');//traemos todos las marcas

    $router->addRoute('marcasDESC', 'GET', 'MarcaApiController', 'getAllDESC');//traemos todos las marcas de forma descendente

    $router->addRoute('marca/:ID', 'GET', 'MarcaApiController', 'getMarca');//traemos una marca en especifico

    $router->addRoute('marca', 'POST', 'MarcaApiController', 'addMarca');//agregamos una marca

    $router->addRoute('marca/:ID', 'DELETE', 'MarcaApiController', 'borrarMarca');//borrar marca
    
    $router->addRoute('editMarca/:ID', 'PUT', 'MarcaApiController', 'editarMarca');//editar marca



    ////////// ROUTE DE USUARIOS /////////////

    $router->addRoute('usuarios', 'GET', 'UserApiController', 'getAll');//traemos todos los usuarios

    $router->addRoute('usuariosASC', 'GET', 'UserApiController', 'getAllASC');//traemos todos los usuarios de forma ascendente

    $router->addRoute('usuario/:ID', 'GET', 'UserApiController', 'getUsuario');//traemos un usuario

    $router->addRoute('addUsuario', 'POST', 'UserApiController', 'newUser'); //añade un usuario a la base de datos

    $router->addRoute('usuario/:ID', 'DELETE', 'UserApiController', 'deleteUser');//borrar usuario

    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
