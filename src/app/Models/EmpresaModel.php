<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table = 'empresas';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['nome', 'email', 'senha', 'whatsapp', 'cnpj', 'endereco', 'link'];
    // Ativa a gestão automática de datas
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Evento que roda ANTES de inserir ou atualizar no banco
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        // Se houver uma senha sendo enviada, nós a criptografamos
        if (isset($data['data']['senha'])) {
            $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}