<?php 
namespace src\Http\business;

use src\models\Producto;

class ProductoBusines{


    /**
     * Registrar un nuevo producto
     */
    public static function RegistrarProducto(String $NameProducto,String|null $desc,float $precio_,int $stock_,int $categoria,
    String|null $imagen){
       
        return Producto::create([
            "nombre_producto" => $NameProducto,
            "descripcion" => $desc,
            "precio" => $precio_,
            "stock" => $stock_,
            "id_categoria" => $categoria,
            "imagen" => $imagen
        ]) ? 'ok' : 'error';
    }

    public static function ModificarProducto(
    int $Id,String $NameProducto,String|null $desc,
    float $precio_,int $stock_,int $categoria,String|null $imagen){
       
        return Producto::Update([
            "id_producto" => $Id,
            "nombre_producto" => $NameProducto,
            "descripcion" => $desc,
            "precio" => $precio_,
            "stock" => $stock_,
            "id_categoria" => $categoria,
            "imagen" => $imagen
        ]) ? 'ok' : 'error';
    }

    /**ELIMINAR AL PRODUCTO */
    public static function EliminarProducto($id,$FechaEliminado){
        return Producto::Update([
            "id_producto" => $id,
            "deleted_at" => $FechaEliminado
        ]) ? 'ok' : 'error';
    }
}