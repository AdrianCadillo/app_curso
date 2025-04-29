<?php

namespace src\Http\controllers;

use src\Http\lib\Upload;
use src\models\User;

class UserController extends Controller{

    use Upload;
    private $Errors = [];
    public function index(){
        View_("user.index");
    }

    // mostrar los usuarios
    public function showUsers(){
        $usuarios = User::get();

        json(["users" => $usuarios]);
    }

    /// registrar nuevo usuario
    public function store(){
        if($this->VerifyCsrfToken($this->post("token_"))){

            $this->ValidateFormUser();

            $ExisteUsuario = User::Where("username","=",self::post("username"))
                                   ->Or("email","=",self::post("email"))->get();

            if($ExisteUsuario){
                json(["error" => "EL USUARIO QUE DESEAS REGISTRAR YA EXISTE POR EMAIL | USERNAME!!!"]);
                exit;
            }

            $this->setNameFile("foto");
            $this->setDestino("assets/img/users/");

            $this->UploadFile();

            $response = User::create([
                "username" => $this->post("username"),
                "email" => $this->post("email"),
                "password_" => password_hash($this->post("password"),PASSWORD_BCRYPT),
                "rol" => $this->post("rol"),
                "estado" => "a",
                "foto" => $this->getNombreDelArchivo()
            ]);

            if($response){
                json(["response" => "USUARIO REGISTRADO CORRECTAMENTE!!!"]);
            }else{
                json(["error" => "ERROR AL REGISTRAR USUARIO!!!"]);
            }
        }else{
            json(["error" => "ERROR, TOKEN INCORRECTO!!!"]);
        }
    }


    private function ValidateFormUser(){

        if($this->post("username") == null){
            $this->Errors["username"] = "Ingresar nombre de usuario!!";
        }

        if($this->post("email") == null){
            $this->Errors["email"] = "Ingresar el correo electrónico!!";
        }else{
            if(!filter_var($this->post("email"),FILTER_VALIDATE_EMAIL)){
                $this->Errors["email"] = "Ingresar un correo válido!!!";
            }
        }

        if($this->post("password") == null){
            $this->Errors["password"] = "Ingresar el password del usuario!!";
        }

        if(count($this->Errors) > 0){
            json(["errors" => $this->Errors]);
            exit;
        }
    }


    /// ELIMINAR AL USUARIO
    public function eliminar($id){
      if($this->VerifyCsrfToken($this->post("token_"))){

        $UserId = self::getUser()[0]->id_usuario;

        if($this->getUser()[0]->rol === 'a'){
            if($UserId == $id){
                json(["error" => "ERROR, NO PUEDES ELIMINAR TU PROPIA CUENTA!!!"]);
            }else{
                $response = User::delete($id);
    
                if($response){
                    json(["success" => "USUARIO ELIMINADO CORRECTAMENTE!!"]);
                }else{
                    json(["error" => "ERROR AL ELIMINAR USUARIO!!!"]); 
                }
            }
        }else{
            json(["error" => "NO TIENES PERMISOS PARA ELIMINAR!!"]);
        }

      }else{
        json(["error" => "ERROR, TOKEN ES INCORRECTO!!!"]);
      }
    }
}