<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('pages/home');
    }

    public function register(): string
    {
        return view('pages/register');
    }

    public function login(): string
    {
        return view('pages/login');
    }
}
