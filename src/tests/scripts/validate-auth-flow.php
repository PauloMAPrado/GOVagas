<?php

/**
 * Validação HTTP do fluxo cadastro → login (executar no container).
 * Uso: php tests/scripts/validate-auth-flow.php
 */

$base  = getenv('BASE_URL') ?: 'http://localhost';
$cnpj  = getenv('TEST_CNPJ') ?: '11222333000181';
$email = 'validacao_' . time() . '@teste.local';
$cookieFile = sys_get_temp_dir() . '/validate_cj.txt';

function httpRequest(string $method, string $url, array $post = [], bool $saveCookies = true, bool $sendCookies = true): array
{
    global $cookieFile;

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => true,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_FOLLOWLOCATION => false,
    ]);

    if ($saveCookies) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    }
    if ($sendCookies && is_file($cookieFile)) {
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    }
    if ($post !== []) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }

    $raw      = curl_exec($ch);
    $status   = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = (int) curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    curl_close($ch);

    $headers = substr((string) $raw, 0, $headerSize);
    $body    = substr((string) $raw, $headerSize);

    $location = '';
    if (preg_match('/^Location:\s*(.+)$/mi', $headers, $m)) {
        $location = trim($m[1]);
    }

    return ['status' => $status, 'location' => $location, 'body' => $body, 'headers' => $headers];
}

function extractCsrf(string $html): ?string
{
    if (preg_match('/name="csrf_test_name"\s+value="([^"]+)"/', $html, $m)) {
        return $m[1];
    }

    return null;
}

function fail(string $message): void
{
    fwrite(STDERR, "FAIL: {$message}\n");
    exit(1);
}

function ok(string $message): void
{
    echo "OK: {$message}\n";
}

@unlink($cookieFile);

echo "=== 1. Carregar pagina de cadastro ===\n";
$cadastro = httpRequest('GET', "{$base}/cadastro");
if ($cadastro['status'] !== 200) {
    fail("cadastro retornou HTTP {$cadastro['status']}");
}
$csrf = extractCsrf($cadastro['body']);
if ($csrf === null) {
    fail('token CSRF nao encontrado em /cadastro');
}
ok('CSRF obtido');

echo "=== 2. POST cadastro/salvar ===\n";
$save = httpRequest('POST', "{$base}/cadastro/salvar", [
    'csrf_test_name'       => $csrf,
    'nome'                 => 'Empresa Validacao',
    'email'                => $email,
    'cnpj'                 => $cnpj,
    'senha'                => 'senha123',
    'confirmacao_de_senha' => 'senha123',
    'contato'              => '11999998888',
    'endereco'             => 'Rua Teste 1',
    'link'                 => 'https://empresa.com',
]);
echo "Status: {$save['status']}\nRedirect: {$save['location']}\n";

if (! in_array($save['status'], [302, 303], true)) {
    fail("cadastro nao redirecionou (HTTP {$save['status']})");
}
if (stripos($save['location'], 'login') === false) {
    fail('redirect do cadastro nao aponta para login');
}
ok('cadastro redireciona para login');

echo "=== 3. POST login/autenticar ===\n";
$loginPage = httpRequest('GET', "{$base}/login");
if ($loginPage['status'] !== 200) {
    fail("login retornou HTTP {$loginPage['status']}");
}
$csrf2 = extractCsrf($loginPage['body']);
if ($csrf2 === null) {
    fail('token CSRF nao encontrado em /login');
}

$auth = httpRequest('POST', "{$base}/login/autenticar", [
    'csrf_test_name' => $csrf2,
    'cnpj'           => $cnpj,
    'senha'          => 'senha123',
]);
echo "Status: {$auth['status']}\nRedirect: {$auth['location']}\n";

if (! in_array($auth['status'], [302, 303], true)) {
    fail("login nao redirecionou (HTTP {$auth['status']})");
}
if (stripos($auth['location'], 'empresa') === false) {
    fail('redirect do login nao aponta para area empresa');
}
ok('login redireciona para dashboard');

echo "=== 4. Verificar registro no banco ===\n";
$db = new mysqli('db', 'vagas_user', 'vagas_password', 'vagas_db', 3306);
if ($db->connect_error) {
    fail('conexao com banco: ' . $db->connect_error);
}
$stmt = $db->prepare('SELECT id, cnpj FROM empresas WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$row    = $result->fetch_assoc();
$stmt->close();
$db->close();

if ($row === null) {
    fail('empresa nao encontrada no banco');
}
ok("empresa id={$row['id']} cnpj={$row['cnpj']}");

echo "\n=== VALIDACAO COMPLETA: SUCESSO ===\n";
