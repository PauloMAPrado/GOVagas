<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuarioAuth extends BaseController
{
    public function cadastro()
    {
        helper('auth');

        if (usuario_logado()) {
            return redirect()->route('usuario.perfil');
        }

        return view('pages/usuarios/cadastro');
    }

    public function salvarCadastro()
    {
        $rules = [
            'nome_completo'        => 'required|min_length[3]|max_length[150]',
            'email'                => 'required|valid_email',
            'cpf'                  => 'required|min_length[11]|max_length[14]',
            'senha'                => 'required|min_length[6]',
            'confirmacao_de_senha' => 'required|matches[senha]',
            'estado'               => 'required|exact_length[2]',
            'categoria'            => 'required',
            'tipo_contrato'        => 'required',
            'modalidade'           => 'required',
        ];

        $messages = [
            'confirmacao_de_senha' => ['matches' => 'As senhas não coincidem.'],
            'senha'                => ['min_length' => 'A senha deve ter no mínimo 6 caracteres.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $cpf = preg_replace('/\D/', '', (string) $this->request->getPost('cpf'));
        if (strlen($cpf) !== 11) {
            return redirect()->back()->withInput()->with('error', 'Informe um CPF válido (11 dígitos).');
        }

        $estados = array_keys(vaga_estados());
        $estado  = strtoupper((string) $this->request->getPost('estado'));
        if (! in_array($estado, $estados, true)) {
            return redirect()->back()->withInput()->with('error', 'Selecione um estado válido.');
        }

        $model = new UsuarioModel();

        if ($model->where('email', $this->request->getPost('email'))->first()) {
            return redirect()->back()->withInput()->with('error', 'Este e-mail já está cadastrado.');
        }

        if ($model->where('cpf', $cpf)->first()) {
            return redirect()->back()->withInput()->with('error', 'Este CPF já está cadastrado.');
        }

        $dados = $this->dadosDoPost($cpf, $estado);
        $dados['senha'] = (string) $this->request->getPost('senha');

        try {
            $id = $model->insert($dados);
        } catch (\Throwable $e) {
            log_message('error', 'Cadastro candidato: {msg}', ['msg' => $e->getMessage()]);

            return redirect()->back()->withInput()->with(
                'error',
                'Não foi possível criar a conta. Verifique se o banco está configurado e tente novamente.'
            );
        }

        if ($id === false) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->route('usuario.login')->with('status', 'Conta criada! Faça login com seu CPF.');
    }

    public function login()
    {
        helper('auth');

        if (usuario_logado()) {
            return redirect()->route('vagas.sugeridas');
        }

        return view('pages/usuarios/login');
    }

    public function autenticar()
    {
        if (! $this->validate(['cpf' => 'required', 'senha' => 'required'])) {
            return redirect()->back()->withInput()->with('error', 'Preencha CPF e senha.');
        }

        $cpf = preg_replace('/\D/', '', (string) $this->request->getPost('cpf'));
        if (strlen($cpf) !== 11) {
            return redirect()->back()->withInput()->with('error', 'Informe um CPF válido (11 dígitos).');
        }

        $model   = new UsuarioModel();
        $senha   = (string) $this->request->getPost('senha');
        $usuario = $model->where('cpf', $cpf)->first();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            session()->regenerate(true);
            session()->set([
                'usuario_id'     => $usuario['id'],
                'usuario_nome'   => $usuario['nome_completo'],
                'usuario_logado' => true,
                'candidato_id'   => $usuario['id'],
            ]);

            return redirect()->route('vagas.sugeridas')->with('status', 'Olá, ' . $usuario['nome_completo'] . '!');
        }

        return redirect()->back()->withInput()->with('error', 'CPF ou senha inválidos.');
    }

    /**
     * @return array<string, string>
     */
    private function dadosDoPost(string $cpf, string $estado): array
    {
        return [
            'nome_completo' => trim((string) $this->request->getPost('nome_completo')),
            'email'         => trim((string) $this->request->getPost('email')),
            'cpf'           => $cpf,
            'estado'        => $estado,
            'categoria'     => (string) $this->request->getPost('categoria'),
            'tipo_contrato' => (string) $this->request->getPost('tipo_contrato'),
            'modalidade'    => (string) $this->request->getPost('modalidade'),
        ];
    }
}
