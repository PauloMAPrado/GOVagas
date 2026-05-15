<?php

namespace App\Controllers;

use App\Models\VagaModel;
use App\Models\EmpresaModel;

class Vagas extends BaseController
{
    protected function vagaModel()
    {
        return new VagaModel();
    }

    protected function empresaModel()
    {
        return new EmpresaModel();
    }

    public function show($id)
    {
 
        if ((int) $id === 0) {
            $vaga = [
                'id' => 0,
                'titulo' => 'Desenvolvedor Fullstack',
                'categoria' => 'tecnologia',
                'tipo_contrato' => 'CLT',
                'modalidade' => 'Presencial',
                'data_encerramento' => '',
                'quantidade' => 2,
                'faixa_salarial' => 'R$ 3.000 - R$ 5.000',
                'beneficios' => 'VR, VA, Plano de Saude',
                'localizacao' => 'São Paulo - SP',
                'whatsapp' => '',
                'descricao' => 'Vaga demonstrativa criada automaticamente. Customize esta vaga via seed/migrations no banco de dados.',
                'empresa' => [
                    'nome' => 'Empresa Exemplo',
                    'whatsapp' => '',
                    'email' => '',
                ],
            ];

            return view('pages/vagas/create', ['vaga' => $vaga, 'readonly' => true, 'isOwner' => false]);
        }

        $vaga = $this->vagaModel()->find($id);
        if (! $vaga) {
            return redirect()->to('/')->with('error', 'Vaga não encontrada.');
        }

        $empresa = $this->empresaModel()->find($vaga['empresa_id']);
        $vaga['empresa'] = $empresa;

        $empresaId = session()->get('empresa_id');
        $isOwner = $empresaId && ((int) $empresaId === (int) ($vaga['empresa_id'] ?? 0));

        return view('pages/vagas/create', ['vaga' => $vaga, 'readonly' => ! $isOwner, 'isOwner' => $isOwner]);
    }

    public function update($id)
    {
        $request = service('request');

        $vaga = $this->vagaModel()->find($id);
        if (!$vaga) {
            return redirect()->to('/')->with('error', 'Vaga não encontrada.');
        }

        $empresaId = session()->get('empresa_id');
        if (!$empresaId || ((int) $empresaId !== (int) $vaga['empresa_id'])) {
            return redirect()->to('/empresa/vagas')->with('error', 'Permissão negada.');
        }

        $data = [
            'titulo' => (string) $request->getPost('titulo'),
            'categoria' => (string) $request->getPost('categoria'),
            'tipo_contrato' => (string) $request->getPost('tipo_contrato'),
            'modalidade' => (string) $request->getPost('modalidade'),
            'data_encerramento' => (string) $request->getPost('data_encerramento'),
            'quantidade' => (int) $request->getPost('quantidade'),
            'faixa_salarial' => (string) $request->getPost('faixa_salarial'),
            'beneficios' => (string) $request->getPost('beneficios'),
            'localizacao' => (string) $request->getPost('localizacao'),
            'descricao' => (string) $request->getPost('descricao'),
        ];

        try {
            $this->vagaModel()->update($id, $data);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar vaga: ' . $e->getMessage())->withInput();
        }

        return redirect()->to('/empresa/vagas/' . $id)->with('status', 'Vaga atualizada com sucesso.');
    }

    public function create()
    {
        return view('pages/vagas/create');
    }

    public function salvar()
    {
        $request = service('request');
        $empresaId = session()->get('empresa_id');
        if (!$empresaId) {
            return redirect()->to('/login')->with('error', 'É preciso estar logado como empresa para publicar uma vaga.');
        }

        $data = [
            'empresa_id' => $empresaId,
            'titulo' => (string) $request->getPost('titulo'),
            'categoria' => (string) $request->getPost('categoria'),
            'tipo_contrato' => (string) $request->getPost('tipo_contrato'),
            'modalidade' => (string) $request->getPost('modalidade'),
            'data_encerramento' => (string) $request->getPost('data_encerramento'),
            'quantidade' => (int) $request->getPost('quantidade'),
            'faixa_salarial' => (string) $request->getPost('faixa_salarial'),
            'beneficios' => (string) $request->getPost('beneficios'),
            'localizacao' => (string) $request->getPost('localizacao'),
            'descricao' => (string) $request->getPost('descricao'),
            'status' => 'ativo',
        ];

        try {
            $id = $this->vagaModel()->insert($data);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Erro ao salvar vaga: ' . $e->getMessage())->withInput();
        }

        return redirect()->to('/empresa')->with('status', 'Vaga publicada com sucesso.');
    }

    public function toggleStatus($id)
    {
        $vaga = $this->vagaModel()->find($id);
        $empresaId = session()->get('empresa_id');

        // Segurança: verifica se a vaga existe e pertence à empresa logada
        if (!$vaga || (int)$vaga['empresa_id'] !== (int)$empresaId) {
            return redirect()->back()->with('error', 'Acesso negado ou vaga não encontrada.');
        }

        // Alterna o status
        $novoStatus = ($vaga['status'] === 'ativo') ? 'pausado' : 'ativo';
        $this->vagaModel()->update($id, ['status' => $novoStatus]);

        return redirect()->back()->with('status', "Vaga atualizada para: " . ucfirst($novoStatus));
    }
}
