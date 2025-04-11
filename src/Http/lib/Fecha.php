<?php
namespace src\Http\lib;

trait Fecha{

    /** RETORNAR LA FECHA ACTUAL */
    public function FechaActual(String $Formato){
        date_default_timezone_set(TIME_ZONE);

        return date($Formato);
    }
}