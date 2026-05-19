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
        if (! $this->validate('empresa_cadastro')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new EmpresaModel();

        if ($model->where('email', $this->request->getPost('email'))->first()) {
            return redirect()->back()->withInput()->with('error', 'Este e-mail já está cadastrado.');
        }

        $dados = [
            'nome' => trim((string) $this->request->getPost('nome')),
            'email'=> trim((string) $this->request->getPost('email')),
            'whatsapp' => preg_replace('/[^0-9]/', '', (string) $this->request->getPost('contato')),
            'cnpj' => preg_replace('/[^0-9]/', '', (string) $this->request->getPost('cnpj')),
            'endereco' => trim((string) $this->request->getPost('endereco')),
            'link' =>  trim((string) $this->request->getPost('link')),
            'senha' => (string) $this->request->getPost('senha'),
        ];

        if ($model->save($dados)) {
            return redirect()->to(base_url('login'))->with('status', 'Conta criada com sucesso! Faça login.');
        }

        return redirect()->back()->withInput()->with('error', 'Erro ao criar conta. Verifique os dados.');
    }

    public function login()
    {
        helper('auth');

        if (empresa_logada()) {
            return redirect()->to(base_url('empresa'));
        }

        return view('pages/login');
    }

    public function autenticar()
    {
        if (! $this->validate('empresa_login')) {
            return redirect()->back()->withInput()->with('error', 'Preencha CNPJ e senha.');
        }

        $cnpj = preg_replace('/\D/', '', (string) $this->request->getPost('cnpj'));
        if (strlen($cnpj) !== 14) {
            return redirect()->back()->withInput()->with('error', 'Informe um CNPJ válido (14 dígitos).');
        }

        $model = new EmpresaModel();
        $senha = (string) $this->request->getPost('senha');
        $empresa = $model->where('cnpj', $cnpj)->first();

        if ($empresa && password_verify($senha, $empresa['senha'])) {
            session()->regenerate(true);
            session()->set([
                'empresa_id' => $empresa['id'],
                'empresa_nome' => $empresa['nome'],
                'logado' => true,
            ]);
            return redirect()->to(base_url('empresa'))->with('status', 'Bem-vinda, ' . $empresa['nome'] . '!');
        }

        return redirect()->back()->withInput()->with('error', 'CNPJ ou senha inválidos.');
    }

    public function recuperarSenha()
    {
        return view('pages/rec_senha');
    }

    public function enviarRecuperacao()
    {
        $email = trim((string) $this->request->getPost('email'));
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'E-mail inválido.');
        }
        return redirect()->to(base_url('nova-senha'))->with('status', 'E-mail válido. Insira a nova senha.');
    }

    public function novaSenha()
    {
        return view('pages/nova_senha');
    }

    public function confirmarNovaSenha()
    {
        $pw  = (string) $this->request->getPost('password');
        $pw2 = (string) $this->request->getPost('password_confirm');

        if ($pw === '' || $pw2 === '') {
            return redirect()->back()->with('error', 'Preencha ambos os campos.');
        }
        if ($pw !== $pw2) {
            return redirect()->back()->with('error', 'As senhas não coincidem.');
        }
        return redirect()->to(base_url('login'))->with('status', 'Senha alterada com sucesso.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'))->with('status', 'Você saiu da sua conta.');
    }
}
