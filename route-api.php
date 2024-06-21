<?php
    require_once('libs/Router.php');
    require_once('app/controller/AutoApiController.php');
    

    $router = new Router();

    // GET http://localhost/api/tareas 
    $router->addRoute('autos', 'GET', 'AutoApiController', 'getAll');
    $router->addRoute('autos/:ID', 'GET', 'AutoApiController', 'getAuto');
    
    // $router->addRoute('tareas', 'POST', 'TaskApiController', 'addTarea');
    // $router->addRoute('tareas/:ID', 'DELETE', 'TaskApiController', 'borrarTarea');
    // $router->addRoute('tareas/:ID', 'PUT', 'TaskApiController', 'finalizaTarea');

    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
