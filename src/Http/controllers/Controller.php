<?php
namespace src\Http\controllers;

use src\Http\lib\AuthUser;
use src\Http\lib\Csrf;
use src\Http\lib\Fecha;
use src\Http\lib\Request;
use src\Http\lib\Session;

abstract class Controller{
    use Request,Csrf,Session,Fecha,AuthUser;
}