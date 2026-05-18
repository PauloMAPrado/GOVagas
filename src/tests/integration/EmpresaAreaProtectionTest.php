<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * Garante que visitantes (usuários comuns) não acessam a área da empresa.
 */
final class EmpresaAreaProtectionTest extends CIUnitTestCase
{
    use FeatureTestTrait;
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'App';

    public static function rotasEmpresaProvider(): array
    {
        return [
            'dashboard'      => ['empresa', 'GET'],
            'perfil'           => ['empresa/perfil', 'GET'],
            'vagas'            => ['empresa/vagas', 'GET'],
            'nova vaga'        => ['empresa/vagas/nova', 'GET'],
            'salvar perfil'    => ['empresa/perfil/salvar', 'POST'],
            'salvar vaga'      => ['empresa/vagas/salvar', 'POST'],
        ];
    }

    /**
     * @dataProvider rotasEmpresaProvider
     */
    public function testVisitanteNaoAcessaRotasEmpresa(string $uri, string $method): void
    {
        $result = $method === 'POST'
            ? $this->post($uri)
            : $this->get($uri);

        $result->assertRedirect();
        $this->assertStringContainsString('login', $result->getRedirectUrl());
        $result->assertSessionMissing('logado');
    }

    public function testSessaoIncompletaNaoAcessaAreaEmpresa(): void
    {
        $this->withSession(['logado' => true]);

        $result = $this->get('empresa');

        $result->assertRedirect();
        $this->assertStringContainsString('login', $result->getRedirectUrl());
    }

    public function testAposLogoutNaoAcessaAreaEmpresa(): void
    {
        $result = $this->get('logout');

        $result->assertRedirect();
        $result->assertSessionMissing('logado');

        $bloqueio = $this->get('empresa/perfil');

        $bloqueio->assertRedirect();
        $this->assertStringContainsString('login', $bloqueio->getRedirectUrl());
    }

    public function testVisitanteAcessaPaginasPublicas(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('login')->assertStatus(200);
        $this->get('cadastro')->assertStatus(200);
    }
}
