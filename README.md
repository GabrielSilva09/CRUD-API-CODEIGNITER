# CRUD API REST utilizando PHP 8.2 e CodeIgniter 4

## Sobre o projeto

Projeto desenvolvido para teste e estudo, colocando em prática conhecimento em criação e consumo de APIs, PHP, POO, CodeIgniter, conceitos de rotas e padrões MVC.

Projeto foi desenvolvido em menos de um dia, utilizando diversos conhecimentos e aprofundando bastante em CodeIgniter e APIs, utilizei Xampp para criação do banco de dados MySQL, composer para baixar os pacotes e frameworks necessários, Postman para testes de consumo da API e VS Code para toda a programação.

O objetivo principal do projeto é criar diversos endpoints com funcionalidades de CRUD para clientes, pedidos e produtos, permitindo-se fazer as 4 operações básicas de um banco de dados através do consumo da API, também foi implementado a filtragem dos dados exibidos de cada tabela do banco de dados através do ID, sendo possível mostrar um registro específico ou obter todos da tabela. Também foi implementado um sistema simples de Token para as ações de criação, exclusão e atualização das tabelas, onde o token deve ser mandado através do cabeçalho nas requisições feitas à API.

O banco de dados foi criado a partir da ferramenta Xampp, utilizando a porta local padrão para funcionamento de um banco de dados local, sendo assim é necessário que para testar você crie um banco de dados local em sua máquina, utilizando as informações disponibilizadas nestas intruções.

A criação das tabelas do banco de dados foi feita utilizando migrations do framework CodeIgniter, facilitando assim a utilização do código para testes em máquinas diversas, apenas sendo necessário que o banco de dados esteja operando no mesmo local, mesma porta, com mesmo nome e credenciais de acesso que constam nas variáveis de ambiente do projeto, podendo ser acessadas no arquivo "app\Config\Database.php", sendo necessário que elas sejam alteradas para o seu ambiente específico ou que o seu ambiente se adeque a elas.

Foram criadas 3 tabelas, sendo as de clientes, de produtos e de pedidos, o id do cliente e o id do produto são vistos pela tabela de pedidos como chaves estrangeiras, sendo assim, no momento de criação de pedidos, os ids utilizados para clientes e produtos já devem existir para que a modelagem do banco seja respeitada.

Mais abaixo explico os requisitos necessários para o teste e como fazê-lo.

## Requisitos para testar funcionamento

-PHP 8.2
-Composer
-Banco de dados MySQL (utilizei o xampp)
-App que consuma API (Ex. Postman)
-Editor de código de sua preferência

## Como utilizar a API

Para poder utilizar a API você deve baixar as dependências do projeto utilizando o composer, adequar seu ambiente de banco de dados as variáveis contidas no arquivo "app\Config\Database.php" ou alterar as variáveis para que se adequem ao seu ambiente. Sendo estas as configurações mais importantes do DB:

        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'ci4api',
        'DBDriver' => 'MySQLi',
        'port'     => 3306,

As tabelas do banco de dados podem ser criadas utilizando as migrations contidas no projeto, sendo esse um facilitador no momento de configuração do ambiente.

Após essas configurações simples, você pode rodar o projeto no seu servidor localhost:8000 utilizando o comando "php -S localhost:8000" no terminal de sua preferência, aberto na pasta public do projeto.

Com a API em funcionamento você pode iniciar os testes de requisições para a API. Utilizando o Postman, basta fazer as requisições corretas, seguindo os padrões corretos nas endpoints corretas, sempre colocando no cabeçalho das requisições o token correto.

token = a1b2c3d4e5f6g7

Nas requisições onde dados são enviados, devem sempre seguir o protocolo JSON em seu formato e utilizar a padronização que está detalhada no próximo tópico.

Caso as requisições sejam feitas corretamente, a API sempre irá devolver os dados solicitados ou mensagens de confirmação necessárias, bem como se alguma requisição der errado será mostrado uma mensagem de erro, contendo a principal causa do problema.

## Lista de endpoints e padrões para envio de dados

### Padrão de retorno

O retorno padrão para todas as requisições é o seguinte:

{

    "cabecalho": {

        "status": 200, // Protocolos HTTP (200, 404, 403, 401 e etc...)

        "mensagem": "Dados retornados com sucesso" // mensagem de retorno para informar o usuário que acessou a api

    },

    "retorno": { // todos os dados consultados e/ou cadastrados devem ser retornados neste campo

    }

}

### EndPoints e padrões Clientes

#### Método GET

localhost:8000/clientes -> Retorna todos os clientes cadastrados no banco de dados.<br>
localhost:8000/clientes/{id} -> Retorna o cliente cujo id seja o mesmo da URL.

#### Método POST

localhost:8000/criar-cliente -> Faz o cadastro de um novo cliente no banco de dados e retorna uma mensagem de sucesso ou falha.<br>
OBS.: Para esta requisição dar certo deve se seguir o padrão abaixo, alterando apenas seus valores e também é necessário enviar no cabeçalho da requisição o seguinte token "token=a1b2c3d4e5f6g7".

