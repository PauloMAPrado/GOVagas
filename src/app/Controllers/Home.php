<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $vagas = [];
        try {
            $vagaModel = new \App\Models\VagaModel();
            $vagas = $vagaModel->getAllWithEmpresa();
        } catch (\Throwable $e) {
            $vagas = [];
        }

        return view('pages/home', ['vagas' => $vagas]);
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
