<?php

namespace App\Controllers;

use App\Models\EmpresaModel;

class AuthController extends BaseController
{
    public function cadastro()
    {
        return view('pages/cadastro');
    }

    public function salvarCadastro()
    {
        $rules = [
            'nome'                 => 'required|min_length[2]|max_length[100]',
            'email'                => 'required|valid_email',
            'cnpj'                 => 'required|min_length[11]|max_length[20]',
            'senha'                => 'required|min_length[6]',
            'confirmacao_de_senha' => 'required|matches[senha]',
            'contato'              => 'required',
        ];

        $messages = [
            'confirmacao_de_senha' => ['matches' => 'As senhas não coincidem.'],
            'senha'                => ['min_length' => 'A senha deve ter no mínimo 6 caracteres.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new EmpresaModel();

        if ($model->where('email', $this->request->getPost('email'))->first()) {
            return redirect()->back()->withInput()->with('error', 'Este e-mail já está cadastrado.');
        }

        $dados = [
            'nome'     => trim((string) $this->request->getPost('nome')),
            'email'    => trim((string) $this->request->getPost('email')),
            'whatsapp' => preg_replace('/[^0-9]/', '', (string) $this->request->getPost('contato')),
            'cnpj'     => preg_replace('/[^0-9]/', '', (string) $this->request->getPost('cnpj')),
            'endereco' => trim((string) $this->request->getPost('endereco')),
            'link'     =>  trim((string) $this->request->getPost('link')),
            'senha'    => $this->request->getPost('senha'),
        ];

        if ($model->save($dados)) {
            return redirect()->route('login')->with('status', 'Conta criada com sucesso! Faça login.');
        }

        return redirect()->back()->withInput()->with('error', 'Erro ao criar conta. Verifique os dados.');
    }

    public function login()
    {
        return view('pages/login');
    }

    public function autenticar()
    {
        if (! $this->validate(['cnpj' => 'required', 'senha' => 'required'])) {
            return redirect()->back()->withInput()->with('error', 'Preencha CNPJ e senha.');
        }

        $model   = new EmpresaModel();
        $cnpj    = preg_replace('/[^0-9]/', '', (string) $this->request->getPost('cnpj'));
        $senha   = (string) $this->request->getPost('senha');
        $empresa = $model->where('cnpj', $cnpj)->first();

        if ($empresa && password_verify($senha, $empresa['senha'])) {
            session()->set([
                'empresa_id'   => $empresa['id'],
                'empresa_nome' => $empresa['nome'],
                'logado'       => true,
            ]);
            return redirect()->route('empresa.dashboard')->with('status', 'Bem-vinda, ' . $empresa['nome'] . '!');
        }

        return redirect()->back()->withInput()->with('error', 'CNPJ ou senha inválidos.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->route('home')->with('status', 'Você saiu da sua conta.');
    }
}
