<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Bloqueia acesso à área do candidato sem login de usuário.
 */
class UsuarioAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('auth');

        if (usuario_logado()) {
            return;
        }

        return redirect()
            ->route('usuario.login')
            ->with('error', 'Faça login para acessar seu perfil.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
