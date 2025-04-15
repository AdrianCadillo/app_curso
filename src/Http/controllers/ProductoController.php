<?php
namespace src\Http\controllers;

use src\Http\business\ProductoBusines;
use src\models\Producto;

class ProductoController extends Controller{

    /** METODO PARA MOSTRAR LA PÁGINA PRINCIPAL DE PRODUCTOS */
    public function index(){
        View_("producto.index");
    }

    /** MOSTRAR LOS PRODUCTOS DE LA BASE DE DATOS */
    public function mostrar(){
        $productos = Producto::Join("categorias as cat","p.id_categoria","=","cat.id_categoria")
                     ->get();

        json(["productos" => $productos]);
    }

    /** Registrar un producto*/
    public function store(){
        if($this->VerifyCsrfToken($this->post("token_"))){
            json(["response" => ProductoBusines::RegistrarProducto(
                $this->post("nombre_producto"),
                $this->post("descripcion"),
                $this->post("precio"),
                $this->post("stock"),
                8
            )]);
        }else{
            json(["error" => "token invalid!!"]);
        }
    }
}