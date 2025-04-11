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

function component(String $fileComponent){

    $DirectorioComponents = str_replace(".","/","resources.views.components.".$fileComponent);
    $extension = file_exists($DirectorioComponents.".blade.php") ? ".blade.php" : ".php";
     
    if(file_exists($DirectorioComponents.".blade.php") || file_exists($DirectorioComponents.".php")){
      return  $DirectorioComponents.$extension;
    }
}

function layouts(String $fileComponent){

    $DirectorioLayout = str_replace(".","/","resources.views.layouts.".$fileComponent);
    $extension = file_exists($DirectorioLayout.".blade.php") ? ".blade.php" : ".php";
     
    if(file_exists($DirectorioLayout.".blade.php") || file_exists($DirectorioLayout.".php")){
      return  $DirectorioLayout.$extension;
    }
}


function Pageredirect(String $PageRedirect="#"){

    header("location:".BASE_URL.$PageRedirect);
}

function redirect(string $redirect="#"){
    return BASE_URL.$redirect;
}

/**
 * No devuelve la respuesta en un formato json
 */

function json(array $dato,int $CodeResponse = 200){
    http_response_code($CodeResponse);

    echo json_encode($dato);
}