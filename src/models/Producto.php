<?php
namespace src\models;

use src\orm\Model;

class Producto extends Model{
    
    protected static String $Table = "productos";
    protected static String $Alias = "p";
 
    protected static String $primaryKey = 'id_producto';
}