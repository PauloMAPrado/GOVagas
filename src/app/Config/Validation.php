<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // -------------------------------------------------------------------------
    // Grupos de regras (use: $this->validate('nome_do_grupo'))
    // -------------------------------------------------------------------------

    public array $empresa = [
        'nome' => [
            'label'  => 'Nome',
            'rules'  => ['required', 'min_length[2]', 'max_length[100]'],
            'errors' => ['required' => 'Informe o nome da empresa.'],
        ],
        'email' => [
            'label'  => 'E-mail',
            'rules'  => ['required', 'valid_email', 'max_length[100]'],
            'errors' => ['valid_email' => 'E-mail inválido.'],
        ],
        'senha' => [
            'label'  => 'Senha',
            'rules'  => ['required', 'min_length[6]'],
            'errors' => ['min_length' => 'Senha com no mínimo 6 caracteres.'],
        ],
        'cnpj' => [
            'label'  => 'CNPJ',
            'rules'  => ['required', 'min_length[11]', 'max_length[20]'],
            'errors' => ['required' => 'Informe o CNPJ.'],
        ],
    ];

    public array $empresa_cadastro = [
        'nome' => [
            'label'  => 'Nome',
            'rules'  => ['required', 'min_length[2]', 'max_length[100]'],
        ],
        'email' => [
            'label'  => 'E-mail',
            'rules'  => ['required', 'valid_email'],
        ],
        'cnpj' => [
            'label'  => 'CNPJ',
            'rules'  => ['required', 'min_length[11]', 'max_length[20]'],
        ],
        'senha' => [
            'label'  => 'Senha',
            'rules'  => ['required', 'min_length[6]'],
            'errors' => ['min_length' => 'A senha deve ter no mínimo 6 caracteres.'],
        ],
        'confirmacao_de_senha' => [
            'label'  => 'Confirmação de senha',
            'rules'  => ['required', 'matches[senha]'],
            'errors' => ['matches' => 'As senhas não coincidem.'],
        ],
        'contato' => [
            'label'  => 'Contato',
            'rules'  => ['required'],
        ],
    ];

    public array $empresa_perfil = [
        'nome_da_empresa' => [
            'label'  => 'Nome da empresa',
            'rules'  => ['required', 'min_length[2]', 'max_length[100]'],
        ],
        'email' => [
            'label'  => 'E-mail',
            'rules'  => ['required', 'valid_email'],
        ],
        'cnpj' => [
            'label'  => 'CNPJ',
            'rules'  => ['permit_empty', 'min_length[11]', 'max_length[20]'],
        ],
    ];

    public array $empresa_login = [
        'cnpj' => [
            'label'  => 'CNPJ',
            'rules'  => ['required'],
        ],
        'senha' => [
            'label'  => 'Senha',
            'rules'  => ['required'],
        ],
    ];

    public array $usuario = [
        'nome_completo' => [
            'label'  => 'Nome completo',
            'rules'  => ['required', 'min_length[3]', 'max_length[150]'],
            'errors' => ['required' => 'Informe o nome completo.'],
        ],
        'email' => [
            'label'  => 'E-mail',
            'rules'  => ['required', 'valid_email', 'max_length[100]'],
            'errors' => ['valid_email' => 'E-mail inválido.'],
        ],
        'cpf' => [
            'label'  => 'CPF',
            'rules'  => ['required', 'exact_length[11]'],
            'errors' => ['exact_length' => 'CPF deve ter 11 dígitos.'],
        ],
        'senha' => [
            'label'  => 'Senha',
            'rules'  => ['required', 'min_length[6]'],
            'errors' => ['min_length' => 'Senha com no mínimo 6 caracteres.'],
        ],
        'estado' => [
            'label'  => 'Estado',
            'rules'  => ['required', 'exact_length[2]'],
            'errors' => ['required' => 'Escolha o estado.'],
        ],
        'categoria' => [
            'label'  => 'Categoria',
            'rules'  => ['required'],
        ],
        'tipo_contrato' => [
            'label'  => 'Tipo de contrato',
            'rules'  => ['required'],
        ],
        'modalidade' => [
            'label'  => 'Modalidade',
            'rules'  => ['required'],
        ],
    ];

    public array $usuario_cadastro = [
        'nome_completo' => [
            'label'  => 'Nome completo',
            'rules'  => ['required', 'min_length[3]', 'max_length[150]'],
        ],
        'email' => [
            'label'  => 'E-mail',
            'rules'  => ['required', 'valid_email'],
        ],
        'cpf' => [
            'label'  => 'CPF',
            'rules'  => ['required', 'min_length[11]', 'max_length[14]'],
        ],
        'senha' => [
            'label'  => 'Senha',
            'rules'  => ['required', 'min_length[6]'],
            'errors' => ['min_length' => 'A senha deve ter no mínimo 6 caracteres.'],
        ],
        'confirmacao_de_senha' => [
            'label'  => 'Confirmação de senha',
            'rules'  => ['required', 'matches[senha]'],
            'errors' => ['matches' => 'As senhas não coincidem.'],
        ],
        'estado' => [
            'label'  => 'Estado',
            'rules'  => ['required', 'exact_length[2]'],
        ],
        'categoria' => [
            'label'  => 'Categoria',
            'rules'  => ['required'],
        ],
        'tipo_contrato' => [
            'label'  => 'Tipo de contrato',
            'rules'  => ['required'],
        ],
        'modalidade' => [
            'label'  => 'Modalidade',
            'rules'  => ['required'],
        ],
    ];

    public array $usuario_perfil = [
        'nome_completo' => [
            'label'  => 'Nome completo',
            'rules'  => ['required', 'min_length[3]', 'max_length[150]'],
        ],
        'email' => [
            'label'  => 'E-mail',
            'rules'  => ['required', 'valid_email', 'max_length[100]'],
        ],
        'cpf' => [
            'label'  => 'CPF',
            'rules'  => ['required', 'exact_length[11]'],
        ],
        'estado' => [
            'label'  => 'Estado',
            'rules'  => ['required', 'exact_length[2]'],
        ],
        'categoria' => [
            'label'  => 'Categoria',
            'rules'  => ['required'],
        ],
        'tipo_contrato' => [
            'label'  => 'Tipo de contrato',
            'rules'  => ['required'],
        ],
        'modalidade' => [
            'label'  => 'Modalidade',
            'rules'  => ['required'],
        ],
    ];

    public array $usuario_login = [
        'cpf' => [
            'label'  => 'CPF',
            'rules'  => ['required'],
        ],
        'senha' => [
            'label'  => 'Senha',
            'rules'  => ['required'],
        ],
    ];

    public array $vaga = [
        'titulo' => [
            'label'  => 'Título',
            'rules'  => ['required', 'min_length[3]', 'max_length[255]'],
            'errors' => ['required' => 'Dê um título para a vaga.'],
        ],
        'categoria' => [
            'label'  => 'Categoria',
            'rules'  => ['required'],
        ],
        'tipo_contrato' => [
            'label'  => 'Tipo de contrato',
            'rules'  => ['required'],
        ],
        'modalidade' => [
            'label'  => 'Modalidade',
            'rules'  => ['required'],
        ],
        'localizacao' => [
            'label'  => 'Localização',
            'rules'  => ['required', 'max_length[255]'],
        ],
        'descricao' => [
            'label'  => 'Descrição',
            'rules'  => ['required', 'min_length[10]'],
            'errors' => ['min_length' => 'Descrição muito curta.'],
        ],
        'quantidade' => [
            'label'  => 'Quantidade',
            'rules'  => ['required', 'integer', 'greater_than[0]'],
            'errors' => ['greater_than' => 'Quantidade precisa ser maior que zero.'],
        ],
    ];
}
