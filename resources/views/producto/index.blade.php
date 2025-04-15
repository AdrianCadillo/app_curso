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
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                        <label for="precio" class="form-label"><b>Precio <span class="text-danger">*</span></b></label>
                        <input type="text" id="precio" name="precio" class="form-control" placeholder="Precio producto...."> 
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                        <label for="stock" class="form-label"><b>Stock <span class="text-danger">*</span></b></label>
                        <input type="text" id="stock" name="stock" class="form-control" placeholder="Stock producto...."> 
                    </div>

                    <div class="col-12">
                        <label for="categoria" class="form-label"><b>Categoría</b></label>
                        <select name="categoria" id="categoria" class="form-select"></select>
                    </div>

                    <div class="col-12">
                        <label for="descripcion" class="form-label"><b>Descripción</b></label>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control" placeholder="Escriba aquí la descripcíon(Opcional)"></textarea>
                    </div>

                    <div class="col-12 text-center">
                        <img src="{{assets("dist/img/defecto.png")}}" alt="" style="width: 120px;height: 120px;">
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
@endsection

@section('js')
<script src="{{assets("busines/control.js")}}"></script>
 <script>
  var RUTA = "{{BASE_URL}}";
  var TOKEN = "{{$this->Csrf_Token()}}"
  var TablaProductos;

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

   $('#save_producto').click(function(){
     saveProducto();
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
                return  `<img src='#'>`;
            }

            return `<img src="{{assets("dist/img/defecto.png")}}" style="width:80px;height:80px">`;
        }},
        {"data":"nombre_producto",render:function(productodata){
            return productodata.toUpperCase();
        }},
        {"data":"deleted_at",render:function(estado){
            return estado != null ? '<span class="badge bg-danger">Inhabilitado</span>' : '<span class="badge bg-success">Habilitado</span>' 
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
   }).ajax.reload()
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
            console.log(response);
        }
    })
 }
 </script>
@endsection