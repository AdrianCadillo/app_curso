<?php 
namespace src\Http\controllers;

class DashboardController extends Controller{

    public function index(){
        View_("layouts.app");
    }
}