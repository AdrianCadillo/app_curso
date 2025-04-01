<?php

use Windwalker\Edge\Edge;
use Windwalker\Edge\Loader\EdgeFileLoader;

/**
 * Método para mostrar todas las vistas
 */
function View_(String $fileView,array $datos=[]){

    // DIECTORIO DE LAS VISTAS
    $DirectorioView = str_replace(".","/",APP_DIRECTORIO_VIEWS.$fileView).".blade.php";

    if(file_exists($DirectorioView)){
        $EdgeView = new Edge(new EdgeFileLoader());

        echo $EdgeView->render($DirectorioView,$datos);
    }else{
        echo "ERROR 4040 NOT FOUND!!!";
    }


}