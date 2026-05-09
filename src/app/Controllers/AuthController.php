<?php

namespace App\Controllers;

use App\Models\EmpresaModel;

class AuthController extends BaseController
{
    /**
     * Exibe o formulário de cadastro
     */
    public function cadastro()
    {
        return view('pages/cadastro'); // Retorna a view de cadastro
    }
    
    public function salvarCadastro()
    {
    $model = new EmpresaModel();

     // Verifica se o email já está cadastrado
     $emailExistente = $model->where('email', $this->request->getPost('email'))->first();
     if ($emailExistente) {
         return redirect()->back()->with('error', 'Este e-mail já está cadastrado.');
     }

    $dados = [
        'nome'     => $this->request->getPost('nome'),
        'email'    => $this->request->getPost('email'),
        'whatsapp' => $this->request->getPost('contato'), // ← nome correto do campo
        'cnpj'     => $this->request->getPost('cnpj'),
        'endereco' => $this->request->getPost('endereco'),
        'link'     => $this->request->getPost('link'),
        'senha'    => $this->request->getPost('senha'),
    ];

    if ($model->save($dados)) {
        return redirect()->to('/login')->with('status', 'Conta criada com sucesso!');
    }

    return redirect()->back()->with('error', 'Erro ao criar conta. Verifique os dados.');
    }

   
    public function login()
    {
        return view('pages/login'); // Retorna a view de login
    }

    /**
     * Processa o login do usuário
     */
    public function autenticar()
    {
        $model = new EmpresaModel();
        $session = session();

        // Obtém os dados do formulário
        $cnpj = $this->request->getPost('cnpj');
        $senha = $this->request->getPost('senha');

        // Busca o usuário pelo cnpj
        $empresa = $model->where('cnpj', $cnpj)->first();

        // Verifica se o usuário existe e se a senha está correta
        if ($empresa && password_verify($senha, $empresa['senha'])) {
            // Configura os dados da sessão
            $session->set([
                'empresa_id' => $empresa['id'],
                'empresa_nome' => $empresa['nome'],
                'logado' => true,
            ]);

            return redirect()->to('/dashboard')->with('status', 'Login realizado com sucesso!');
        }

        // Retorna erro se as credenciais forem inválidas
        return redirect()->back()->with('error', 'Credenciais inválidas.');
    }

    /**
     * Realiza o logout do usuário
     */
    public function logout()
    {
        $session = session();
        $session->destroy(); // Destroi todos os dados da sessão
        return redirect()->to('/login')->with('status', 'Você saiu da sua conta.');
    }
}