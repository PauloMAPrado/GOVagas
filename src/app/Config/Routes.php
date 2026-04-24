<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('img/(:any)', 'Assets::image/$1');
$routes->get('/', 'Home::index');
$routes->get('/register', 'Empresas::create');
$routes->get('/login', 'Home::login');

// Empresas CRUD
$routes->get('empresas', 'Empresas::index');
$routes->get('empresas/edit/(:num)', 'Empresas::edit/$1');
$routes->get('empresas/delete/(:num)', 'Empresas::delete/$1');
$routes->post('empresas/store', 'Empresas::store');
$routes->post('empresas/update/(:num)', 'Empresas::update/$1');
$routes->post('register', 'Empresas::store');

// Vagas
$routes->get('vagas/(:num)', 'Vagas::show/$1');
$routes->post('vagas/salvar', 'Vagas::salvar');
// Formulário para nova vaga
$routes->get('vagas/novo', 'Vagas::create');
// Update vaga
$routes->post('vagas/update/(:num)', 'Vagas::update/$1');

// Recuperar senha (view de teste)
$routes->get('recuperar-senha', function() {
	return view('pages/rec_senha');
});

// Handler de teste para envio do formulário (flash message)

$routes->post('recuperar/enviar', function() {
	$request = \Config\Services::request();
	$email = trim((string) $request->getPost('email'));

	// Validação simples de formato de e-mail
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return redirect()->to('/recuperar-senha')->with('error', 'E-mail inválido. Informe um endereço de e-mail válido.');
	}

	// Aqui você integraria com envio de código por e-mail.
	// Para testes, apenas redirecionamos para a página de nova senha.
	return redirect()->to('/nova-senha')->with('status', 'E-mail válido. Insira a nova senha.');
});

// Página para inserir nova senha
$routes->get('nova-senha', function() {
	return view('pages/nova_senha');
});

// Handler de teste para confirmar a nova senha
$routes->post('nova-senha/confirm', function() {
	$request = \Config\Services::request();
	$pw = (string) $request->getPost('password');
	$pw2 = (string) $request->getPost('password_confirm');

	if ($pw === '' || $pw2 === '') {
		return redirect()->back()->with('error', 'Preencha ambos os campos de senha.');
	}
	if ($pw !== $pw2) {
		return redirect()->back()->with('error', 'As senhas não coincidem.');
	}

	// Aqui você atualizaria a senha no banco. Para teste, redirecionamos ao login.
	return redirect()->to('/login')->with('status', 'Senha alterada com sucesso. Faça login.');
});
