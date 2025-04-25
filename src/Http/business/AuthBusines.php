<?php 
namespace src\Http\business;

use Exception;
use src\Http\lib\Email;
use src\Http\lib\Session;
use src\models\User;

class AuthBusines{

    use Email,Session;
    /** Registrar usuario */
    public static function saveUser(String $Email,String $Usermame,String $Password){
     
        $usuario = User::Where("email","=",$Email)
                   ->Or("username","=",$Usermame)->get();

        if($usuario){
           self::Sesion("existe","El usuario que deseas registrar ya existe!!");
           exit;
        }        
        $Codigo =   GenerateCodeToken(); 
        $Texto = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $Token = GenerateCodeToken($Texto,0,30);
        $response = User::create([
            "username" => $Usermame,"email" => $Email,
            "code_verification" => $Codigo,
            "token" => $Token,
            "tiempo_expired" => time() + 60*10,
            "estado"=>"i",
            "password_" => password_hash($Password,PASSWORD_BCRYPT),"rol" => "u"
        ]);

        if($response){

            $usuarioData = User::Where("email","=",$Email)->get();

             self::sendCorrreoCodigoActiveAccount($usuarioData);
             exit;

        }else{
           
            self::Sesion("error","Error al registrar usuario");
        }
         
    }


    /** Enviar correo */
    private static function sendCorrreoCodigoActiveAccount($usuario){
     
       
        if(self::sendEmail($usuario,"ACTIVACION DE LA CUENTA","TU CODIGO DE ACTIVACION ES : ".$usuario[0]->code_verification)){

            self::Sesion("success","Te hemos enviado un código al correo electronico para activar tu cuenta!");
            Pageredirect("user/active/account?id=".$usuario[0]->id_usuario."&token=".$usuario[0]->token);
        }else{

        }
    }

    /** ACTIVAR LA CUENTA DEL USUARIO */
    public static function activarCuenta($id,String $Fecha){
        return User::Update([
            "id_usuario" => $id,
            "estado" => "a",
            "email_verified" => $Fecha
        ]) ? 'ok' : 'error';
    }
}