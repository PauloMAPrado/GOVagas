<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\EmpresaModel;

/**
 * Testes de integração do fluxo de autenticação de empresas.
 *
 * Cobre:
 *  - Exibição das páginas de login e cadastro
 *  - Cadastro com dados válidos e inválidos
 *  - Login com credenciais corretas e incorretas
 *  - Proteção de rotas privadas
 *  - Logout
 */
final class LoginTest extends CIUnitTestCase
{
    use FeatureTestTrait;
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'App';

    protected function setUp(): void
    {
        parent::setUp();
        $this->withSession();
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function withCsrf(array $data = []): array
    {
        return array_merge($data, [
            config('Security')->tokenName => csrf_hash(),
        ]);
    }

    private function criarEmpresa(string $cnpj = '12345678000100', string $senha = 'senha123'): array
    {
        (new EmpresaModel())->insert([
            'nome'     => 'Empresa Teste',
            'email'    => 'teste@empresa.com',
            'cnpj'     => $cnpj,
            'senha'    => $senha, // model faz hash via beforeInsert
            'whatsapp' => '11999999999',
        ]);

        return ['cnpj' => $cnpj, 'senha' => $senha];
    }

    // ── Páginas públicas ─────────────────────────────────────────────────────

    public function testPaginaLoginCarrega(): void
    {
        $result = $this->get('login');
        $result->assertStatus(200);
        $result->assertSee('Login');
    }

    public function testPaginaCadastroCarrega(): void
    {
        $result = $this->get('cadastro');
        $result->assertStatus(200);
        $result->assertSee('Cadastrar');
    }

    // ── Cadastro ─────────────────────────────────────────────────────────────

    public function testCadastroComDadosValidos(): void
    {
        $result = $this->post('cadastro/salvar', $this->withCsrf([
            'nome'                 => 'Nova Empresa',
            'email'                => 'nova@empresa.com',
            'cnpj'                 => '98765432000100',
            'senha'                => 'senha123',
            'confirmacao_de_senha' => 'senha123',
            'contato'              => '11988887777',
            'endereco'             => 'Rua Teste, 123',
            'link'                 => 'https://empresa.com',
        ]));

        $result->assertRedirect();
        $this->assertStringContainsString('login', $result->getRedirectUrl());
        $this->assertNotNull((new EmpresaModel())->where('email', 'nova@empresa.com')->first());
    }

    public function testCadastroComSenhasDivergentes(): void
    {
        $result = $this->post('cadastro/salvar', $this->withCsrf([
            'nome'                 => 'Empresa X',
            'email'                => 'x@empresa.com',
            'cnpj'                 => '11111111000100',
            'senha'                => 'senha123',
            'confirmacao_de_senha' => 'outrasenha',
            'contato'              => '11999999999',
        ]));

        $result->assertRedirect();
        $this->assertNull((new EmpresaModel())->where('email', 'x@empresa.com')->first());
    }

    public function testCadastroComEmailDuplicado(): void
    {
        $this->criarEmpresa();

        $result = $this->post('cadastro/salvar', $this->withCsrf([
            'nome'                 => 'Outra Empresa',
            'email'                => 'teste@empresa.com',
            'cnpj'                 => '99999999000100',
            'senha'                => 'senha123',
            'confirmacao_de_senha' => 'senha123',
            'contato'              => '11999999999',
        ]));

        $result->assertRedirect();
        $this->assertCount(1, (new EmpresaModel())->where('email', 'teste@empresa.com')->findAll());
    }

    // ── Login ─────────────────────────────────────────────────────────────────

    public function testLoginAposCadastro(): void
    {
        $cnpj = '98765432000100';

        $this->post('cadastro/salvar', $this->withCsrf([
            'nome'                 => 'Nova Empresa',
            'email'                => 'nova@empresa.com',
            'cnpj'                 => $cnpj,
            'senha'                => 'senha123',
            'confirmacao_de_senha' => 'senha123',
            'contato'              => '11988887777',
            'endereco'             => 'Rua Teste, 123',
            'link'                 => 'https://empresa.com',
        ]));

        $result = $this->post('login/autenticar', $this->withCsrf([
            'cnpj'  => $cnpj,
            'senha' => 'senha123',
        ]));

        $result->assertRedirect();
        $result->assertSessionHas('logado', true);
        $this->assertStringContainsString('empresa', $result->getRedirectUrl());
    }

    public function testLoginComCredenciaisCorretas(): void
    {
        $empresa = $this->criarEmpresa();

        $result = $this->post('login/autenticar', $this->withCsrf([
            'cnpj'  => $empresa['cnpj'],
            'senha' => $empresa['senha'],
        ]));

        $result->assertRedirect();
        $this->assertStringContainsString('empresa', $result->getRedirectUrl());
    }

    public function testLoginComSenhaErrada(): void
    {
        $this->criarEmpresa();

        $result = $this->post('login/autenticar', $this->withCsrf([
            'cnpj'  => '12345678000100',
            'senha' => 'senhaerrada',
        ]));

        $result->assertRedirect();
        $result->assertSessionMissing('logado');
    }

    public function testLoginComCnpjInexistente(): void
    {
        $result = $this->post('login/autenticar', $this->withCsrf([
            'cnpj'  => '00000000000000',
            'senha' => 'qualquercoisa',
        ]));

        $result->assertRedirect();
        $result->assertSessionMissing('logado');
    }

    // ── Proteção de rotas ─────────────────────────────────────────────────────

    public function testRotaEmpresaRedirecionaSemLogin(): void
    {
        $result = $this->get('empresa');
        $result->assertRedirect();
        $this->assertStringContainsString('login', $result->getRedirectUrl());
    }

    public function testRotaEmpresaVagasRedirecionaSemLogin(): void
    {
        $result = $this->get('empresa/vagas');
        $result->assertRedirect();
        $this->assertStringContainsString('login', $result->getRedirectUrl());
    }

    public function testRotaNovaVagaRedirecionaSemLogin(): void
    {
        $result = $this->get('empresa/vagas/nova');
        $result->assertRedirect();
        $this->assertStringContainsString('login', $result->getRedirectUrl());
    }

    // ── Logout ────────────────────────────────────────────────────────────────

    public function testLogoutEncerraSessionERedireciona(): void
    {
        $empresa = $this->criarEmpresa();

        $this->post('login/autenticar', $this->withCsrf([
            'cnpj'  => $empresa['cnpj'],
            'senha' => $empresa['senha'],
        ]));

        $result = $this->get('logout');
        $result->assertRedirect();
        $result->assertSessionMissing('logado');
    }
}
