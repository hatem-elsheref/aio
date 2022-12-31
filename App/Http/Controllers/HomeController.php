<?php

namespace App\Http\Controllers;

class HomeController
{
    public function index(){
        return "Show Index Page";
    }

    public function posts($post){
        return "Show Posts Page";
    }

    public function about(){
        return "Show About Page";
    }

    public function contact(){
        return "Show Contact Page";
    }

    public function login(){
        return "Show Login Page";
    }

    public function register(){
        return "Show Register Page";
    }
}