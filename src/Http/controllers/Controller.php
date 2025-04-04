<?php
namespace src\Http\controllers;

use src\Http\lib\Csrf;
use src\Http\lib\Request;

abstract class Controller{
    use Request,Csrf;
}