<?php
namespace src\Http\controllers;

use src\Http\business\ProductoBusines;
use src\Http\lib\Upload;
use src\models\Categoria;
use src\models\Producto;

class ProductoController extends Controller{

    use Upload;
    private array $Errors = [];
    /** METODO PARA MOSTRAR LA PÁGINA PRINCIPAL DE PRODUCTOS */
    public function index(){

        $this->NoAuth();
        $categorias = Categoria::get();
        View_("producto.index",compact("categorias"));
    }

    /** MOSTRAR LOS PRODUCTOS DE LA BASE DE DATOS */
    public function mostrar(){
        //$this->NoAuth();
        $productos = Producto::
                  select("cat.id_categoria","cat.nombre_categoria","p.id_producto","p.nombre_producto","p.precio",
                  "p.stock","p.descripcion","p.imagen","p.deleted_at")
                  ->Join("categorias as cat","p.id_categoria","=","cat.id_categoria")
                     ->get();

        json(["productos" => $productos]);
    }

    /** Registrar un producto*/
    public function store(){
        if($this->VerifyCsrfToken($this->post("token_"))){


            if($this->post("nombre_producto") == null){
                $this->Errors["nombre_producto"] = "Ingrese nombre del producto!";
            }

            if($this->post("precio") == null){
                $this->Errors["precio"] = "Ingrese precio del producto!";
            }

            if($this->post("stock") == null){
                $this->Errors["stock"] = "Ingrese el stock del producto!";
            }

            if(count($this->Errors) > 0){
                json(["errors" => $this->Errors]);
                exit;
            }

            $this->setNameFile("img_producto");
            $this->setDestino("assets/img/productos/");

            $ResponseUpload = $this->UploadFile();

            json(["response" => ProductoBusines::RegistrarProducto(
                $this->post("nombre_producto"),
                $this->post("descripcion"),
                $this->post("precio"),
                $this->post("stock"),
                $this->post("categoria"),
                $this->getNombreDelArchivo()
            )]);
        }else{
            json(["error" => "token invalid!!"]);
        }
    }

    /**
     * Modificar
     */
    public function updateProducto($id){
        if($this->VerifyCsrfToken($this->post("token_"))){

            $this->setNameFile("img_producto_editar");
            $this->setDestino("assets/img/productos/");

            $ResponseUpload = $this->UploadFile(); /// ok -vacio -noaccept -error

            $producto = Producto::Where("id_producto","=",$id)->get();

            if($ResponseUpload != 'vacio' && $ResponseUpload != 'no-accept'){

                if($producto[0]->imagen != null){
                    $pathImg = "assets/img/productos/".$producto[0]->imagen;
                    unlink($pathImg);
                }
            }else{
                $this->setNombreDelArchivo($producto[0]->imagen);
            }

            json(["response" => ProductoBusines::ModificarProducto(
                $id,
                $this->post("nombre_producto_editar"),
                $this->post("descripcion_editar"),
                $this->post("precio_editar"),
                $this->post("stock_editar"),
                $this->post("categoria_editar"),
                $this->getNombreDelArchivo()
            )]);

        }else{
            json(["error" => "token invalid!!"]);
        }    
    }


    /** ELIMINAR  */
    public function eliminar($id){
        if($this->VerifyCsrfToken($this->post("token_"))){
            $response = ProductoBusines::EliminarProducto($id,$this->FechaActual("Y-m-d H:i:s"));
            json(["response" => $response]);
        }else{
            json(["error" => "token invalid!!!"]);
        }    
    }
}