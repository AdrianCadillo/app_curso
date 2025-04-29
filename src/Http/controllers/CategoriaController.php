<?php
namespace src\Http\controllers;

use src\Http\business\CategoriaBusines;
use src\models\Categoria;
use src\models\Producto;

class CategoriaController extends Controller{

    /**
     * Método para mostrar la vista de categorias
     */
    public function index(){
        $this->NoAuth();
        if($this->getUser()[0]->rol === 'a'){
            $categorias = Categoria::get();
            View_("categorias.index",compact("categorias")); 
        }else{
            echo "NO ESTAS AUTHORIZADO PARA VER ESTA PAGINA!!!";
        }
    }

    /**
     * CREAR NUEVAS CATEGORIAS
     */
    public function create(){
         $this->NoAuth();
         View_("categorias.create");
    }

   
    /**
     * Metodo para registrar categorías
     */
    public function store(){
        if($this->VerifyCsrfToken($this->post("token_"))){
            $response = CategoriaBusines::save($this->post("nombre_categoria"));

            if($response === 'vacio'){
                $this->Sesion("error","Ingrese nombre de la categoría!!!");
                Pageredirect("categoria/create");
                exit;
            }

            if($response === 'ok'){
                $this->Sesion("success","Categoría registrado correctamente!!");
                Pageredirect("categorias");
                exit;
            }else{
                if($response === 'existe'){
                    $this->Sesion("existe","La categoría que deseas registrar ya existe!!!");  
                }else{
                    $this->Sesion("error","Error al crear categoría!!!");
                }
            }
        }else{
            $this->Sesion("error","Token invalid!!!");
        }

        Pageredirect("categoria/create");
    }

    public function prueba(){
        // echo "<pre>";
        //  print_r(Categoria::Where("nombre_categoria","=","Marketing")
        //  ->And("id_categoria","=",3)
        //  ->Or("id_categoria","=",2)
        //  ->select("nombre_categoria")
        //  ->get());
        // echo "</pre>";

        // echo Producto::create([
        //     "nombre_producto" => "Gaseosa Fanta de 3 litros",
        //     "descripcion" => "Gaseosa bebidas",
        //     "precio" => 10,
        //     "stock" => 23,
        //     "id_categoria" => 4
        // ]);

        // echo Producto::Update([
        //     "id_producto" => 3,
        //     "nombre_producto" => "Gaseosa Coca Cola de 3 litros",
        //     "precio" => 12.60
        // ]);


        //echo Categoria::delete(1);

        // echo "<pre>";
        // print_r(Categoria::LeftJoin("productos as p","p.id_categoria","=","c.id_categoria")
        // ->Where("p.id_categoria","is",null)
        // ->select("c.id_categoria","c.nombre_categoria")
        // ->get());
        // echo "</pre>";

         echo assets("plugins/fontawesome-free/css/all.min.css");
    }

    /**
     * EDITAR LAS CATEGORIAS
     */
    public function editar($id){
        $this->NoAuth();
        $categoria = Categoria::Where("id_categoria","=",$id)->get();
        if($categoria){
            View_("categorias.editar",compact("categoria"));
        }else{
            Pageredirect("categorias");
        }
    }


     /**
     * Metodo para registrar categorías
     */
    public function update($id){
        if($this->VerifyCsrfToken($this->post("token_"))){
            $response = CategoriaBusines::modificar($this->post("nombre_categoria"),$id);

            if($response === 'vacio'){
                $this->Sesion("error","Ingrese nombre de la categoría!!!");
                Pageredirect("categoria/".$id."/editar");
                exit;
            }

            if($response === 'ok'){
                $this->Sesion("success","Categoría modificado correctamente!!");
                Pageredirect("categorias");
                exit;
            }else{
                    $this->Sesion("error","Error al modificar categoría!!!");
            }
        }else{
            $this->Sesion("error","Token invalid!!!");
        }

        Pageredirect("categoria/".$id."/editar");
    }


    /**
     * eliminar categoria de la lista (softdelete) => eliminacion suave
     */
    public function eliminar($id){
        if($this->VerifyCsrfToken($this->post("token_"))){
             $response = CategoriaBusines::eliminar($id,$this->FechaActual("Y-m-d H:m:i"));
             
              json(["response" => $response]);
        }else{
           json(["error" => "token-invalid!!"]); 
        }    
    }

    /** ACTIVAR LA CATEGORIA */
    public function activar($id){
        if($this->VerifyCsrfToken($this->post("token_"))){
            json(["response" => CategoriaBusines::ActivarCategoria($id)]);
        }else{
            json(["error_token"=>"token invalid!!"]);
        }
    }

    /** FORZAR ELIMINADO DE LA BASE DE DATOS */
    public function borrar($id){
        if($this->VerifyCsrfToken($this->post("token_"))){
            json(["response" => CategoriaBusines::borrarCategoria($id)]);
        }else{
            json(["error_token"=>"token invalid!!"]);
        }
    }
    
}