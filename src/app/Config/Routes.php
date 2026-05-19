<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('img/(:any)', 'Assets::image/$1');

// Públicas
$routes->get('/', 'Home::index');
$routes->get('vagas/(:num)', 'Vagas::show/$1', ['as' => 'vaga.show']);

// Autenticação empresa
$routes->get('login', 'AuthController::login', ['as' => 'login']);
$routes->post('login/autenticar', 'AuthController::autenticar', ['as' => 'login.autenticar']);
$routes->get('cadastro', 'AuthController::cadastro', ['as' => 'cadastro']);
$routes->post('cadastro/salvar', 'AuthController::salvarCadastro');
$routes->get('logout', 'AuthController::logout');

// Recuperação de senha
$routes->get('recuperar-senha', 'AuthController::recuperarSenha');
$routes->post('recuperar/enviar', 'AuthController::enviarRecuperacao');
$routes->get('nova-senha', 'AuthController::novaSenha');
$routes->post('nova-senha/confirm', 'AuthController::confirmarNovaSenha');

// Autenticação candidato
$routes->get('usuario/cadastro', 'UsuarioAuth::cadastro', ['as' => 'usuario.cadastro']);
$routes->post('usuario/cadastro/salvar', 'UsuarioAuth::salvarCadastro', ['as' => 'usuario.cadastro.salvar']);
$routes->get('usuario/login', 'UsuarioAuth::login', ['as' => 'usuario.login']);
$routes->post('usuario/login/autenticar', 'UsuarioAuth::autenticar', ['as' => 'usuario.login.autenticar']);

$routes->group('usuario', ['filter' => 'usuario_auth'], static function ($routes) {
    $routes->get('perfil', 'Usuarios::perfil', ['as' => 'usuario.perfil']);
    $routes->post('perfil/salvar', 'Usuarios::salvarPerfil', ['as' => 'usuario.perfil.salvar']);
});

// Vagas sugeridas
$routes->get('vagas-sugeridas', 'VagasSugeridas::index', ['as' => 'vagas.sugeridas']);

// Área da empresa (requer login)
$routes->group('empresa', ['filter' => 'empresa_auth'], function ($routes) {
    $routes->get('', 'Empresas::dashboard', ['as' => 'empresa.dashboard']);
    $routes->get('perfil', 'Empresas::perfil', ['as' => 'empresa.perfil']);
    $routes->post('perfil/salvar', 'Empresas::salvarPerfil');

    $routes->get('vagas', 'Empresas::vagas');
    $routes->get('vagas/nova', 'Vagas::create');
    $routes->post('vagas/salvar', 'Vagas::salvar');
    $routes->get('vagas/toggle/(:num)', 'Vagas::toggleStatus/$1');
    $routes->get('vagas/(:num)', 'Vagas::show/$1');
    $routes->post('vagas/update/(:num)', 'Vagas::update/$1');
});
