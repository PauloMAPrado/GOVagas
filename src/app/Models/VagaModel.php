<?php

namespace App\Models;

use CodeIgniter\Model;

class VagaModel extends Model
{
    protected $table      = 'vagas';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'empresa_id', 'titulo', 'categoria', 'tipo_contrato', 'modalidade',
        'data_encerramento', 'quantidade', 'faixa_salarial', 'beneficios',
        'localizacao', 'descricao', 'status', 'created_at', 'updated_at',
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'titulo'        => 'required|min_length[3]|max_length[255]',
        'categoria'     => 'required',
        'tipo_contrato' => 'required',
        'modalidade'    => 'required',
        'localizacao'   => 'required|max_length[255]',
        'descricao'     => 'required|min_length[10]',
        'quantidade'    => 'required|integer|greater_than[0]',
    ];

    protected $validationMessages = [
        'titulo'      => ['required' => 'O título da vaga é obrigatório.'],
        'localizacao' => ['required' => 'A localização é obrigatória.'],
        'descricao'   => ['required' => 'A descrição é obrigatória.', 'min_length' => 'A descrição deve ter no mínimo 10 caracteres.'],
        'quantidade'  => ['required' => 'A quantidade de vagas é obrigatória.', 'greater_than' => 'A quantidade deve ser maior que zero.'],
    ];

    public function getAllWithEmpresa(): array
    {
        return $this->select('vagas.*, empresas.nome as empresa_nome')
            ->join('empresas', 'empresas.id = vagas.empresa_id', 'left')
            ->where('vagas.status', 'ativo')
            ->orderBy('vagas.created_at', 'DESC')
            ->findAll();
    }

    public function buscar(array $filtros): array
    {
        $builder = $this->select('vagas.*, empresas.nome as empresa_nome')
            ->join('empresas', 'empresas.id = vagas.empresa_id', 'left')
            ->where('vagas.status', 'ativo');

        if (!empty($filtros['titulo'])) {
            $builder->like('vagas.titulo', $filtros['titulo']);
        }
        if (!empty($filtros['categoria'])) {
            $builder->where('vagas.categoria', $filtros['categoria']);
        }
        if (!empty($filtros['localizacao'])) {
            $builder->like('vagas.localizacao', $filtros['localizacao']);
        }
        if (!empty($filtros['tipo_contrato'])) {
            $builder->where('vagas.tipo_contrato', $filtros['tipo_contrato']);
        }
        if (!empty($filtros['modalidade'])) {
            $builder->where('vagas.modalidade', $filtros['modalidade']);
        }

        return $builder->orderBy('vagas.created_at', 'DESC')->findAll();
    }
}
