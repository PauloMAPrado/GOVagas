<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VagasSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        
        $empresaData = [
            'nome' => 'Empresa Demo Ltda',
            'email' => 'demo@empresa.local',
            'senha' => password_hash('senha123', PASSWORD_DEFAULT),
            'whatsapp' => '+5511999999999',
            'created_at' => date('Y-m-d H:i:s')
        ];

    $db->table('empresas')->insert($empresaData);
    $empresaId = $db->insertID();

        $vagaData = [
            'empresa_id' => $empresaId,
            'titulo' => 'Desenvolvedor Fullstack (PHP/JS)',
            'categoria' => 'Desenvolvimento',
            'tipo_contrato' => 'CLT',
            'modalidade' => 'Presencial',
            'data_encerramento' => date('Y-m-d', strtotime('+30 days')),
            'quantidade' => 3,
            'faixa_salarial' => 'R$ 3.000 - R$ 5.500',
            'beneficios' => 'Vale transporte, Vale refeição, Plano de saúde',
            'localizacao' => 'São Paulo - SP',
            'descricao' => 'Vaga de exemplo usada para demonstração no front-end. Experiência em PHP, CodeIgniter, JavaScript.',
            'status' => 'ativo',
            'created_at' => date('Y-m-d H:i:s')
        ];

    $db->table('vagas')->insert($vagaData);
    }
}
