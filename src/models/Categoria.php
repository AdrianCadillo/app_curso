<?php
namespace src\models;

use src\orm\Model;

class Categoria extends Model{

    //protected static String $Table = "categorias";
    protected static String $primaryKey = 'id_categoria';
    protected static String $Alias = "c";
}