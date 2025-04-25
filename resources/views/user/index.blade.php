@extends(layouts("app"))
@section('title_app','Usuarios')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-dark">
            <div class="card-header bg-dark">
                <h4>Usuario existentes</h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>Acciones</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Foto</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection