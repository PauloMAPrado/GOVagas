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

5. Agora rode o comando:
```bash
docker exec -it -w /var/www/html vagas_app composer install
```

6. O Composer irá instalar as dependências do CodeIgniter 4

7. Agora você pode acessar o projeto no navegador através do endereço: http://localhost:8080
