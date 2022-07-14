
# Instruções para testar o projeto

```bash
# Clone o projeto
$ git clone https://github.com/Jonabsfx/discount-api.git discount-api

# Vá para a pasta do projeto
$ cd discount-api

# Crie uma cópia do arquivo de configurações
$ cp .env.example .env

# Edite os campos abaixo no seu arquivo .env para configurar a base de dados.

APP_NAME=API-Discount
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=admin
DB_PASSWORD=password

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Suba os containers do projeto
$ docker-compose up -d

# Acesse o container do projeto
$ docker-compose exec api bash

# Instale as dependências do projeto
$ composer install

# Gere a chave do projeto
$ php artisan key:generate

# O projeto já tem algumas seeders preparadas. Para utilizá-las:
$ php artisan migrate

# Rodar os testes de integração
$ php artisan test

# Documentação dos endpoints do projeto:
https://documenter.getpostman.com/view/20691336/UzQuNQwK
