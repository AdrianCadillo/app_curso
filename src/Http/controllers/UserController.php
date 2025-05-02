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
 
    public function prueba(){
        echo "<pre>";
          $response = User::procedure("proc_gestion","C",["i-c","Categoría de prueba"]);
          echo $response[0]->respuesta;
        echo "</pre>";
    }

    /** MODIFICAR AL USUARIO*/
    public function modificarUsuario($id){
      if($this->VerifyCsrfToken($this->post("token_"))){
         $this->setNameFile("foto_editar");
         $this->setDestino("assets/img/users/");

         $response = $this->UploadFile();

         $user = User::Where("id_usuario","=",$id)->get();

         if($response != 'vacio'){
            if($user[0]->foto != null){
                $pathFoto =  "assets/img/users/".$user[0]->foto;
                unlink(($pathFoto));
            }
         }else{
            $this->setNombreDelArchivo($user[0]->foto);
         }

         $responseUser = User::Update([
            "id_usuario" => $id,
            "username" => self::post("username_editar"),
            "email" => self::post("email_editar"),
            "rol" => self::post("rol_editar"),
            "foto" => $this->getNombreDelArchivo()
         ]);  

         if($responseUser){
            json(["success" => "DATOS DEL USUARIO MODIFICADOS!!!"]);
         }else{
            json(["error" => "ERROR AL MODIFICAR DATOS DEL USUARIO!!"]);
         }

      }else{
        json(["error" => "ERROR, TOKEN INCORRECTO!!!"]);
      } 
    }
}