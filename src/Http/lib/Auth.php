<?php
namespace src\Http\lib;

use src\models\User;

class Auth{
    use Session;
    /** Verificar si el usuario existe */
    public static function login($EmailUser){

        $User = User::Where("email","=",$EmailUser)->get();

        /// verifico si existe el usuario
        if($User){
            if($User[0]->email === $EmailUser){

                /// actualizar mi tabla usuario
                User::Update([
                    "id_usuario" => $User[0]->id_usuario,
                    "token" => null,
                    "tiempo_expired" => null,
                    "code_verification" => null
                ]);

                self::Sesion("user",$User[0]->id_usuario);
                Pageredirect("categorias");
                exit;
            }

            self::Sesion("error","El email ingresado es incorrecto!!!");

        }else{
            self::Sesion("error","El usuario con ese email no existe!!!");
        }

        Pageredirect("user/active/account?id=".$User[0]->id_usuario."&token=".$User[0]->token);
    }

    /** LOGIN */
    public static function Attemp(array $Credenciales){
        /// consultar al usuario

        $Usuario = User::Where("username","=",$Credenciales["login"])
        ->Or("email","=",$Credenciales["login"])->get();

        /// verificar si existe el usuario
        if($Usuario){
            if($Usuario[0]->username === $Credenciales["login"] || $Usuario[0]->email === $Credenciales["login"]){

                /// compara la contraseña que ingresa el usuario y de la base de datos
                if(password_verify($Credenciales["password"],$Usuario[0]->password_)){

                    self::Sesion("user",$Usuario[0]->id_usuario);
                    
                    json(["success" => "ok-login"]);

                }else{
                   json(["error" => "PASSWORD INCORRECTO!!!"]);
                }
            }else{
                json(["error" => "USERNAME | EMAIL ES INCORRECTO!!!"]);
            }
        }else{
          json(["error" => "LAS CREDENCIALES SON INCORRECTOS , USUARIO NO EXISTE!!!"]);
        }
    }
}