#!/bin/sh
set -e

BASE="${BASE_URL:-http://localhost}"
COOKIE="/tmp/validate_cj"
CNPJ="${TEST_CNPJ:-11222333000181}"
EMAIL="validacao_$(date +%s)@teste.local"

echo "=== 1. Carregar pagina de cadastro ==="
HTML=$(curl -s -c "$COOKIE" -b "$COOKIE" "$BASE/cadastro")
TOKEN=$(echo "$HTML" | sed -n 's/.*name="csrf_test_name" value="\([^"]*\)".*/\1/p' | head -1)

if [ -z "$TOKEN" ]; then
    echo "FAIL: token CSRF nao encontrado"
    exit 1
fi
echo "OK: CSRF obtido"

echo "=== 2. POST cadastro/salvar ==="
curl -s -c "$COOKIE" -b "$COOKIE" \
  -X POST "$BASE/cadastro/salvar" \
  -D /tmp/cad_headers \
  -o /tmp/cad_body \
  -d "csrf_test_name=$TOKEN" \
  -d "nome=Empresa Validacao" \
  -d "email=$EMAIL" \
  -d "cnpj=$CNPJ" \
  -d "senha=senha123" \
  -d "confirmacao_de_senha=senha123" \
  -d "contato=11999998888" \
  -d "endereco=Rua Teste 1" \
  -d "link=https://empresa.com"

CAD_STATUS=$(head -1 /tmp/cad_headers | awk '{print $2}')
CAD_LOC=$(grep -i "^Location:" /tmp/cad_headers | tr -d '\r' || true)
echo "Status: $CAD_STATUS"
echo "Redirect: $CAD_LOC"

if [ "$CAD_STATUS" != "303" ] && [ "$CAD_STATUS" != "302" ]; then
    echo "FAIL: cadastro nao redirecionou"
    head -20 /tmp/cad_body
    exit 1
fi
echo "$CAD_LOC" | grep -q "login" || { echo "FAIL: redirect nao aponta para login"; exit 1; }
echo "OK: cadastro redireciona para login"

echo "=== 3. POST login/autenticar ==="
LOGIN_HTML=$(curl -s -c "$COOKIE" -b "$COOKIE" "$BASE/login")
TOKEN2=$(echo "$LOGIN_HTML" | sed -n 's/.*name="csrf_test_name" value="\([^"]*\)".*/\1/p' | head -1)

curl -s -c "$COOKIE" -b "$COOKIE" \
  -X POST "$BASE/login/autenticar" \
  -D /tmp/login_headers \
  -o /tmp/login_body \
  -d "csrf_test_name=$TOKEN2" \
  -d "cnpj=$CNPJ" \
  -d "senha=senha123"

LOGIN_STATUS=$(head -1 /tmp/login_headers | awk '{print $2}')
LOGIN_LOC=$(grep -i "^Location:" /tmp/login_headers | tr -d '\r' || true)
echo "Status: $LOGIN_STATUS"
echo "Redirect: $LOGIN_LOC"

if [ "$LOGIN_STATUS" != "303" ] && [ "$LOGIN_STATUS" != "302" ]; then
    echo "FAIL: login nao redirecionou"
    head -20 /tmp/login_body
    exit 1
fi
echo "$LOGIN_LOC" | grep -q "empresa" || { echo "FAIL: redirect nao aponta para area empresa"; exit 1; }
echo "OK: login redireciona para dashboard"

echo "=== 4. Verificar registro no banco ==="
php -r "
require '/var/www/html/vendor/autoload.php';
\$db = \Config\Database::connect();
\$row = \$db->table('empresas')->where('email', '$EMAIL')->get()->getRowArray();
if (! \$row) { echo 'FAIL: empresa nao encontrada' . PHP_EOL; exit(1); }
echo 'OK: empresa id=' . \$row['id'] . ' cnpj=' . \$row['cnpj'] . PHP_EOL;
"

echo ""
echo "=== VALIDACAO COMPLETA: SUCESSO ==="
