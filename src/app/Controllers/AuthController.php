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
        $model = new EmpresaModel();

        $senha  = (string) $this->request->getPost('senha');
        $senha2 = (string) $this->request->getPost('confirmacao_de_senha');

        if ($senha !== $senha2) {
            return redirect()->back()->with('error', 'As senhas não coincidem.')->withInput();
        }

        if ($model->where('email', $this->request->getPost('email'))->first()) {
            return redirect()->back()->with('error', 'Este e-mail já está cadastrado.')->withInput();
        }

        // O EmpresaModel já faz password_hash via beforeInsert
        $dados = [
            'nome'     => $this->request->getPost('nome'),
            'email'    => $this->request->getPost('email'),
            'whatsapp' => $this->request->getPost('contato'),
            'cnpj'     => $this->request->getPost('cnpj'),
            'endereco' => $this->request->getPost('endereco'),
            'link'     => $this->request->getPost('link'),
            'senha'    => $senha,
        ];

        if ($model->save($dados)) {
            return redirect()->to('/login')->with('status', 'Conta criada com sucesso! Faça login.');
        }

        return redirect()->back()->with('error', 'Erro ao criar conta. Verifique os dados.')->withInput();
    }

    public function login()
    {
        return view('pages/login');
    }

    public function autenticar()
    {
        $model  = new EmpresaModel();
        $cnpj   = $this->request->getPost('cnpj');
        $senha  = (string) $this->request->getPost('senha');

        $empresa = $model->where('cnpj', $cnpj)->first();

        if ($empresa && password_verify($senha, $empresa['senha'])) {
            session()->set([
                'empresa_id'   => $empresa['id'],
                'empresa_nome' => $empresa['nome'],
                'logado'       => true,
            ]);
            return redirect()->to('/empresa')->with('status', 'Bem-vinda, ' . $empresa['nome'] . '!');
        }

        return redirect()->back()->with('error', 'CNPJ ou senha inválidos.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('status', 'Você saiu da sua conta.');
    }
}
