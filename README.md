
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Projeto Laravel+API+RestFul+Swagger

### Requisitos: 
+ PHP 8.2
+ Composer
+ SGDB baseado em MySQL
+ Git

### Modulos necesários
+ mysqli
+ pdo_mysql
+ sodium
+ curl
+ fileinfo
+ xdebug
## Instalação

1. Faça o clone do projeto com gitclone

```bash
  git clone https://github.com/camilasouz0/cadastro-colaboradores.git
```

2. Faça a Instalação do projeto utilizando o seguinte comando

```bash
  composer install
```

3. Crie o arquivo de variáveis de ambiente utilizando o seguinte comando

```bash
  cp .env.example .env
```

5. Crie a secret do JWT e em seguida rode as migrações utilizando os seguintes comandos

```bash
  php artisan jwt:secret
  php artisan migrate
```

6. Execute o servidor artisan para rodar localmente

```bash
  php artisan serve
```
    
## Variáveis de Ambiente

Para rodar esse projeto, você vai precisar alterar as seguintes variáveis de ambiente no seu .env

`DB_HOST`
`DB_DATABASE`
`DB_USERNAME`
`DB_PASSWORD`

Configurar as variáveis para envio de e-mail
`MAIL_MAILER=smtp`
`MAIL_HOST=smtp.gmail.com`
`MAIL_PORT=465`
`MAIL_USERNAME=seuemail@empresa.com`
`MAIL_PASSWORD="chave-autenticação-dois-fatores"`
`MAIL_ENCRYPTION=tls`
`MAIL_FROM_ADDRESS=seuemail@empresa.com`
`MAIL_FROM_NAME="Cadastro de Colaboradores"`

Configurar as variáveis para salvar o upload de arquivo CSV
`AWS_ACCESS_KEY_ID=access-key-id`
`AWS_SECRET_ACCESS_KEY=secret-access-key`
`AWS_DEFAULT_REGION=us-east-1`
`AWS_BUCKET=employee`
`AWS_ENDPOINT=http://localhost:9000`
`AWS_USE_PATH_STYLE_ENDPOINT=false`

## Documentação da API

Executar o comando
```
sudo ./swagger.sh
```
+ A doc Swagger se encontra disponível em http://localhost:8000/api/documentation
+ Todas as requisições devem conter o seguinte header :

## EXECUTAR TESTES (PHPUNIT)
No terminal para executar todos os testes execute o comando:
```
php artisan test
```

## Licença
The Laravel framework is open-sourced software licensed under the [MIT license](https://choosealicense.com/licenses/mit/) .
