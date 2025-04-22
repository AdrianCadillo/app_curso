<?php
namespace src\Http\lib;

trait Session{

    /** CREAMOS UNA VARIABLE DE SESION */
    public static function Sesion(String $NameSession,$Value){
        $_SESSION[$NameSession] = $Value;
    }

    /**
     * Recuperar el valor de la variable de sesion
     */
    public static function getSesion(String $NameSession){
        return self::ExisteSession($NameSession) ? $_SESSION[$NameSession] : '';
    }


    /**
     * Verificar existencia
     */
    public static function ExisteSession(String $NameSession):bool{
        return isset($_SESSION[$NameSession]) ? true : false;
    }

    /**
     * Para eliminar la variable de sesion
     */
    public static function DestroySession(String $NameSession){
        if(self::ExisteSession($NameSession)){
            unset($_SESSION[$NameSession]);
        }
    }
}