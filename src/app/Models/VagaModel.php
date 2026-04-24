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
}
