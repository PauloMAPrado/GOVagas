<?php

namespace App\Models;

use CodeIgniter\Model;

class VagaModel extends Model
{
    protected $table = 'vagas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'empresa_id', 'titulo', 'categoria', 'tipo_contrato', 'modalidade', 'data_encerramento', 'quantidade', 'faixa_salarial', 'beneficios', 'localizacao', 'descricao', 'status', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;

    public function getAllWithEmpresa(): array
    {
        return $this->select('vagas.*, empresas.nome as empresa_nome')
            ->join('empresas', 'empresas.id = vagas.empresa_id', 'left')
            ->orderBy('vagas.created_at', 'DESC')
            ->findAll();
    }

    public  function filtrarVagas($filtros)
    {

        $Builder = $this->builder();

        if (!empty($filtros['titulo'])) {
            $Builder->like('titulo', $filtros['titulo']);
        }
        if(!empty($filtros['categoria']) && $filtros['categoria'] !== 'Todas as Categorias') {
            $Builder->where('categoria', $filtros['categoria']);
        }
        if (!empty($filtros['localizacao'])) {
            $Builder->like('localizacao', $filtros['localizacao']);
        }
        if(!empty($filtros['faixa_salarial'])) {
            $Builder->where('faixa_salarial', $filtros['faixa_salarial']);
        }
        if(!empty($filtros['tipo_contrato'])) {
            $Builder->whereIn('tipo_contrato', $filtros['tipo_contrato']);
        }
        if (!empty($filtros['modalidade'])) {
            $Builder->whereIn('modalidade', $filtros['modalidade']);
        }

        return $Builder->orderBy('created_at', 'DESC')->get()->getResultArray();
    }

}