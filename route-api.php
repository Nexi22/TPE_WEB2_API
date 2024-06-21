<?php
    require_once "libs/Router.php";
    require_once "app/controller/AutoApiController.php";
    require_once "app/controller/MarcaApiController.php";
    require_once "app/controller/UserApiController.php";

    $router = new Router();
    

    ////////// ROUTER DE VEHICULOS /////////////

    $router->addRoute('autos', 'GET', 'AutoApiController', 'getAll');//traemos todos los autos

    $router->addRoute('auto/:ID', 'GET', 'AutoApiController', 'getAuto');//traemos un auto

    $router->addRoute('auto', 'POST', 'AutoApiController', 'addAuto');//agregamos un auto

    $router->addRoute('auto/:ID', 'DELETE', 'AutoApiController', 'borrarAuto');//borrar auto

    $router->addRoute('auto/:ID', 'PUT', 'AutoApiController', 'autoVendido');//marcar como vendido el auto

    $router->addRoute('autos/:ID', 'GET', 'AutoApiController', 'getAllxMarca');//traer autos por una marca especifica

    $router->addRoute('editAuto/:ID', 'PUT', 'AutoApiController', 'editarVehiculo');//editar auto


    ////////// ROUTER DE MARCAS /////////////

    $router->addRoute('marcas', 'GET', 'MarcaApiController', 'getAll');//traemos todos las marcas

    $router->addRoute('marca/:ID', 'GET', 'MarcaApiController', 'getMarca');//traemos una marca en especifico

    $router->addRoute('marca', 'POST', 'MarcaApiController', 'addMarca');//agregamos una marca

    $router->addRoute('marca/:ID', 'DELETE', 'MarcaApiController', 'borrarMarca');//borrar marca
    
    $router->addRoute('editMarca/:ID', 'PUT', 'MarcaApiController', 'editarMarca');//editar marca

    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);


    ////////// ROUTER DE USUARIOS /////////////

    $router->addRoute('usuarios', 'GET', 'UserApiController', 'getAll');//traemos todos los usuarios

    $router->addRoute('usuario/:ID', 'DELETE', 'UserApiController', 'deleteUser');//borrar usuario

