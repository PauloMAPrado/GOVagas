<?php

namespace App\Controllers;

use App\Models\VagaModel;
use App\Models\EmpresaModel;

class Vagas extends BaseController
{
    protected function vagaModel(): VagaModel
    {
        return new VagaModel();
    }

    protected function empresaModel(): EmpresaModel
    {
        return new EmpresaModel();
    }

    public function show($id)
    {
        if ((int) $id === 0) {
            $vaga = [
                'id'                => 0,
                'titulo'            => 'Desenvolvedor Fullstack',
                'categoria'         => 'tecnologia',
                'tipo_contrato'     => 'CLT',
                'modalidade'        => 'Presencial',
                'data_encerramento' => '',
                'quantidade'        => 2,
                'faixa_salarial'    => 'R$ 3.000 - R$ 5.000',
                'beneficios'        => 'VR, VA, Plano de Saude',
                'localizacao'       => 'São Paulo - SP',
                'whatsapp'          => '',
                'descricao'         => 'Vaga demonstrativa.',
                'empresa'           => ['nome' => 'Empresa Exemplo', 'whatsapp' => '', 'email' => ''],
            ];
            return view('pages/vagas/create', ['vaga' => $vaga, 'readonly' => true, 'isOwner' => false]);
        }

        $vaga = $this->vagaModel()->find($id);
        if (! $vaga) {
            return redirect()->route('home')->with('error', 'Vaga não encontrada.');
        }

        $vaga['empresa'] = $this->empresaModel()->find($vaga['empresa_id']);
        $empresaId       = session()->get('empresa_id');
        $isOwner         = $empresaId && ((int) $empresaId === (int) $vaga['empresa_id']);

        return view('pages/vagas/create', ['vaga' => $vaga, 'readonly' => ! $isOwner, 'isOwner' => $isOwner]);
    }

    public function create()
    {
        return view('pages/vagas/create');
    }

    public function salvar()
    {
        if (! $this->validate($this->vagaModel()->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $empresaId = session()->get('empresa_id');

        $data = [
            'empresa_id'        => $empresaId,
            'titulo'            => $this->request->getPost('titulo'),
            'categoria'         => $this->request->getPost('categoria'),
            'tipo_contrato'     => $this->request->getPost('tipo_contrato'),
            'modalidade'        => $this->request->getPost('modalidade'),
            'data_encerramento' => $this->request->getPost('data_encerramento'),
            'quantidade'        => (int) $this->request->getPost('quantidade'),
            'faixa_salarial'    => $this->request->getPost('faixa_salarial'),
            'beneficios'        => $this->request->getPost('beneficios'),
            'localizacao'       => $this->request->getPost('localizacao'),
            'descricao'         => $this->request->getPost('descricao'),
            'status'            => 'ativo',
        ];

        try {
            $this->vagaModel()->insert($data);
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao salvar vaga: ' . $e->getMessage());
        }

        return redirect()->route('empresa.dashboard')->with('status', 'Vaga publicada com sucesso.');
    }

    public function update($id)
    {
        $vaga = $this->vagaModel()->find($id);
        if (! $vaga) {
            return redirect()->route('home')->with('error', 'Vaga não encontrada.');
        }

        $empresaId = session()->get('empresa_id');
        if (! $empresaId || (int) $empresaId !== (int) $vaga['empresa_id']) {
            return redirect()->route('empresa.vagas')->with('error', 'Permissão negada.');
        }

        if (! $this->validate($this->vagaModel()->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'titulo'            => $this->request->getPost('titulo'),
            'categoria'         => $this->request->getPost('categoria'),
            'tipo_contrato'     => $this->request->getPost('tipo_contrato'),
            'modalidade'        => $this->request->getPost('modalidade'),
            'data_encerramento' => $this->request->getPost('data_encerramento'),
            'quantidade'        => (int) $this->request->getPost('quantidade'),
            'faixa_salarial'    => $this->request->getPost('faixa_salarial'),
            'beneficios'        => $this->request->getPost('beneficios'),
            'localizacao'       => $this->request->getPost('localizacao'),
            'descricao'         => $this->request->getPost('descricao'),
        ];

        try {
            $this->vagaModel()->update($id, $data);
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar vaga: ' . $e->getMessage());
        }

        return redirect()->route('empresa.dashboard')->with('status', 'Vaga atualizada com sucesso.');
    }

    public function toggleStatus($id)
    {
        $vaga      = $this->vagaModel()->find($id);
        $empresaId = session()->get('empresa_id');

        if (! $vaga || (int) $vaga['empresa_id'] !== (int) $empresaId) {
            return redirect()->back()->with('error', 'Acesso negado ou vaga não encontrada.');
        }

        $novoStatus = $vaga['status'] === 'ativo' ? 'pausado' : 'ativo';
        $this->vagaModel()->update($id, ['status' => $novoStatus]);

        return redirect()->back()->with('status', 'Vaga ' . ($novoStatus === 'ativo' ? 'ativada' : 'pausada') . ' com sucesso.');
    }
}
