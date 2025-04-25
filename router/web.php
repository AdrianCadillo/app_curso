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

$router->get("/dashboard","HomeController@home");

/// productos
$router->get("/productos","ProductoController@index");
$router->get("/productos/all","ProductoController@mostrar");
$router->post("/producto/store","ProductoController@store");
$router->post("/producto/{id}/update","ProductoController@updateProducto");
$router->post("/producto/{id}/eliminar","ProductoController@eliminar");


/** AUTHENTICACION */
$router->get("/login","AuthController@index");
$router->get("/user/register","AuthController@createAccount");
$router->post("/user/store","AuthController@store");

$router->get("/user/active/account","AuthController@ActivarCuenta");

$router->post("/activar-cuenta-usuario","AuthController@activarUser");

/// LOGIN
$router->post("/hacer-login","LoginController@login");

$router->post("/logout","LoginController@cerrar_sistema");

/// GESTION DE USUARIOS
$router->get("/gestion-de-usuarios","UserController@index");
