<?php
namespace src\orm\database;

use PDO;

trait Conection{

    /**PROPIEADES */
    private static $Conection;
    public static $pps;

    /** CREAMOS UN METODO PARA LA CONEXION */

    public static function getConexion(){
        try {
            self::$Conection = new PDO(
                URLDRIVER,
                USUARIO,
                PASSWORD
            );

            return self::$Conection;
        } catch (\Throwable $th) {
           echo "<h1 style='color:red'>".$th->getMessage()."</h1>";
           exit;
        }
    }

    /**LIBERAR RECURSOS*/
    public static function closeConection(){
        if(self::$Conection != null){
            self::$Conection = null;
        }

        if(self::$pps != null){
            self::$pps = null;
        }
    }
}