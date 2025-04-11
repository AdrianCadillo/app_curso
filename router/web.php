<?php
if(PHP_SESSION_ACTIVE != session_status()){
    session_start();
}
$router->get("/categorias","CategoriaController@index");
$router->get("/categoria/create","CategoriaController@create");
$router->post("/categoria/save","CategoriaController@store");
$router->get("/categoria/{id}/editar","CategoriaController@editar");
$router->post("/categoria/{id}/update","CategoriaController@update");
$router->post("/categoria/{id}/eliminar","CategoriaController@eliminar");

$router->get("/dashboard","DashboardController@index");
