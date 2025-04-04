<?php
namespace src\Http\lib;

trait Request{

    /**
     * Método post para enviar datos de un formulario
     */
    public function post(String $NameInput){
        if(isset($_POST[$NameInput])){

            return !empty($_POST[$NameInput]) ? $_POST[$NameInput] : null;
        }
        return null;
    }

    /**
     * Método get para enviar datos de un formulario
     */
    public function get(String $NameInput){
        if(isset($_GET[$NameInput])){

            return !empty($_GET[$NameInput]) ? $_GET[$NameInput] : null;
        }
        return null;
    }

    /**
     * Método post and get para enviar datos de un formulario
     */
    public function input(String $NameInput){
        if(isset($_REQUEST[$NameInput])){

            return !empty($_REQUEST[$NameInput]) ? $_REQUEST[$NameInput] : null;
        }
        return null;
    }

}