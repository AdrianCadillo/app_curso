<?php

use Windwalker\Edge\Edge;
use Windwalker\Edge\Loader\EdgeFileLoader;

/**
 * Método para mostrar todas las vistas
 */
function View_(String $fileView,array $datos=[]){

    // DIECTORIO DE LAS VISTAS
    $DirectorioView = str_replace(".","/","resources.views.".$fileView);
 
    /// obtenemos la extension del archivo
    $FileExtension = file_exists($DirectorioView.".blade.php") ? '.blade.php' : '.php';

    if(file_exists($DirectorioView.$FileExtension)){
        $EdgeView = new Edge(new EdgeFileLoader());

        echo $EdgeView->render($DirectorioView.$FileExtension,$datos);
    }else{
        echo "ERROR 404 NOT FOUND!!!";
    }

}


/** PARA ACCEDER A LAS VARIABLES DE ENTORNO */

function env(String $Name, String $DefectValue = '')
{
    return isset($_ENV[$Name]) ? $_ENV[$Name] : $DefectValue;
}

/**
 * ASSETS
 */
function assets(String $fileAssets){
 return env("URLBASE")."assets/".$fileAssets;
}