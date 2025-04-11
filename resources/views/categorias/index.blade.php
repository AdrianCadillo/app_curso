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
                    <table class="table table-bordered table-striped table-hover">
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
                                            <div class="col-auto">
                                                <a href="{{redirect("categoria/".$categoria->id_categoria."/editar")}}" class="bnt btn-warning btn-sm">editar</a>
                                            </div>

                                            <div class="col-auto">
                                                <form action="" method="post">
                                                    <button class="btn btn-danger btn-sm" onclick="event.preventDefault();ConfirmEliminado(`{{$categoria->nombre_categoria}}`,`{{$categoria->id_categoria}}`)">eliminar</button>
                                                </form>
                                            </div>

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
<script>
  var RUTA = "{{BASE_URL}}";
  var TOKEN = "{{$this->Csrf_Token()}}"
 $(document).ready(function(){
    
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
</script>
@endsection
