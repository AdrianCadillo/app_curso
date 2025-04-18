@extends(layouts("app"))
@section('title_app','Productos')

@section('content')
 <div class="row">
    <div class="col-12">
        <div class="card border border-dark">
            <div class="card-header bg-dark">
                <h4 class="text-white">Catálogo de productos</h4>
            </div>

            <div class="card-body">
                <button class="btn btn-primary mb-2" id="abrir_venta_crear_producto"> Agregar uno nuevo <i class="fas fa-plus"></i></button>
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-striped nowrap responsive" id="lista_productos" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Categoría</th>
                                <th>Imágen</th>
                                <th>Producto</th>
                                <th>Estado</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
 </div>
 {{-- CREAR UN PRODUCTO---}}
 <div class="modal fade" id="create_producto">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Crear producto</h4>
            </div>

            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="form_producto">
                    <input type="hidden" name="token_" value="{{$this->Csrf_Token()}}">
                  <div class="row">
                     <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                        <label for="nombre_producto" class="form-label"><b>Nombre producto <span class="text-danger">*</span></b></label>
                        <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" placeholder="Nombre producto...."> 
                        <span class="text-danger" id="error_nombre_producto"></span>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                        <label for="precio" class="form-label"><b>Precio <span class="text-danger">*</span></b></label>
                        <input type="text" id="precio" name="precio" class="form-control" placeholder="Precio producto...."> 
                        <span class="text-danger" id="error_precio"></span>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                        <label for="stock" class="form-label"><b>Stock <span class="text-danger">*</span></b></label>
                        <input type="text" id="stock" name="stock" class="form-control" placeholder="Stock producto...."> 
                        <span class="text-danger" id="error_stock"></span>
                    </div>

                    <div class="col-12">
                        <label for="categoria" class="form-label"><b>Categoría</b></label>
                        <select name="categoria" id="categoria" class="form-select">
                            @foreach ($categorias as $category)
                                <option value="{{$category->id_categoria}}">{{strtoupper($category->nombre_categoria)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="descripcion" class="form-label"><b>Descripción</b></label>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control" placeholder="Escriba aquí la descripcíon(Opcional)"></textarea>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <img src="{{assets("dist/img/defecto.png")}}" id="img_preview_producto" alt="" style="width: 120px;height: 120px;">
                    </div>

                    <div class="col-12 mt-1 text-center">
                        <input type="file" name="img_producto" id="img_producto" style="display: none">
                        <button class="btn btn-primary" id="upload_file"><b>Subir imágen  <i class="fas fa-upload"></i></b></button>
                    </div>
                  </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="save_producto">Guardar  <i class="fas fa-save"></i></button>
            </div>
        </div>
    </div>
 </div>
 {{-- MODAL PARA EDITAR EL PRODUCTOS---}}
 <div class="modal fade" id="editar_producto">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Editar producto</h4>
            </div>

            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="form_producto_editar">
                    <input type="hidden" name="token_" value="{{$this->Csrf_Token()}}">
                  <div class="row">
                     <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                        <label for="nombre_producto_editar" class="form-label"><b>Nombre producto <span class="text-danger">*</span></b></label>
                        <input type="text" id="nombre_producto_editar" name="nombre_producto_editar" class="form-control" placeholder="Nombre producto...."> 
                     </div>

                    <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                        <label for="precio_editar" class="form-label"><b>Precio <span class="text-danger">*</span></b></label>
                        <input type="text" id="precio_editar" name="precio_editar" class="form-control" placeholder="Precio producto...."> 
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                        <label for="stock_editar" class="form-label"><b>Stock <span class="text-danger">*</span></b></label>
                        <input type="text" id="stock_editar" name="stock_editar" class="form-control" placeholder="Stock producto...."> 
                    </div>

                    <div class="col-12">
                        <label for="categoria_editar" class="form-label"><b>Categoría</b></label>
                        <select name="categoria_editar" id="categoria_editar" class="form-select">
                            @foreach ($categorias as $category)
                                <option value="{{$category->id_categoria}}">{{strtoupper($category->nombre_categoria)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="descripcion_editar" class="form-label"><b>Descripción</b></label>
                        <textarea name="descripcion_editar" id="descripcion_editar" cols="30" rows="5" class="form-control" placeholder="Escriba aquí la descripcíon(Opcional)"></textarea>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <img src="{{assets("dist/img/defecto.png")}}" id="img_preview_producto_editar" alt="" style="width: 120px;height: 120px;">
                    </div>

                    <div class="col-12 mt-1 text-center">
                        <input type="file" name="img_producto_editar" id="img_producto_editar" style="display: none">
                        <button class="btn btn-primary" id="upload_file_editar"><b>Subir imágen  <i class="fas fa-upload"></i></b></button>
                    </div>
                  </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="update_producto">Guardar cambios <i class="fas fa-save"></i></button>
            </div>
        </div>
    </div>
 </div>
@endsection

@section('js')
<script src="{{assets("busines/control.js")}}"></script>
 <script>
  var RUTA = "{{BASE_URL}}";
  var TOKEN = "{{$this->Csrf_Token()}}"
  var TablaProductos;
  var ProductoId;

 $(document).ready(function(){
   MostrarProductos();


   /// Crear producto
   $('#abrir_venta_crear_producto').click(function(){
     $('#create_producto').modal("show");
   });


   $('#upload_file').click(function(evento){
    evento.preventDefault();
    
     $('#img_producto').click();
   });

   $('#upload_file_editar').click(function(evento){
     evento.preventDefault();
    
     $('#img_producto_editar').click();
   })

   $('#save_producto').click(function(){
     saveProducto();
   });

   // actualizar
   $('#update_producto').click(function(){
     ModificarProducto(ProductoId)
   });

   $('#img_producto').change(function(evento){
       
    PreviewImg(evento,'img_preview_producto'); 
   });

   $('#img_producto_editar').change(function(evento){
       
       PreviewImg(evento,'img_preview_producto_editar'); 
   });
 });

 /// METODO PARA MOSTRAR LOS PRODUCTOS EN EL DATATABLE
 function MostrarProductos(){
   TablaProductos = $('#lista_productos').DataTable({
     language:SpanishDataTable(),
     retrieve:true,
     ajax:{
        url:RUTA+"productos/all",
        method:"GET",
        dataSrc:"productos"
     },
     columns:[
        {"data":null,render:function(dato){
            if(dato.deleted_at == null){
                return `
             <div class="row">
                <div class="col-auto">
                  <button class="btn btn-warning btn-sm" id="editar"><i class="fas fa-edit"></i></button>    
                </div>
                <div class="col-auto">
                  <button class="btn btn-danger btn-sm" id="eliminar"><i class="fas fa-trash-alt"></i></button>    
                </div>
             </div>
            `;
            }
            return `
             <div class="row">
                <div class="col-auto">
                  <button class="btn btn-success btn-sm" id="activar"><i class="fas fa-check"></i></button>    
                </div>
                <div class="col-auto">
                  <button class="btn btn-danger btn-sm" id="borrar"><b>X</b></button>    
                </div>
             </div>
            `;
        }},
        {"data":"nombre_categoria",render:function(namecategoria){
            return namecategoria.toUpperCase()
        }},
        {"data":"imagen",render:function(img){
            if(img != null){
                DirectorioImgen = "{{assets('img/productos/')}}";
                return  `<img src="`+DirectorioImgen+img+`" style="width:80px;height:80px">`;
            }

            return `<img src="{{assets("dist/img/defecto.png")}}" style="width:80px;height:80px">`;
        }},
        {"data":"nombre_producto",render:function(productodata){
            return productodata.toUpperCase();
        }},
        {"data":"deleted_at",render:function(estado){
            return estado !== null ? '<span class="badge bg-danger">Inhabilitado</span>' : '<span class="badge bg-success">Habilitado</span>' 
        }},
        {"data":"descripcion"},
        {"data":"precio",render:function(precio){
            return "<b>S/."+precio+"</b>";
        }},
        {"data":"stock",render:function(stock){
            if(stock > 5){
                return '<span class="badge bg-primary">'+stock+'</span>';
            }

            return '<span class="badge bg-danger">'+stock+'</span>';
        }}
     ]
   }).ajax.reload();

   Editar(TablaProductos,'#lista_productos tbody');
   ConfirmEliminadoProducto(TablaProductos,'#lista_productos tbody');
 }

 function saveProducto(){
    let FormProducto = new FormData(document.getElementById('form_producto'));
    $.ajax({
        url:RUTA+"producto/store",
        method:"POST",
        data:FormProducto,
        dataType:"json",
        contentType:false,
        processData:false,
        success:function(response){

            if(response.errors != undefined){

                if(response.errors.nombre_producto != undefined){
                    $('#error_nombre_producto').text(response.errors.nombre_producto);
                }else{
                    $('#error_nombre_producto').text("");
                }

                if(response.errors.precio != undefined){
                    $('#error_precio').text(response.errors.precio);
                }else{
                    $('#error_precio').text("");
                }

                if(response.errors.stock != undefined){
                    $('#error_stock').text(response.errors.stock);
                }else{
                    $('#error_stock').text("");
                }
                return;
            }


            if(response.error != undefined){
                Swal.fire({
                    title:"MENSAJE DEL SISTEMA!!!",
                    text:"Error, token invalid!!",
                    icon:"error"
                });
            }else{
                if(response.response === 'ok'){
                    Swal.fire({
                    title:"MENSAJE DEL SISTEMA!!!",
                    text:"Producto registrado correctamente!!",
                    icon:"success"
                }).then(function(){
                    MostrarProductos();
                    $('#form_producto')[0].reset();
                    $('#img_preview_producto').attr("src","{{assets('dist/img/defecto.png')}}");
                });  
              }else{
                Swal.fire({
                    title:"MENSAJE DEL SISTEMA!!!",
                    text:"Error al registrar producto!!!",
                    icon:"error"
                });
              }
            }
        }
    })
 }

 /// modificar
 function ModificarProducto(id){

    let FormProductoEditar = new FormData(document.getElementById('form_producto_editar'));
    axios({
        url:RUTA+"producto/"+id+"/update",
        method:"POST",
        data:FormProductoEditar
    }).then(function(mensaje){
        if(mensaje.data.error != undefined){
                Swal.fire({
                    title:"MENSAJE DEL SISTEMA!!!",
                    text:"Error, token invalid!!",
                    icon:"error"
                });
            }else{
                if(mensaje.data.response === 'ok'){
                    Swal.fire({
                    title:"MENSAJE DEL SISTEMA!!!",
                    text:"Producto modificado correctamente!!",
                    icon:"success"
                }).then(function(){
                    MostrarProductos();
                    $('#editar_producto').modal("hide");
                });  
              }else{
                Swal.fire({
                    title:"MENSAJE DEL SISTEMA!!!",
                    text:"Error al modificar producto!!!",
                    icon:"error"
                });
              }
            }
    });
 }

 /*EDITAR LOS PRODUCTOS*/
 function Editar(Tabla,Tbody){
    $(Tbody).on('click','#editar',function(){
        /// obtenemos la fila
        let fila = $(this).parents("tr");

        if(fila.hasClass("child")){
            fila = fila.prev();
        }

        let Data = Tabla.row(fila).data();

       $('#editar_producto').modal("show");
       $('#nombre_producto_editar').val(Data.nombre_producto);
       $('#precio_editar').val(Data.precio);
       $('#stock_editar').val(Data.stock);
       $('#categoria_editar').val(Data.id_categoria);
       $('#descripcion_editar').val(Data.descripcion);
       ProductoId = Data.id_producto;
       
       Data.imagen != null ? $('#img_preview_producto_editar').attr("src","{{assets('img/productos/')}}"+Data.imagen)
                           : $('#img_preview_producto_editar').attr("src","{{assets('dist/img/defecto.png')}}")

    });
 }

 /// CONFIRMAR ELIMINADO DEL PRODUCTO
 function ConfirmEliminadoProducto(Tabla,Tbody){
    $(Tbody).on('click','#eliminar',function(){
        /// obtenemos la fila
        let fila = $(this).parents("tr");

        if(fila.hasClass("child")){
            fila = fila.prev();
        }

        let Data = Tabla.row(fila).data();
        ProductoId = Data.id_producto;
  Swal.fire({
        title: "Estas seguro de eliminar al producto "+Data.nombre_producto+"?",
        text: "Al aceptar, el producto ya no estará disponible para el proceso de ventas!!",
        icon: "qustion",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!"
        }).then((result) => {
        if (result.isConfirmed) {
           EliminarProducto(ProductoId);
        }
        });
    });
 }

 /// ELIMINAR
 function EliminarProducto(id){
    let FormDelete = new FormData();
    FormDelete.append("token_",TOKEN);
    axios({
        url:RUTA+"producto/"+id+"/eliminar",
        method:"POST",
        data:FormDelete
    }).then(function(response){
        if(response.data.error != undefined){
            Swal.fire({
                title:"Mensaje del sistema!!",
                text:response.data.error,
                icon:"error"
            })
        }else{
            if(response.data.response === 'ok'){
                Swal.fire({
                title:"Mensaje del sistema!!",
                text:"Producto eliminado correctamente!!",
                icon:"success"
               }).then(function(){
                 MostrarProductos();
               }) ;
            }else{
                Swal.fire({
                title:"Mensaje del sistema!!",
                text:"Error al eliminar producto",
                icon:"error"
            })  
            }
        }
    })
 }
 </script>
@endsection