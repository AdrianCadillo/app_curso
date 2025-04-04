<?php 
namespace src\Http\lib;

trait Csrf{

    private String $NameSessionToken = "token";

    /**
     * Retornar el token CSRF
     */
    public function Csrf_Token(){

        /// asignamos al token
        $Token = bin2hex(random_bytes(64));

        if(!isset($_SESSION[$this->NameSessionToken])){
            $_SESSION[$this->NameSessionToken] = $Token;
        }

        return $_SESSION[$this->NameSessionToken];
    }


     /**
     * Retornar el token CSRF
     */
    public function Csrf(){

        /// asignamos al token
        $Token = bin2hex(random_bytes(64));

        if(!isset($_SESSION[$this->NameSessionToken])){
            $_SESSION[$this->NameSessionToken] = $Token;
        }

        return '<input type="hidden" name="token_" value="'.$_SESSION[$this->NameSessionToken].'">';
    }


    /**
     * Verificar el token csrf con el token que envio desde el formulario
     */
    public function VerifyCsrfToken(String|null $TokenInput):bool{
        if(isset($_SESSION[$this->NameSessionToken]) && !is_null($TokenInput)){
            if($_SESSION[$this->NameSessionToken] === $TokenInput){
                return true;
            }
            return false;
        }

        return false;
    }
}