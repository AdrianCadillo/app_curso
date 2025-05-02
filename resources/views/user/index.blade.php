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
                <button class="btn btn-primary mb-2" id="create_user">Agregar uno nuevo +</button>
                <table class="table table-bordered table-striped table-hover nowrap responsive"
                id="gestion_users">
                    <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{--CREAR NUEVOS USUARIOS---}}
<div class="modal fade" id="modal_create_user" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar usuarios</h5>
            </div>

            <div class="modal-body">
                <form action="" method="post" id="form_save_user">
                    <input type="hidden" name="token_" value="{{$this->Csrf_Token()}}">
                    <div class="form-group">
                        <label for="username" class="form-label"><b>NOMBRE DE USUARIO <span class="text-danger">*</span></b></label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Nombre de usuario...."> 
                        <span id="error_username" class="text-danger"></span>
                     </div>

                    <div class="form-group">
                        <label for="email" class="form-label"><b>CORREO ELECTRÓNICO <span class="text-danger">*</span></b></label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Email de usuario...."> 
                        <span id="error_email" class="text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label"><b>PASSWORD <span class="text-danger">*</span></b></label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="PASSWORD...."> 
                        <span id="error_password" class="text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label for="rol" class="form-label"><b>ROL<span class="text-danger">*</span></b></label>
                        <select name="rol" id="rol" class="form-select">
                            <option value="a">ADMINISTRADOR</option>
                            <option value="u">CLIENTE</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="foto" class="form-label"><b>SELECCIONE UNA FOTO <span class="text-danger">*</span></b></label>
                        <input type="file" id="foto" name="foto" class="form-control"> 
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="save_user">Guardar</button>
                <button class="btn btn-danger" id="cerrar">Salir</button>
            </div>
        </div>
    </div>
</div>

{{--EDITAR USUARIOS---}}
<div class="modal fade" id="modal_editar_user" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Editar usuario</h5>
            </div>

            <div class="modal-body">
                <form action="" method="post" id="form_update_user">
                    <input type="hidden" name="token_" value="{{$this->Csrf_Token()}}">
                    <div class="form-group">
                        <label for="username_editar" class="form-label"><b>NOMBRE DE USUARIO <span class="text-danger">*</span></b></label>
                        <input type="text" id="username_editar" name="username_editar" class="form-control" placeholder="Nombre de usuario...."> 
                        <span id="error_username_editar" class="text-danger"></span>
                     </div>

                    <div class="form-group">
                        <label for="email_editar" class="form-label"><b>CORREO ELECTRÓNICO <span class="text-danger">*</span></b></label>
                        <input type="text" id="email_editar" name="email_editar" class="form-control" placeholder="Email de usuario...."> 
                        <span id="error_email_editar" class="text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label for="rol_editar" class="form-label"><b>ROL<span class="text-danger">*</span></b></label>
                        <select name="rol_editar" id="rol_editar" class="form-select">
                            <option value="a">ADMINISTRADOR</option>
                            <option value="u">CLIENTE</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="foto_editar" class="form-label"><b>SELECCIONE UNA FOTO <span class="text-danger">*</span></b></label>
                        <input type="file" id="foto_editar" name="foto_editar" class="form-control"> 
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="update_user">Guardar</button>
                <button class="btn btn-danger" id="cerrar_editar">Salir</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{assets("busines/users.js")}}"></script>
<script>
 var TablaGestionUsers;
 var RUTA = "{{BASE_URL}}";
 var TOKEN = "{{$this->Csrf_Token()}}"
 var USERID;
 $(document).ready(function(){

    /// MOSTRAR A LOS USUARIOS
    showUsers();


    /// CREAR USUARIO
    $('#create_user').click(function(){
        $('#modal_create_user').modal("show");
    });

    /// CERRAR LA VENTANA MODAL DE CREAR USUARIOS
    $('#cerrar').click(function(){
        $('#modal_create_user').modal("hide");
        $('#form_save_user')[0].reset();
    });

    $('#cerrar_editar').click(function(){
        $('#modal_editar_user').modal("hide");
        USERID = null;
        $('#form_update_user')[0].reset();
    });

    /// GUARDAR USUARIO
    $('#save_user').click(function(){
        saveUser();
    });

    $('#update_user').click(function(){
        updateUser(USERID);
    });
 });
 
</script>
@endsection