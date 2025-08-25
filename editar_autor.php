<?php
include("db.php");

$id = $_GET['id'] ?? 0;
$mensagem = "";

// Buscar dados do autor
$sql = "SELECT * FROM autores WHERE id_autor=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Autor não encontrado!");
}

$autor = $result->fetch_assoc();

// Se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $nacionalidade = $_POST['nacionalidade'];
    $ano_nascimento = $_POST['ano_nascimento'];

    if (empty($nome)) {
        $mensagem = "O campo Nome é obrigatório!";
    } else {
        $sql = "UPDATE autores SET nome=?, nacionalidade=?, ano_nascimento=? WHERE id_autor=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $nome, $nacionalidade, $ano_nascimento, $id);

        if ($stmt->execute()) {
            $mensagem = "Autor atualizado com sucesso!";
            $autor = [
                'nome' => $nome,
                'nacionalidade' => $nacionalidade,
                'ano_nascimento' => $ano_nascimento
            ];
        } else {
            $mensagem = "Erro ao atualizar: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Autor</title>
</head>
<body>
    <h1>Editar Autor</h1>
    <a href="index.php">Voltar</a>

    <?php if($mensagem) echo "<p><strong>$mensagem</strong></p>"; ?>

    <form method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?=$autor['nome']?>" required><br><br>

        <label>Nacionalidade:</label><br>
        <input type="text" name="nacionalidade" value="<?=$autor['nacionalidade']?>"><br><br>

        <label>Ano de Nascimento:</label><br>
        <input type="number" name="ano_nascimento" value="<?=$autor['ano_nascimento']?>"><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>