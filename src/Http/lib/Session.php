<?php
namespace src\Http\lib;

trait Session{

    /** CREAMOS UNA VARIABLE DE SESION */
    public function Sesion(String $NameSession,$Value){
        $_SESSION[$NameSession] = $Value;
    }

    /**
     * Recuperar el valor de la variable de sesion
     */
    public function getSesion(String $NameSession){
        return $this->ExisteSession($NameSession) ? $_SESSION[$NameSession] : '';
    }


    /**
     * Verificar existencia
     */
    public function ExisteSession(String $NameSession):bool{
        return isset($_SESSION[$NameSession]) ? true : false;
    }

    /**
     * Para eliminar la variable de sesion
     */
    public function DestroySession(String $NameSession){
        if($this->ExisteSession($NameSession)){
            unset($_SESSION[$NameSession]);
        }
    }
}