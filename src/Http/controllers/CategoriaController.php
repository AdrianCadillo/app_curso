<?php
namespace src\Http\controllers;
 
class CategoriaController{

    /**
     * Método para mostrar la vista de categorias
     */
    public function index(){
        View_("categorias.create");
    }
}