<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nome_completo', 'email', 'cpf', 'senha',
        'estado', 'categoria', 'tipo_contrato', 'modalidade',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nome_completo' => 'required|min_length[3]|max_length[150]',
        'email'         => 'required|valid_email|max_length[100]',
        'cpf'           => 'required|exact_length[11]',
        'senha'         => 'required|min_length[6]',
        'estado'        => 'required|exact_length[2]',
        'categoria'     => 'required',
        'tipo_contrato' => 'required',
        'modalidade'    => 'required',
    ];

    protected $validationMessages = [
        'nome_completo' => ['required' => 'O nome completo é obrigatório.'],
        'email'         => ['required' => 'O e-mail é obrigatório.', 'valid_email' => 'Informe um e-mail válido.'],
        'cpf'           => ['required' => 'O CPF é obrigatório.', 'exact_length' => 'Informe um CPF válido (11 dígitos).'],
        'senha'         => ['required' => 'A senha é obrigatória.', 'min_length' => 'A senha deve ter no mínimo 6 caracteres.'],
        'estado'        => ['required' => 'Selecione o estado de interesse.'],
        'categoria'     => ['required' => 'Selecione a categoria de interesse.'],
        'tipo_contrato' => ['required' => 'Selecione o tipo de contrato.'],
        'modalidade'    => ['required' => 'Selecione a modalidade.'],
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['senha']) && $data['data']['senha'] !== '') {
            $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);
        }

        return $data;
    }

    /**
     * Regras para atualização (senha opcional).
     *
     * @return array<string, string>
     */
    public function regrasAtualizacao(): array
    {
        return [
            'nome_completo' => 'required|min_length[3]|max_length[150]',
            'email'         => 'required|valid_email|max_length[100]',
            'cpf'           => 'required|exact_length[11]',
            'estado'        => 'required|exact_length[2]',
            'categoria'     => 'required',
            'tipo_contrato' => 'required',
            'modalidade'    => 'required',
        ];
    }
}
