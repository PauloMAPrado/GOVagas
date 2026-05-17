<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table      = 'empresas';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nome', 'email', 'senha', 'whatsapp', 'cnpj', 'endereco', 'link'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nome'  => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'senha' => 'required|min_length[6]',
        'cnpj'  => 'required|min_length[11]|max_length[20]',
    ];

    protected $validationMessages = [
        'nome'  => ['required' => 'O nome da empresa é obrigatório.'],
        'email' => ['required' => 'O e-mail é obrigatório.', 'valid_email' => 'Informe um e-mail válido.'],
        'senha' => ['required' => 'A senha é obrigatória.', 'min_length' => 'A senha deve ter no mínimo 6 caracteres.'],
        'cnpj'  => ['required' => 'O CNPJ é obrigatório.'],
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['senha'])) {
            $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}
