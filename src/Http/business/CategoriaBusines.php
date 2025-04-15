<?php
namespace src\Http\business;

use src\Http\lib\Session;
use src\models\Categoria;

class CategoriaBusines {

    use Session;
    /**
     * Registrar
     */

     public static function save(String|null $NombreCategoria):String{

        if(empty($NombreCategoria)){
            return "vacio";
        }
        $categoria = Categoria::Where("nombre_categoria","=",$NombreCategoria)->get();

        if($categoria){
            return 'existe';
        }
        return Categoria::create(["nombre_categoria" => $NombreCategoria]) ? 'ok'  : 'error';
     }

     /**
      * ACTUALIZAR CATEGORIAS
      */

      public static function modificar(String|null $NombreCategoria,$id):String{

        if(empty($NombreCategoria)){
            return "vacio";
        }
 
        return Categoria::Update(["id_categoria" =>$id ,"nombre_categoria" => $NombreCategoria]) ? 'ok'  : 'error';
     }


     public static function eliminar($id,String $fecha):String{
 
        return Categoria::Update(["id_categoria" =>$id ,"deleted_at" =>$fecha]) ? 'ok'  : 'error';
     }

     public static function ActivarCategoria($id):String{

        return Categoria::Update([
            "id_categoria" => $id,
            "deleted_at" => null
        ]) ? 'ok' : 'error';
     }

     public static function borrarCategoria($id){
        return Categoria::delete($id) ? 'ok' :'error';
     }
}