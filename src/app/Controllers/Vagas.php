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
        helper('auth');

        if ((int) $id === 0) {
            return redirect()->to(base_url('/'));
        }

        $vaga = $this->vagaModel()->find($id);
        if (! $vaga) {
            return redirect()->to(base_url('/'))->with('error', 'Vaga não encontrada.');
        }

        $vaga['empresa'] = $this->empresaModel()->find($vaga['empresa_id']) ?? [];
        $viaEmpresa      = service('uri')->getSegment(1) === 'empresa';
        $souDono         = empresa_logada()
            && (int) session()->get('empresa_id') === (int) $vaga['empresa_id'];

        if ($viaEmpresa) {
            if (! $souDono) {
                return redirect()->to(site_url('vagas/' . $id))
                    ->with('error', 'Esta vaga não pertence à sua empresa.');
            }

            $empresa = $this->empresaModel()->find(session()->get('empresa_id'));

            return view('formulario', [
                'vaga'    => $vaga,
                'empresa' => $empresa,
            ]);
        }

        return view('pages/vagas/ver', [
            'vaga'    => $vaga,
            'souDono' => $souDono,
        ]);
    }

    public function create()
    {
        $empresa = $this->empresaModel()->find(session()->get('empresa_id'));

        return view('formulario', ['empresa' => $empresa]);
    }

    public function salvar()
    {
        if (! $this->validate('vaga')) {
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
            log_message('error', 'Salvar vaga: {erro}', ['erro' => $e->getMessage()]);

            return redirect()->back()->withInput()->with('error', 'Não foi possível publicar a vaga.');
        }

        return redirect()->to(site_url('empresa'))->with('status', 'Vaga publicada com sucesso.');
    }

    public function update($id)
    {
        $vaga = $this->vagaModel()->find($id);
        if (! $vaga) {
            return redirect()->to(base_url('/'))->with('error', 'Vaga não encontrada.');
        }

        $empresaId = session()->get('empresa_id');
        if (! empresa_logada() || (int) $empresaId !== (int) $vaga['empresa_id']) {
            return redirect()->to(site_url('vagas/' . $id))->with('error', 'Sem permissão para editar.');
        }

        if (! $this->validate('vaga')) {
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
            log_message('error', 'Atualizar vaga: {erro}', ['erro' => $e->getMessage()]);

            return redirect()->back()->withInput()->with('error', 'Não foi possível salvar as alterações.');
        }

        return redirect()->to(site_url('empresa/vagas'))->with('status', 'Vaga atualizada com sucesso.');
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
