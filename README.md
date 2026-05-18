Instruções iniciais para clonar o projeto usando apenas os arquivos:

'Dockerfile'
'docker-compose.yml'

# Clonando o projeto
1. Crie um diretório para o projeto e navegue até ele

2. Abra o terminal no diretorio contendo os arquivos citados acima

3. Rode o comando:
```bash
docker-compose up -d
```

4. O Docker irá baixar as imagens necessárias e iniciar os containers

5. Agora rode o comando para instalar as dependências do CodeIgniter 4:
```bash
docker exec -it -w /var/www/html vagas_app composer install
```

6. Crie o arquivo .env na raiz do seu projeto (copie o arquivo env padrão e renomeie para .env) e coloque as credenciais do banco de dados configuradas no seu docker-compose.

7. Crie o arquivo .env na raiz do seu projeto (copie o arquivo env padrão e renomeie para .env) e coloque as credenciais do banco de dados configuradas no seu docker-compose.
```bash
docker exec -it -w /var/www/html vagas_app php spark migrate
```

8. Agora você pode acessar o projeto no navegador através do endereço: http://localhost:8080
