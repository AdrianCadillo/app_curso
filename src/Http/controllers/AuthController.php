<?php 
namespace src\Http\controllers;

use src\Http\business\AuthBusines;
use src\models\User;

class AuthController extends Controller{

    /** Método para ver la vista de login */
    public function index(){
        View_("auth.login");
    }

    /** MOSTRAR LA VISTA DE CREAR USUARIO */
    public function createAccount(){
        View_("auth.register");
    }

    /** Método para registrar */
    public function store(){
        if($this->VerifyCsrfToken($this->post("token_"))){

            AuthBusines::saveUser($this->post("email"),$this->post("username"),
                                             $this->post("password"));                        
        }else{
            $this->Sesion("error","Error, el token es incorrecto!!");
        }

        Pageredirect("user/register");
    }

    /** VISTA DE ACTIVAR LA CUENTA */
    public function ActivarCuenta(){

        $usuario = User::Where("id_usuario","=",$this->get("id"))
                   ->And("token","=",$this->get("token"))
                   ->get();
 
        if($usuario && $usuario[0]->tiempo_expired > time()){           
          View_("auth.active_account");
        }else{
            echo "NO ESTAS AUTHRIZADO DE VER ESTA PAGINA!!";
        }
    }

    /** ACTIVAR */
    public function activarUser(){
        if($this->VerifyCsrfToken($this->post("token_"))){

            /// verificamos si el código que ingresa el usuario es correcto
            $usuario = User::Where("code_verification","=",$this->post("codigo"))->get();

            if($usuario){

              $this->Sesion("success",AuthBusines::ActivarCuenta($this->get("id")));
              exit;
              // iniciar sesion
            }else{
              $this->Sesion("error","El código ingresado es incorrecto!!");
            }
        }else{
            $this->Sesion("error","Token incorrecto!!");
        }

        Pageredirect("user/active/account?id=".$this->get("id")."&token=".$this->get("token"));
    }
}