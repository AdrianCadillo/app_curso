<?php
namespace src\Http\controllers;

use src\models\Categoria;
use src\models\Producto;

class CategoriaController extends Controller{

    /**
     * Método para mostrar la vista de categorias
     */
    public function index(){
        View_("categorias.create"); 
    }

    /**
     * Metodo para registrar categorías
     */
    public function store(){
        if($this->VerifyCsrfToken($this->post("token_"))){
            echo $this->input("apellidos")."   ".$this->input("nombres");  
        }else{
            echo "error token csrf!!!";
        }
    }

    public function prueba(){
        echo "<pre>";
         print_r(Producto::select("id_producto","nombre_producto","stock")->get());
        echo "</pre>";
    }

    
}