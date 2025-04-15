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
$router->post("/categoria/{id}/activar","CategoriaController@activar");
$router->post("/categoria/{id}/borrar","CategoriaController@borrar");

$router->get("/dashboard","DashboardController@index");

/// productos
$router->get("/productos","ProductoController@index");
$router->get("/productos/all","ProductoController@mostrar");
$router->post("/producto/store","ProductoController@store");
