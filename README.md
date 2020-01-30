# Bem vindo ao Projeto API SLIM com Docker e JWT

## Para trabalhar com esse projeto você precisa ter instalado:
- Docker;
- PHP 7 ou superior;
- Composer (gerenciador de pacotes do PHP);

## Setup inicial
Para iniciar o projeto basta:
- Fazer um git clone do projeto para sua máquina;
- Executar o comando ``composer install`` na raiz do projeto. O comando irá baixar as dependencias do projeto;
- Executar o comando ``php setup.php`` na raiz do projeto. Este processo criará os arquivos de configuração do banco de dados e da JWT;
- Levantar o serviço com o comando ``docker-compose -f "dockerfiles/dev/docker-compose.yml" up -d --build`` na raiz do projeto;
- Executar o comando ``./phinx migrate`` na raiz do projeto. Isto criará as instancias do banco de dados;
- Executar o comando ``./phinx seed:run`` na raiz do projeto. Isto irá inserir dados de usuários testes no banco de dados;


Pronto! Agora sua ``API`` deve estar disponível na ``porta 80`` e o serviço de gerenciamento de banco, ``PhpMyAdmin``, na ``porta 8001``.

## XDEBUG PHP VSCODE
Se você possui o VSCode instalado as configurações do XDebug estão prontas na pasta .vscode na raiz do projeto

## Rotas
As Rotas estão disponíveis na pasta ``routes/`` na raiz do projeto. O formato de entrega de dados está sendo informado na rota ``hello-world``;

## Regra das requisições

### *Todas as requisições devem ser tratadas pelos ``Controllers`` sem a interação direta da rota com a ``Model``;*