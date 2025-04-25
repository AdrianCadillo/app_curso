
/// REALIZA LOGIN
$('#realizar_login').click(function(evento){
 evento.preventDefault();
 HacerLogin();
});

$('#login').focus();
/// keypress
$('#login').keypress(function(evento){
 if(evento.which == 13){
    evento.preventDefault();
    if($(this).val().trim().length == 0){
        $(this).focus();
    }else{
        $('#password').focus();
    }
 }
});


$('#password').keypress(function(evento){
    if(evento.which == 13){
       evento.preventDefault();
       if($(this).val().trim().length == 0){
           $(this).focus();
       }else{
          HacerLogin();
       }
    }
});

/// PROCESO DE LOGIN
function HacerLogin(){
let FormHacerLogin = new FormData(document.getElementById("form_login"));

    axios({
        url:RUTA+"hacer-login",
        method:"POST",
        data:FormHacerLogin
    }).then(function(response){
         if(response.data.error != undefined){
            Swal.fire({
                title:"MENSAJE DEL SISTEMA!!",
                text:response.data.error,
                icon:"error"
            });
         }else{
            Swal.fire({
                title:"MENSAJE DEL SISTEMA!!",
                text:"BIENVENIDO AL SISTEMA!!!",
                icon:"success"
            }).then(function(){
                location.href = RUTA+"dashboard";
            });
         }
    });
}