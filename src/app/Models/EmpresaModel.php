<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table = 'empresas';
    protected $primaryKey  = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['nome', 'email', 'senha', 'whatsapp', 'cnpj', 'endereco', 'link'];

    protected $validationRules = 'empresa';

    protected $beforeInsert = ['criptografarSenha'];
    protected $beforeUpdate = ['criptografarSenha'];

    protected function criptografarSenha(array $data): array
    {
        if (! isset($data['data']['senha']) || $data['data']['senha'] === '') {
            unset($data['data']['senha']);

            return $data;
        }

        $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);

        return $data;
    }
}
