# Biblioteca - Banco de Dados

Este projeto cria o banco de dados `biblioteca` com tabelas e triggers para gerenciar autores, livros, leitores e empréstimos.

---

## Como rodar no XAMPP

### 1. Instalar e iniciar o XAMPP

- Faça o download e instale o [XAMPP](https://www.apachefriends.org/pt_br/index.html) para seu sistema operacional.
- Abra o painel do XAMPP.
- Inicie os módulos **Apache** e **MySQL** clicando em "Start".

### 2. Acessar o phpMyAdmin

- No navegador, acesse: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Aqui você pode criar bancos de dados e executar scripts SQL.

---

## Como criar o banco e as tabelas

### 1. Criar banco de dados e tabelas

- No phpMyAdmin, clique em **SQL** no menu superior.
- Copie e cole o script SQL fornecido (arquivo `.sql` com a criação das tabelas e triggers).
- Clique em **Executar**.

---

## Como configurar a conexão com o banco em PHP

Crie um arquivo PHP para conectar ao banco com o seguinte código (exemplo):

```php
<?php
$host = "localhost";
$user = "root";
$password = "root";    // Senha padrão do MySQL no XAMPP geralmente é vazia, ajuste se necessário
$dbname = "biblioteca_leo";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
} else {
    echo "Conectado com sucesso!";
}
?>
