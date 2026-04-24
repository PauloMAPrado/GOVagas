<?php

namespace App\Controllers;

use App\Models\EmpresaModel;

class Empresas extends BaseController
{
    protected $empresaModel;

    // Lazy-load the model to avoid attempting DB connection on controller construction
    protected function model()
    {
        if ($this->empresaModel === null) {
            $this->empresaModel = new EmpresaModel();
        }
        return $this->empresaModel;
    }

    public function index()
    {
    $empresas = $this->model()->findAll();
        return view('pages/empresas/index', ['empresas' => $empresas]);
    }

    public function create()
    {
        return view('pages/register');
    }

    public function store()
    {
    $request = service('request');
    $this->model(); // ensure model class is loaded when storing
        $nome = trim((string) $request->getPost('nome_da_empresa'));
        $email = trim((string) $request->getPost('email'));
        $senha = (string) $request->getPost('senha');
        $senhaConfirm = (string) $request->getPost('confirmacao_de_senha');
        $whatsapp = trim((string) $request->getPost('contato')) ?: trim((string) $request->getPost('whatsapp'));

        // Basic validation
        if ($nome === '' || $email === '' || $senha === '') {
            return redirect()->back()->with('error', 'Preencha nome, email e senha.')->withInput();
        }

        // Email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'E-mail inválido.')->withInput();
        }

        // Password confirmation
        if ($senha !== $senhaConfirm) {
            return redirect()->back()->with('error', 'As senhas não coincidem.')->withInput();
        }

        // Check duplicate email
    $existing = $this->model()->where('email', $email)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'E-mail já cadastrado.')->withInput();
        }

        $insertData = [
            'nome' => $nome,
            'email' => $email,
            'senha' => password_hash($senha, PASSWORD_DEFAULT),
            'whatsapp' => $whatsapp,
        ];

        try {
            $this->model()->insert($insertData);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Erro ao salvar empresa: ' . $e->getMessage())->withInput();
        }

        return redirect()->to('/login')->with('status', 'Cadastro realizado com sucesso. Faça login.');
    }

    public function edit($id)
    {
    $empresa = $this->model()->find($id);
        if (!$empresa) {
            return redirect()->to('/empresas')->with('error', 'Empresa não encontrada.');
        }
        return view('pages/empresas/edit', ['empresa' => $empresa]);
    }

    public function update($id)
    {
        $request = service('request');

        $data = [
            'nome' => trim((string) $request->getPost('nome_da_empresa')),
            'email' => trim((string) $request->getPost('email')),
            'whatsapp' => trim((string) $request->getPost('contato')),
        ];

        // Update password only if provided
        $pw = (string) $request->getPost('senha');
        if ($pw !== '') {
            $pw2 = (string) $request->getPost('confirmacao_de_senha');
            if ($pw !== $pw2) {
                return redirect()->back()->with('error', 'As senhas não coincidem.')->withInput();
            }
            $data['senha'] = password_hash($pw, PASSWORD_DEFAULT);
        }

        try {
            $this->model()->update($id, $data);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar empresa: ' . $e->getMessage())->withInput();
        }

        return redirect()->to('/empresas')->with('status', 'Empresa atualizada com sucesso.');
    }

    public function delete($id)
    {
        try {
            $this->model()->delete($id);
        } catch (\Throwable $e) {
            return redirect()->to('/empresas')->with('error', 'Erro ao excluir: ' . $e->getMessage());
        }
        return redirect()->to('/empresas')->with('status', 'Empresa excluída.');
    }
}
