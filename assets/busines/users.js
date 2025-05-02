
/// MOSTRAR A LOS USUARIOS
function showUsers(){
    TablaGestionUsers = $("#gestion_users").DataTable({
      retrieve: true,
      ajax: {
        url: RUTA + "mostrar-usuarios",
        method: "GET",
        dataSrc: "users",
      },
      columns: [
        {
          data: null,
          render: function () {
            return `<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    Acciones
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="#"><b class="text-warning" id="editar">Editar</b></a></li>
    <li><a class="dropdown-item" href="#"><b class="text-danger" id="eliminar">Eliminar</b></a></li>
  </ul>
</div>`;
          },
        },
        { data: "username",render:function(username){
            return username.toUpperCase();
        }},
        { data: "email",render:function(correo){
            return correo.toUpperCase();
        }},
        { data: "rol",render:function(role){
            return role === 'a' ? '<b>ADMINISTARDOR</b>' : '<b>CLIENTE</b>'
        }},
        { data: "estado",render:function(estado){
            return estado === 'a' ? '<span class="badge bg-success">HABILITADO</span>' : '<span class="badge bg-danger">DESHABILITADO</span>' 
        }},
        { data: "foto",render:function(img){
            let Foto = '';
            if(img != null){
                Foto = RUTA+'assets/img/users/'+img;
            }else{
                Foto = RUTA+'assets/dist/img/useranonimo.png';
            }

            return '<img src="'+Foto+'" style="width:65px;border-radius:50%">';
        }},
      ],
    }).ajax.reload();
    ConfirmEliminadoUser(TablaGestionUsers,'#gestion_users tbody');
    EditarUser(TablaGestionUsers,'#gestion_users tbody');
}



//EDITAR AL USUARIO
function EditarUser(Tabla,Tbody){
    $(Tbody).on('click','#editar',function(){
        // fila seleccionada
        let fila = $(this).parents("tr");

        if(fila.hasClass("child")){
            fila = fila.prev();
        }

        $('#modal_editar_user').modal("show");
        let Data = Tabla.row(fila).data();

        $('#username_editar').val(Data.username);
        $('#email_editar').val(Data.email);
        $('#rol_editar').val(Data.rol);

        USERID = Data.id_usuario;
    });
}

// modificar los datos del usuario
function updateUser(id){
    let FormUpdateUser = new FormData(document.getElementById("form_update_user"));
    axios({
        url:RUTA+"user/update/"+id,
        method:"POST",
        data:FormUpdateUser
    }).then(function(response){
        if(response.data.error != undefined){
            Swal.fire({
                title:"MENSAJE DEL SISTEMA!!!",
                text:response.data.error,
                icon:"error"
            });
        }else{
            Swal.fire({
                title:"MENSAJE DEL SISTEMA!!!",
                text:response.data.success,
                icon:"success"
            }).then(function(){
                showUsers();
            }); 
        }
    });
}




/// CONFIRMAR ANTES DE ELIMINAR AL USUARIO
function ConfirmEliminadoUser(Tabla,Tbody){
 $(Tbody).on('click','#eliminar',function(){
    /// obtener la fila seleccionada
    let fila = $(this).parents("tr");

    if(fila.hasClass("child")){
        fila = fila.prev();
    }

    let Data = Tabla.row(fila).data();

    let NombreUser = Data.username;

    USERID = Data.id_usuario;

    Swal.fire({
        title: "Estas seguro de eliminar?",
        text: "Deseas eliminar al usuario "+NombreUser+"?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!"
      }).then((result) => {
        if (result.isConfirmed) {
         EliminarUsuario(USERID);
        }
      });
 });
}

/// ELIMINAR USUARIO
function EliminarUsuario(id){
    let FormDeleteUser = new FormData();
    FormDeleteUser.append("token_",TOKEN);
    axios({
        url:RUTA+"user/"+id+"/delete",
        method:"POST",
        data:FormDeleteUser
    }).then(function(response){
        if(response.data.error != undefined){
            Swal.fire({
                title:"MENSAJE DEL SISTEMA!!!",
                text:response.data.error,
                icon:"error"
            });
        }else{
            Swal.fire({
                title:"MENSAJE DEL SISTEMA!!!",
                text:response.data.success,
                icon:"success"
            }).then(function(){
                showUsers();
            }); 
        }
    });
}


/// REGISTRAR USUARIO
function saveUser(){
    let FormUserSave = new FormData(document.getElementById('form_save_user'));
    axios({
        url:RUTA+"user/save",
        method:"POST",
        data:FormUserSave
    }).then(function(response){

        if(response.data.errors != undefined){

            if(response.data.errors.username != undefined){
                $('#error_username').text(response.data.errors.username);
            }else{
                $('#error_username').text(""); 
            }

            if(response.data.errors.email != undefined){
                $('#error_email').text(response.data.errors.email);
            }else{
                $('#error_email').text(""); 
            }

            if(response.data.errors.password != undefined){
                $('#error_password').text(response.data.errors.password);
            }else{
                $('#error_password').text(""); 
            }

            return;
        }


        if(response.data.error != undefined){
            Swal.fire({
                title:"MENSAJE DEL SISTEMA!!!",
                text:response.data.error,
                icon:"error"
            });
        }else{
            Swal.fire({
                title:"MENSAJE DEL SISTEMA!!!",
                text:response.data.response,
                icon:"success"
            }).then(function(){
                showUsers();
                $('#form_save_user')[0].reset();
            }); 
        }
    });
}