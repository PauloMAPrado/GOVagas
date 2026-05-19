<?php

namespace App\Controllers;

use App\Models\VagaModel;

class Home extends BaseController
{
    public function index(): string
    {
        $model   = new VagaModel();
        $filtros = [
            'titulo'        => $this->request->getGet('titulo'),
            'categoria'     => $this->request->getGet('categoria'),
            'localizacao'   => $this->request->getGet('localizacao'),
            'tipo_contrato' => $this->request->getGet('tipo_contrato'),
            'modalidade'    => $this->request->getGet('modalidade'),
        ];

        $temFiltro = array_filter($filtros);

        try {
            $rows = $temFiltro ? $model->buscar($filtros) : $model->getAllWithEmpresa();
        } catch (\Throwable $e) {
            $rows = [];
        }

        $vagas = array_map(static fn (array $row) => $model->formatarParaCard($row), $rows);

        return view('pages/home', ['vagas' => $vagas, 'filtros' => $filtros]);
    }
}
