<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Usuarios extends BaseController
{
    public function perfil()
    {
        $usuario = (new UsuarioModel())->find(session()->get('usuario_id'));

        return view('pages/usuarios/edit', ['usuario' => $usuario]);
    }

    public function salvarPerfil()
    {
        $id = (int) session()->get('usuario_id');

        if (! $this->validate((new UsuarioModel())->regrasAtualizacao())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $cpf = preg_replace('/\D/', '', (string) $this->request->getPost('cpf'));
        if (strlen($cpf) !== 11) {
            return redirect()->back()->withInput()->with('error', 'Informe um CPF válido (11 dígitos).');
        }

        $estado = strtoupper((string) $this->request->getPost('estado'));
        if (! in_array($estado, array_keys(vaga_estados()), true)) {
            return redirect()->back()->withInput()->with('error', 'Selecione um estado válido.');
        }

        $model = new UsuarioModel();

        $outroEmail = $model->where('email', $this->request->getPost('email'))->where('id !=', $id)->first();
        if ($outroEmail) {
            return redirect()->back()->withInput()->with('error', 'Este e-mail já está em uso.');
        }

        $outroCpf = $model->where('cpf', $cpf)->where('id !=', $id)->first();
        if ($outroCpf) {
            return redirect()->back()->withInput()->with('error', 'Este CPF já está em uso.');
        }

        $data = [
            'nome_completo' => trim((string) $this->request->getPost('nome_completo')),
            'email'         => trim((string) $this->request->getPost('email')),
            'cpf'           => $cpf,
            'estado'        => $estado,
            'categoria'     => (string) $this->request->getPost('categoria'),
            'tipo_contrato' => (string) $this->request->getPost('tipo_contrato'),
            'modalidade'    => (string) $this->request->getPost('modalidade'),
        ];

        $pw = (string) $this->request->getPost('senha');
        if ($pw !== '') {
            if ($pw !== (string) $this->request->getPost('confirmacao_de_senha')) {
                return redirect()->back()->withInput()->with('error', 'As senhas não coincidem.');
            }
            $data['senha'] = $pw;
        }

        if (! $model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        session()->set('usuario_nome', $data['nome_completo']);

        return redirect()->route('usuario.perfil')->with('status', 'Perfil atualizado com sucesso.');
    }
}
