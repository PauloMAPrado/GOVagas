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
