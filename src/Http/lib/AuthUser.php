<?php
namespace src\Http\lib;

use src\models\User;

trait AuthUser{
use Session;

    private static String $RedirectHome = "dashboard";

    private static String $RedirectNoAuthenticate = "login";
    /** RECUPERAMOS LOS DATOS DEL USUARIO AUTHENTICADO */
    public static function getUser(){
        /// verificamos la existencia de la sesion del usuario(user => id_usuario)
        if(self::ExisteSession("user")){
            $usuario = User::Where("id_usuario","=",self::getSesion("user"))->get();

            return $usuario;
        }

        return null;
    }

    /// VERIFICAR SI ESTA AUTHENTICADO
    public static function Auth(){
        if(self::ExisteSession("user")){
            Pageredirect(self::$RedirectHome);
            exit;
        }
    }

    /// SI NO ESTAMOS AUTHENTICADO
    public static function NoAuth(){
        if(!self::ExisteSession("user")){
            Pageredirect(self::$RedirectNoAuthenticate);
            exit;
        }
    }

    /** CERRAR EL SISTEMA */
    public static function logout(){
        if(self::ExisteSession("user")){
            self::DestroySession("user");
            Pageredirect(self::$RedirectNoAuthenticate);
        }    
    }

}