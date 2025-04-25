<?php 
namespace src\Http\controllers;

class HomeController extends Controller{

    /**
     * MÉTODO QUE VISUALIZA LA PARTE PRINCIPAL DEL SISTEMA
     */
    public function home(){
        $this->NoAuth();

        View_("home");
    }
}