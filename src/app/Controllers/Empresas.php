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
                return redirect()->back()->with('error', 'As senhas não coincidem.')->withInput();
            }
            $data['senha'] = $pw; // model faz o hash via beforeUpdate
        }

        $model->update($id, $data);
        session()->set('empresa_nome', $data['nome']);

        return redirect()->to('/empresa/perfil')->with('status', 'Perfil atualizado com sucesso.');
    }
}
