<?php

/**
 * Verifica se a sessão pertence a uma empresa autenticada.
 */
if (! function_exists('empresa_logada')) {
    function empresa_logada(): bool
    {
        return session()->get('logado') === true
            && (int) session()->get('empresa_id') > 0;
    }
}

/**
 * Verifica se a sessão pertence a um usuário (candidato) autenticado.
 */
if (! function_exists('usuario_logado')) {
    function usuario_logado(): bool
    {
        return session()->get('usuario_logado') === true
            && (int) session()->get('usuario_id') > 0;
    }
}

/**
 * Dados para exibir quem está logado no menu (empresa ou candidato).
 *
     * @return array{tipo: string, label: string, nome: string, icon: string, perfil_url: string, perfil_rotulo: string}|null
 */
if (! function_exists('auth_exibir')) {
    function auth_exibir(): ?array
    {
        if (empresa_logada()) {
            return [
                'tipo'=> 'empresa',
                'label'=> 'Empresa',
                'nome' => (string) (session()->get('empresa_nome') ?: 'Minha empresa'),
                'icon' => 'fa-building',
                'perfil_url' => base_url('empresa/perfil'),
                'perfil_rotulo'=> 'Meu perfil',
            ];
        }

        if (usuario_logado()) {
            return [
                'tipo'=> 'candidato',
                'label'=> 'Candidato',
                'nome'=> (string) (session()->get('usuario_nome') ?: 'Meu perfil'),
                'icon' => 'fa-user',
                'perfil_url'=> url_to('usuario.perfil'),
                'perfil_rotulo'=> 'Meu perfil',
            ];
        }

        return null;
    }
}
