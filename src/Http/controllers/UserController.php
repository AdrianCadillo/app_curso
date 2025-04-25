<?php

namespace src\Http\controllers;

class UserController extends Controller{

    public function index(){
        View_("user.index");
    }
}