<?php

namespace App\Controllers;

use App\Models\EmpresaModel;
use App\Models\VagaModel;

class Empresas extends BaseController
{
    public function dashboard()
    {
        $empresaId = session()->get('empresa_id');
        $vagas     = (new VagaModel())->where('empresa_id', $empresaId)->findAll();
        $empresa   = (new EmpresaModel())->find($empresaId);

        return view('pages/empresas/dashboard', [
            'empresa' => $empresa,
            'vagas'   => $vagas,
        ]);
    }

    public function vagas()
    {
        $empresaId = session()->get('empresa_id');
        $vagas     = (new VagaModel())->where('empresa_id', $empresaId)->findAll();

        return view('pages/empresas/index', ['vagas' => $vagas]);
    }

    public function perfil()
    {
        $empresa = (new EmpresaModel())->find(session()->get('empresa_id'));
        return view('pages/empresas/edit', ['empresa' => $empresa]);
    }

    public function salvarPerfil()
    {
        $rules = [
            'nome_da_empresa' => 'required|min_length[2]|max_length[100]',
            'email'           => 'required|valid_email',
            'cnpj'            => 'permit_empty|min_length[11]|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id    = session()->get('empresa_id');
        $model = new EmpresaModel();

        $data = [
            'nome'     => trim((string) $this->request->getPost('nome_da_empresa')),
            'email'    => trim((string) $this->request->getPost('email')),
            'whatsapp' => trim((string) $this->request->getPost('contato')),
            'cnpj'     => trim((string) $this->request->getPost('cnpj')),
            'endereco' => trim((string) $this->request->getPost('endereco')),
            'link'     => trim((string) $this->request->getPost('link')),
        ];

        $pw = (string) $this->request->getPost('senha');
        if ($pw !== '') {
            if ($pw !== (string) $this->request->getPost('confirmacao_de_senha')) {
                return redirect()->back()->withInput()->with('error', 'As senhas não coincidem.');
            }
            $data['senha'] = $pw;
        }

        $model->update($id, $data);
        session()->set('empresa_nome', $data['nome']);

        return redirect()->route('empresa.perfil')->with('status', 'Perfil atualizado com sucesso.');
    }
}
