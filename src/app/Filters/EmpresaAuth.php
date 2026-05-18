<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Bloqueia visitantes (usuários comuns) sem login de empresa.
 */
class EmpresaAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('auth');

        if (empresa_logada()) {
            return;
        }

        return redirect()
            ->route('login')
            ->with('error', 'Esta área é exclusiva para empresas. Faça login para continuar.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
