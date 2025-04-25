<?php
namespace src\Http\controllers;

use src\Http\lib\Auth;

class LoginController extends Controller{


    /** REALIZAR EL LOGIN DE ACCESO AL SISTEMA */
    public function login(){
        if($this->VerifyCsrfToken($this->post("token_"))){
           Auth::Attemp([
            "login" => $this->post("login"),
            "password" => $this->post("password")
           ]);
        }else{
            json(["error" => "ERROR, EL TOKEN ES INCORRECTO!!!"]);
        }
    }

    /** CERRAR SESSION */
    public function cerrar_sistema(){
         $this->NoAuth();
        if($this->VerifyCsrfToken($this->post("token_"))){
            $this->logout();
        }    
    }
}