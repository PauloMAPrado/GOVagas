<?php

$base = getenv('BASE_URL') ?: 'http://localhost';
$cookieFile = sys_get_temp_dir() . '/validate_usuario_cj.txt';

function httpRequest(string $method, string $url, array $post = []): array
{
    global $cookieFile;
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => true,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_COOKIEJAR      => $cookieFile,
        CURLOPT_COOKIEFILE     => is_file($cookieFile) ? $cookieFile : '',
    ]);
    if ($post !== []) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    $raw = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = (int) curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    curl_close($ch);
    $headers = substr((string) $raw, 0, $headerSize);
    $body = substr((string) $raw, $headerSize);
    $location = '';
    if (preg_match('/^Location:\s*(.+)$/mi', $headers, $m)) {
        $location = trim($m[1]);
    }
    return compact('status', 'location', 'body');
}

@unlink($cookieFile);
$page = httpRequest('GET', "{$base}/usuario/cadastro");
if ($page['status'] !== 200) {
    fwrite(STDERR, "FAIL cadastro page HTTP {$page['status']}\n");
    exit(1);
}
preg_match('/name="csrf_test_name"\s+value="([^"]+)"/', $page['body'], $m);
$csrf = $m[1] ?? null;
if (! $csrf) {
    fwrite(STDERR, "FAIL no CSRF\n");
    exit(1);
}

$cpf = '52998224725';
$post = httpRequest('POST', "{$base}/usuario/cadastro/salvar", [
    'csrf_test_name'       => $csrf,
    'nome_completo'        => 'Candidato Teste',
    'email'                => 'candidato_' . time() . '@teste.local',
    'cpf'                  => $cpf,
    'senha'                => 'senha123',
    'confirmacao_de_senha' => 'senha123',
    'estado'               => 'SP',
    'categoria'            => 'tecnologia',
    'tipo_contrato'        => 'CLT',
    'modalidade'           => 'Remoto',
]);

echo "POST status={$post['status']} location={$post['location']}\n";
if ($post['status'] !== 303 || stripos($post['location'], 'login') === false) {
    if (preg_match('/alert error[^>]*>([^<]+)/', $post['body'], $err)) {
        fwrite(STDERR, "Erro na pagina: " . trim($err[1]) . "\n");
    }
    fwrite(STDERR, "FAIL cadastro\n");
    exit(1);
}
echo "OK cadastro candidato\n";
