/**
 * Método para convertir a español un DataTable
 */
function SpanishDataTable(){
    return {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
}

/**
 * Preview de la imagen al seleccionarlo
 */
function PreviewImg(evento,idImagen){
    let Archivo = evento.target.files[0]; /// nombreimagen.jpg
      let Extension = Archivo.name.split(".")[1];
      
      ExtensionesAceptables = ["png","jpg","jpeg"];

      if(ExtensionesAceptables.indexOf(Extension) == -1){
        Swal.fire({
            title:"Mensaje del sistema!!",
            text:"El archivo seleccionado no es correcto, solo se aceptan los tipos de archivo "+ExtensionesAceptables.join("-"),
            icon:"error"
        }).then(function(){
            $('#'+idImagen).attr("src","{{assets('dist/img/defecto.png')}}");
        });
      }else{
        $('#'+idImagen).attr("src",URL.createObjectURL(Archivo));
    }
}