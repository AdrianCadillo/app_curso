<?php 
namespace src\Http\business;

use src\models\Producto;

class ProductoBusines{


    /**
     * Registrar un nuevo producto
     */
    public static function RegistrarProducto(String $NameProducto,String|null $desc,float $precio_,int $stock_,int $categoria){
       
        return Producto::create([
            "nombre_producto" => $NameProducto,
            "descripcion" => $desc,
            "precio" => $precio_,
            "stock" => $stock_,
            "id_categoria" => $categoria
        ]) ? 'ok' : 'error';
    }
}