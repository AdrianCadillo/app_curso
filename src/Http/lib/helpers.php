<?php

use Windwalker\Edge\Edge;
use Windwalker\Edge\Loader\EdgeFileLoader;

/**
 * Método para mostrar todas las vistas
 */
function View_(String $fileView,array $datos=[]){

    // DIECTORIO DE LAS VISTAS
    $DirectorioView = str_replace(".","/",APP_DIRECTORIO_VIEWS.$fileView);
 
    /// obtenemos la extension del archivo
    $FileExtension = file_exists($DirectorioView.".blade.php") ? '.blade.php' : '.php';

    if(file_exists($DirectorioView.$FileExtension)){
        $EdgeView = new Edge(new EdgeFileLoader());

        echo $EdgeView->render($DirectorioView.$FileExtension,$datos);
    }else{
        echo "ERROR 404 NOT FOUND!!!";
    }

}