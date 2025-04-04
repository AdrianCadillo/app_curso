<?php
namespace src\orm;

interface Orm{

    /** PARA CONSULTAR DATOS */
    public static function get();
    /** SELECCIONAR COLUMNAS */
    public static function select();
}