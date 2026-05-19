<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ─── Assets ───────────────────────────────────────────────────────────────────
$routes->get('img/(:any)', 'Assets::image/$1');

// ─── Públicas ─────────────────────────────────────────────────────────────────
$routes->get('/',            'Home::index',        ['as' => 'home']);
$routes->get('vagas/(:num)', 'Vagas::show/$1',     ['as' => 'vaga.show']);
$routes->get('vagas-sugeridas', 'VagasSugeridas::index', ['as' => 'vagas.sugeridas']);

// ─── Autenticação ─────────────────────────────────────────────────────────────
$routes->get( 'login',            'AuthController::login',          ['as' => 'login']);
$routes->post('login/autenticar', 'AuthController::autenticar',     ['as' => 'login.autenticar']);
$routes->get( 'cadastro',         'AuthController::cadastro',       ['as' => 'cadastro']);
$routes->post('cadastro/salvar',  'AuthController::salvarCadastro', ['as' => 'cadastro.salvar']);
$routes->get( 'logout',           'AuthController::logout',         ['as' => 'logout']);

// ─── Autenticação do candidato (usuário) ─────────────────────────────────────
$routes->get( 'usuario/cadastro',              'UsuarioAuth::cadastro',       ['as' => 'usuario.cadastro']);
$routes->post('usuario/cadastro/salvar',       'UsuarioAuth::salvarCadastro', ['as' => 'usuario.cadastro.salvar']);
$routes->get( 'usuario/login',                 'UsuarioAuth::login',          ['as' => 'usuario.login']);
$routes->post('usuario/login/autenticar',      'UsuarioAuth::autenticar',     ['as' => 'usuario.login.autenticar']);

$routes->group('usuario', ['filter' => 'usuario_auth'], static function ($routes) {
    $routes->get('perfil',         'Usuarios::perfil',       ['as' => 'usuario.perfil']);
    $routes->post('perfil/salvar', 'Usuarios::salvarPerfil', ['as' => 'usuario.perfil.salvar']);
});

// ─── Recuperação de senha ──────────────────────────────────────────────────────
$routes->get( 'recuperar-senha',   function () { return view('pages/rec_senha'); });
$routes->post('recuperar/enviar',  function () {
    $email = trim((string) service('request')->getPost('email'));
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return redirect()->to('/recuperar-senha')->with('error', 'E-mail inválido.');
    }
    return redirect()->to('/nova-senha')->with('status', 'E-mail válido. Insira a nova senha.');
});
$routes->get( 'nova-senha',        function () { return view('pages/nova_senha'); });
$routes->post('nova-senha/confirm', function () {
    $request = service('request');
    $pw  = (string) $request->getPost('password');
    $pw2 = (string) $request->getPost('password_confirm');
    if ($pw === '' || $pw2 === '') {
        return redirect()->back()->with('error', 'Preencha ambos os campos.');
    }
    if ($pw !== $pw2) {
        return redirect()->back()->with('error', 'As senhas não coincidem.');
    }
    return redirect()->to('/login')->with('status', 'Senha alterada com sucesso.');
});

// ─── Área da Empresa (requer login) ───────────────────────────────────────────
$routes->group('empresa', ['filter' => 'empresa_auth'], function ($routes) {
    $routes->get('',                     'Empresas::dashboard',  ['as' => 'empresa.dashboard']);
    $routes->get('perfil',               'Empresas::perfil',     ['as' => 'empresa.perfil']);
    $routes->post('perfil/salvar',       'Empresas::salvarPerfil');

    $routes->get('vagas',                'Empresas::vagas',      ['as' => 'empresa.vagas']);
    $routes->get('vagas/nova',           'Vagas::create',        ['as' => 'empresa.vagas.nova']);
    $routes->post('vagas/salvar',        'Vagas::salvar',        ['as' => 'empresa.vagas.salvar']);
    $routes->get('vagas/toggle/(:num)',  'Vagas::toggleStatus/$1');
    $routes->get('vagas/(:num)',         'Vagas::show/$1',       ['as' => 'empresa.vagas.show']);
    $routes->post('vagas/update/(:num)', 'Vagas::update/$1');
});
