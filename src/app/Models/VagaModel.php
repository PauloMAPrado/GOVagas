<?php

namespace App\Models;

use CodeIgniter\Model;

class VagaModel extends Model
{
    protected $table         = 'vagas';
    protected $primaryKey  = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'empresa_id', 'titulo', 'categoria', 'tipo_contrato', 'modalidade',
        'data_encerramento', 'quantidade', 'faixa_salarial', 'beneficios',
        'localizacao', 'descricao', 'status',
    ];

    protected $validationRules = 'vaga';

    public function getAllWithEmpresa(): array
    {
        return $this->baseComEmpresa()
            ->orderBy('vagas.created_at', 'DESC')
            ->findAll();
    }

    public function buscar(array $filtros): array
    {
        $q = $this->baseComEmpresa();

        if ($filtros['titulo'] ?? '') {
            $q->like('vagas.titulo', $filtros['titulo']);
        }
        if ($filtros['categoria'] ?? '') {
            $q->where('vagas.categoria', $filtros['categoria']);
        }
        if ($filtros['localizacao'] ?? '') {
            $q->like('vagas.localizacao', $filtros['localizacao']);
        }
        if ($filtros['tipo_contrato'] ?? '') {
            $q->where('vagas.tipo_contrato', $filtros['tipo_contrato']);
        }
        if ($filtros['modalidade'] ?? '') {
            $q->where('vagas.modalidade', $filtros['modalidade']);
        }

        return $q->orderBy('vagas.created_at', 'DESC')->findAll();
    }

    public function formatarParaCard(array $row): array
    {
        $desc   = $row['descricao'] ?? '';
        $limite = 240;
        $resumo = strlen($desc) > $limite ? substr($desc, 0, $limite) . '...' : $desc;

        return [
            'id' => (int) ($row['id'] ?? 0),
            'titulo' => $row['titulo'] ?? '',
            'empresa_nome' => $row['empresa_nome'] ?? $row['nome'] ?? 'Empresa',
            'categoria' => $row['categoria'] ?? '',
            'localizacao' => $row['localizacao'] ?? '',
            'faixa_salarial' => $row['faixa_salarial'] ?? '',
            'quantidade' => (int) ($row['quantidade'] ?? 1),
            'tipo_contrato' => $row['tipo_contrato'] ?? '',
            'modalidade' => $row['modalidade'] ?? '',
            'descricao' => $desc,
            'descricao_resumida' => $resumo,
        ];
    }

    private function baseComEmpresa()
    {
        return $this->select('vagas.*, empresas.nome AS empresa_nome')
            ->join('empresas', 'empresas.id = vagas.empresa_id', 'left')
            ->where('vagas.status', 'ativo');
    }
}
