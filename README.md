Passos de instalação

--------------------------------------------------------

Requisitos Mínimos:

<b>Docker</b> / <b>Docker-Compose</b>

Caso não tenha:

<b>Docker:</b>
- sudo apt-get update && apt-get upgrade
- sudo apt install docker.io
- sudo usermod -aG docker USUARIO DA SUA MAQUINA
- Validar a instalação: docker --version

<b>Docker-Compose</b>
- sudo apt-get update && apt-get upgrade
- sudo apt install docker-compose
- Validar a instalação: docker-compose -version

--------------------------------------------------------

Passo 1:

    Clonar o git.

Passo 2:

    docker-compose up -d

Passo 3:

    Entrar no container:
    docker exec -it project_irroba /bin/bash

Passo 4:

    composer install && composer dump-autoload && php artisan optimize


Passo 5:

    (Adicionar a .env) - nano .env ( copiar o exemplo)
    chown www-data:www-data -R ../html
    chmod ug+wr -R ../html

Passo 6:

    exit - docker container
    docker-compose down && docker-compose up -d

Passo 7:

    Entra no container:
    docker exec -it project_irroba /bin/bash
    php artisan migrate --seed
    php artisan passport:keys && php artisan passport:install
    composer dump-autoload && php artisan optimize

-------------------------------------------------------------

Informações Adicionais:

Usuário para acesso no sistema:

- login: developer@app.com
- senha: password

Arquivo da collection no postman e demais documentações (DER - versão 2.0 é mais atual)

-------------------------------------------------------------

Este projeto foi hospedado dentro da AWS: http://54.233.133.32:8000/ (t2.micro, talvez possa gerar alguma lentidão extrema, pelo número de requisições)




