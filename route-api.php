<?php
    require_once "libs/Router.php";
    require_once "app/controller/AutoApiController.php";
    require_once "app/controller/MarcaApiController.php";
    require_once "app/controller/UserApiController.php";

    $router = new Router();
    

    ////////// ROUTE DE VEHICULOS /////////////

    $router->addRoute('autos', 'GET', 'AutoApiController', 'getAll');//traemos todos los autos

    $router->addRoute('autos/:ID', 'GET', 'AutoApiController', 'getAuto');//traemos un auto

    $router->addRoute('autos', 'POST', 'AutoApiController', 'addAuto');//agregamos un auto

    $router->addRoute('autos/:ID', 'DELETE', 'AutoApiController', 'borrarAuto');//borrar auto

    $router->addRoute('autos/:ID', 'PUT', 'AutoApiController', 'editarVehiculo');//editar auto
    
    $router->addRoute('autos/:ID', 'PUT', 'AutoApiController', 'autoVendido');//marcar como vendido el auto


    ////////// ROUTE DE MARCAS /////////////

    $router->addRoute('marcas', 'GET', 'MarcaApiController', 'getAll');//traemos todos las marcas

    $router->addRoute('marcas/:ID', 'GET', 'MarcaApiController', 'getMarca');//traemos una marca en especifico

    $router->addRoute('marcas', 'POST', 'MarcaApiController', 'addMarca');//agregamos una marca

    $router->addRoute('marcas/:ID', 'DELETE', 'MarcaApiController', 'borrarMarca');//borrar marca
    
    $router->addRoute('marcas/:ID', 'PUT', 'MarcaApiController', 'editarMarca');//editar marca



    ////////// ROUTE DE USUARIOS /////////////

    $router->addRoute('usuarios', 'GET', 'UserApiController', 'getAll');//traemos todos los usuarios

    $router->addRoute('usuarios/:ID', 'GET', 'UserApiController', 'getUsuario');//traemos un usuario

    $router->addRoute('usuarios', 'POST', 'UserApiController', 'newUser'); //añade un usuario a la base de datos

    $router->addRoute('usuarios/:ID', 'DELETE', 'UserApiController', 'deleteUser');//borrar usuario

    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
