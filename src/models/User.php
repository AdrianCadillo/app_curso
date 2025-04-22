<?php 
namespace src\models;

use src\orm\Model;

class User extends Model{ /// users
     protected static String $Table = "usuarios";
     protected static String $primaryKey = 'id_usuario';
     protected static String $Alias = "u";
}