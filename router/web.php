<?php
if(PHP_SESSION_ACTIVE != session_status()){
    session_start();
}
$router->get("/categorias","CategoriaController@index");
$router->post("/categoria/save","CategoriaController@store");
$router->get("/prueba","CategoriaController@prueba");
