@extends(layouts("app"))
@section('title_app','Editar categoría')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white">Editar categoría</h4>
            </div>

            <div class="card-body">
                @include(component("alertas"))
               <form action="{{redirect("categoria/".$categoria[0]->id_categoria."/update")}}" method="post" id="udpate_categoria">
                  <input type="hidden" name="token_" value="{{$this->Csrf_Token()}}">
                  <input type="text" name="nombre_categoria" class="form-control" placeholder="Nombre de la categoría...."
                  value="{{$categoria[0]->nombre_categoria}}">
               </form>
            </div>
            <div class="card-footer">
                <button class="btn btn-success" form="udpate_categoria">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection