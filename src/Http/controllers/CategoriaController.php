<?php
namespace src\Http\controllers;

use src\models\Categoria;
use src\models\Producto;

class CategoriaController extends Controller{

    /**
     * Método para mostrar la vista de categorias
     */
    public function index(){
        View_("categorias.index"); 
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
        // echo "<pre>";
        //  print_r(Categoria::Where("nombre_categoria","=","Marketing")
        //  ->And("id_categoria","=",3)
        //  ->Or("id_categoria","=",2)
        //  ->select("nombre_categoria")
        //  ->get());
        // echo "</pre>";

        // echo Producto::create([
        //     "nombre_producto" => "Gaseosa Fanta de 3 litros",
        //     "descripcion" => "Gaseosa bebidas",
        //     "precio" => 10,
        //     "stock" => 23,
        //     "id_categoria" => 4
        // ]);

        // echo Producto::Update([
        //     "id_producto" => 3,
        //     "nombre_producto" => "Gaseosa Coca Cola de 3 litros",
        //     "precio" => 12.60
        // ]);


        //echo Categoria::delete(1);

        // echo "<pre>";
        // print_r(Categoria::LeftJoin("productos as p","p.id_categoria","=","c.id_categoria")
        // ->Where("p.id_categoria","is",null)
        // ->select("c.id_categoria","c.nombre_categoria")
        // ->get());
        // echo "</pre>";

         echo assets("plugins/fontawesome-free/css/all.min.css");
    }

    
}