{
    "parametros": [
        {"nome_razaosocial": "Jhon",
        "cpf_cnpj": "12345678999"}
    ]
}

#### Método PUT

localhost:8000/atualizar-cliente/{id} -> Atualiza os dados do cliente cujo o ID está sendo passado na URL e retorna uma mensagem de sucesso ou falha.<br>
OBS.: Para esta requisição dar certo deve se seguir o padrão abaixo, alterando apenas seus valores e também é necessário enviar no cabeçalho da requisição o seguinte token "token=a1b2c3d4e5f6g7".

{
    "nome_razaosocial": "Jhon",
    "cpf_cnpj": "12345678999"        
}

#### Método DELETE

localhost:8000/excluir-cliente/{id} -> Exclui os dados do cliente cujo o ID está sendo passado na URL e retorna uma mensagem de sucesso ou falha. <br>
OBS.: É necessário enviar no cabeçalho da requisição o seguinte token "token=a1b2c3d4e5f6g7".


### EndPoints Produtos

#### Método GET

localhost:8000/produtos -> Retorna todos os produtos cadastrados no banco de dados.<br>
localhost:8000/produtos/{id} -> Retorna o produto cujo id seja o mesmo da URL.

#### Método POST

localhost:8000/criar-produto -> Faz o cadastro de um novo produto no banco de dados e retorna uma mensagem de sucesso ou falha.<br> 
OBS.: Para esta requisição dar certo deve se seguir o padrão abaixo, alterando apenas seus valores e também é necessário enviar no cabeçalho da requisição o seguinte token "token=a1b2c3d4e5f6g7".

{
    "parametros": [
        {"nomeproduto": "caneca",
        "valor": "50",
        "categoria": "cozinha",
        "custo": "25"}
    ]
}

#### Método PUT

localhost:8000/atualizar-produto/{id} -> Atualiza os dados do produto cujo o ID está sendo passado na URL e retorna uma mensagem de sucesso ou falha.<br> 
OBS.: Para esta requisição dar certo deve se seguir o padrão abaixo, alterando apenas seus valores e também é necessário enviar no cabeçalho da requisição o seguinte token "token=a1b2c3d4e5f6g7".

{
    "nomeproduto": "caneca",
    "valor": "50",
    "categoria": "cozinha",
    "custo": "25"       
}

#### Método DELETE

localhost:8000/excluir-produto/{id} -> Exclui os dados do produto cujo o ID está sendo passado na URL e retorna uma mensagem de sucesso ou falha.<br> 
OBS.: É necessário enviar no cabeçalho da requisição o seguinte token "token=a1b2c3d4e5f6g7".

### EndPoints  Pedidos

#### Método GET

localhost:8000/pedidos -> Retorna todos os pedidos cadastrados no banco de dados.<br>
localhost:8000/pedidos/{id} -> Retorna o pedido cujo id seja o mesmo da URL.

#### Método POST

localhost:8000/criar-pedido -> Faz o cadastro de um novo pedido no banco de dados e retorna uma mensagem de sucesso ou falha. <br>
OBS.: Para esta requisição dar certo deve se seguir o padrão abaixo, alterando apenas seus valores e também é necessário enviar no cabeçalho da requisição o seguinte token "token=a1b2c3d4e5f6g7".<br>
OBS2.: Os campos "cliente_id" e "produto_id" fazem ligação aos ids de registros feitos nas tabelas de cliente e produto, sendo assim ambos devem existir em suas tabelas antes da criação do pedido.

{
    "parametros": [
        {"cliente_id": "2",
        "produto_id": "1",
        "valorpedido": "30",
        "formapagamento": "dinheiro",
        "status": "Em aberto"}
    ]
}

#### Método PUT

localhost:8000/atualizar-pedido/{id} -> Atualiza os dados do pedido cujo o ID está sendo passado na URL e retorna uma mensagem de sucesso ou falha. <br>
OBS.: Para esta requisição dar certo deve se seguir o padrão abaixo, alterando apenas seus valores e também é necessário enviar no cabeçalho da requisição o seguinte token "token=a1b2c3d4e5f6g7".<br>
OBS2.: Os campos "cliente_id" e "produto_id" fazem ligação aos ids de registros feitos nas tabelas de cliente e produto, sendo assim ambos devem existir em suas tabelas antes da alteração do pedido.

{
    "cliente_id": "2",
    "produto_id": "1",
    "valorpedido": "30",
    "formapagamento": "dinheiro",
    "status": "Em aberto"        
}

#### Método DELETE

localhost:8000/excluir-pedido/{id} -> Exclui os dados do pedido cujo o ID está sendo passado na URL e retorna uma mensagem de sucesso ou falha. <br>
OBS.: É necessário enviar no cabeçalho da requisição o seguinte token "token=a1b2c3d4e5f6g7".
