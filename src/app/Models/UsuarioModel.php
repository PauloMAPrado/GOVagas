<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey  = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'nome_completo', 'email', 'cpf', 'senha',
        'estado', 'categoria', 'tipo_contrato', 'modalidade',
    ];

    protected $validationRules = 'usuario';

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
