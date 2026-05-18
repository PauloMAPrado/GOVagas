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
