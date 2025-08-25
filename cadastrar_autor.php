<?php
include("db.php");

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $nacionalidade = $_POST['nacionalidade'];
    $ano_nascimento = $_POST['ano_nascimento'];

    // Validação simples
    if (empty($nome)) {
        $mensagem = "O campo Nome é obrigatório!";
    } else {
        $sql = "INSERT INTO autores (nome, nacionalidade, ano_nascimento) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $nacionalidade, $ano_nascimento);

        if ($stmt->execute()) {
            $mensagem = "Autor cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Autor</title>
</head>
<body>
    <h1>Cadastrar Autor</h1>
    <a href="index.php">Voltar</a>

    <?php if($mensagem) echo "<p><strong>$mensagem</strong></p>"; ?>

    <form method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Nacionalidade:</label><br>
        <input type="text" name="nacionalidade"><br><br>

        <label>Ano de Nascimento:</label><br>
        <input type="number" name="ano_nascimento" placeholder="Ex: 1980"><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>