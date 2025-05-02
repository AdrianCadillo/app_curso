<?php 
if(PHP_SESSION_ACTIVE != session_status()){
    session_start();
}

$router->get("/prueba","UserController@prueba");

$router->post("/user/update/{id}","UserController@modificarUsuario");