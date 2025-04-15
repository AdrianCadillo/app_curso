@extends(layouts("app"))
@section('title_app','Categorias')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white">Categorías existentes</h4>
                </div>

                <div class="card-body">
                    @include(component("alertas"))
                    <a href="{{redirect("categoria/create")}}" class="btn btn-primary mb-2">Agregar uno nuevo +</a>
                    <table class="table table-bordered table-striped table-hover nowrap responsive" id="lista_categorias" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categorias as $categoria)
                                <tr>
                                    <td>{{strtoupper($categoria->nombre_categoria)}}</td>
                                    <td>
                                        <div class="row">
                                            @if ($categoria->deleted_at != null)
                                            <div class="col-auto">
                                               <button class="btn btn-success btn-sm" onclick="ActivarCategoria(`{{$categoria->id_categoria}}`)"><i class="fas fa-check"></i></button>
                                            </div>

                                            <div class="col-auto">
                                              <button class="btn btn-danger btn-sm" onclick="ConfirmaBorradoCategoria(`{{$categoria->nombre_categoria}}`,`{{$categoria->id_categoria}}`)">X</button>
                                            </div>
                                            @else
                                            <div class="col-auto">
                                                <a href="{{redirect("categoria/".$categoria->id_categoria."/editar")}}" class="bnt btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            </div>

                                            <div class="col-auto">
                                                <form action="" method="post">
                                                    <button class="btn btn-danger btn-sm" onclick="event.preventDefault();ConfirmEliminado(`{{$categoria->nombre_categoria}}`,`{{$categoria->id_categoria}}`)"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>   
                                            @endif

                                            <div class="col-auto">
                                                @if ($categoria->deleted_at != null)
                                                    <span class="badge bg-danger">Inhabilitado</span>
                                                    @else 
                                                    <span class="badge bg-success">Habilitado</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
 $(document).ready(function(){
    
    $('#lista_categorias').DataTable({
        language: SpanishDataTable()
    });

 });

 function ConfirmEliminado(nombrecategoria,id){
  Swal.fire({
    title: "Estas seguro de eliminar a la categoría "+nombrecategoria+"?",
    text: "Al aceptar, se quitará de la lista!",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!"
    }).then((result) => {
    if (result.isConfirmed) {
      Eliminar(id)
    }
    });
 }

 function Eliminar(id){
    $.ajax({
        url:RUTA+"categoria/"+id+"/eliminar",
        method:"POST",
        data:{
            token_:TOKEN
        },
        dataType:"json",
        success:function(response){
           if(response.error != undefined){
             Swal.fire({
                title:"MENSAJE DEL SISTEMA!!",
                text:"Token Incorrecto!!",
                icon:"error"
             })
           }else{
            if(response.response === 'ok'){
                Swal.fire({
                    title:"MENSAJE DEL SISTEMA!!",
                    text:"Categoría eliminado correctamente!!",
                    icon:"success"
                }).then(function(){
                    location.href= RUTA+"categorias";
                });
            }else{
                Swal.fire({
                title:"MENSAJE DEL SISTEMA!!",
                text:"Error al eliminar categoría!!",
                icon:"error"
             })
            }
           }
        }
    })
 }

 /// Activar La Categoria
 function ActivarCategoria(id){
    $.ajax({
        url:RUTA+"categoria/"+id+"/activar",
        method:"POST",
        data:{
            token_:TOKEN
        },
        dataType:"json",
        success:function(response){
            if(response.error_token != undefined){
                Swal.fire({
                    title:"Mensaje del sistema!!!",
                    text:"Error, token invalid!!",
                    icon:"error"
                });
            }else{
                if(response.response === 'ok'){
                    Swal.fire({
                    title:"Mensaje del sistema!!!",
                    text:"Categoría habilitado nuevamente!!",
                    icon:"success"
                }).then(function(){
                    location.href = RUTA+"categorias";
                });  
             }else{
                Swal.fire({
                    title:"Mensaje del sistema!!!",
                    text:"Error al activar categoría!",
                    icon:"error"
                }) 
             }
            }
        }
    })
 }

 /*CONFIRMAR BORRADO DE LA CATEGORIA*/
 function ConfirmaBorradoCategoria(nameCategoria,id){
    Swal.fire({
    title: "Estas seguro de borrar a la categoría "+nameCategoria+"?",
    text: "Al aceptar, se borrará de la base de datos, y no podrás recuperar el registro!",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si,borrar!"
    }).then((result) => {
    if (result.isConfirmed) {
       BorrarCategoria(id);
    }
    });
 }

 /*BORRAR CATEGORIA*/
 function BorrarCategoria(id){
    $.ajax({
        url:RUTA+"categoria/"+id+"/borrar",
        method:"POST",
        data:{
            token_:TOKEN
        },
        dataType:"json",
        success:function(response){
            if(response.error_token != undefined){
                Swal.fire({
                    title:"Mensaje del sistema!!!",
                    text:"Error, token invalid!!",
                    icon:"error"
                });
            }else{
                if(response.response === 'ok'){
                    Swal.fire({
                    title:"Mensaje del sistema!!!",
                    text:"Categoría eliminado correctamente!!!",
                    icon:"success"
                }).then(function(){
                    location.href = RUTA+"categorias";
                });  
             }else{
                Swal.fire({
                    title:"Mensaje del sistema!!!",
                    text:"Error al borrar categoría!",
                    icon:"error"
                }) 
             }
            }
        }
    })
 }
</script>
@endsection
