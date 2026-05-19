<?php

if (! function_exists('vaga_estados')) {
    /**
     * @return array<string, string> UF => nome
     */
    function vaga_estados(): array
    {
        return [
            'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas',
            'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo',
            'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
            'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina',
            'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins',
        ];
    }
}

if (! function_exists('vaga_categorias')) {
    /**
     * @return array<string, string> slug => label
     */
    function vaga_categorias(): array
    {
        return [
            'tecnologia'        => 'Tecnologia',
            'administrativo'    => 'Administrativo',
            'vendas'            => 'Vendas',
            'design'            => 'Design',
            'marketing'         => 'Marketing',
            'recursos humanos'  => 'Recursos Humanos',
            'financeiro'        => 'Financeiro',
            'outros'            => 'Outros',
        ];
    }
}

if (! function_exists('vaga_tipos_contrato')) {
    /**
     * @return list<string>
     */
    function vaga_tipos_contrato(): array
    {
        return ['CLT', 'PJ', 'Estágio', 'Temporário'];
    }
}

if (! function_exists('vaga_modalidades')) {
    /**
     * @return list<string>
     */
    function vaga_modalidades(): array
    {
        return ['Presencial', 'Remoto', 'Híbrido'];
    }
}
