@extends(layouts("app"))
@section('title_app','Crear categoría')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white">Crear categoría</h4>
            </div>

            <div class="card-body">
                @include(component("alertas"))
               <form action="{{redirect("categoria/save")}}" method="post" id="save_categoria">
                  <input type="hidden" name="token_" value="{{$this->Csrf_Token()}}">
                  <input type="text" name="nombre_categoria" class="form-control" placeholder="Nombre de la categoría....">
               </form>
            </div>
            <div class="card-footer">
                <button class="btn btn-success" form="save_categoria">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection