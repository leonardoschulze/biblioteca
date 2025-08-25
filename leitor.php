<?php
include("db.php");

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if (empty($nome)) {
        $mensagem = "O campo Nome é obrigatório!";
    } else {
        $sql = "INSERT INTO leitores (nome, email, telefone) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, $telefone);

        if ($stmt->execute()) {
            $mensagem = "Leitor cadastrado com sucesso!";
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
    <title>Cadastrar Leitor</title>
</head>
<body>
    <h1>Cadastrar Leitor</h1>
    <a href="index.php">Voltar</a>

    <?php if($mensagem) echo "<p><strong>$mensagem</strong></p>"; ?>

    <form method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <label>Telefone:</label><br>
        <input type="text" name="telefone"><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>