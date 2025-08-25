<?php
include("db.php");

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $id_autor = $_POST['id_autor'];

    // Validação básica (PHP)
    $anoAtual = date("Y");
    if ($ano_publicacao <= 1500 || $ano_publicacao > $anoAtual) {
        $mensagem = "Ano de publicação inválido (deve ser >1500 e <= $anoAtual)";
    } else {
        $sql = "INSERT INTO livros (titulo, genero, ano_publicacao, id_autor)
                VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $titulo, $genero, $ano_publicacao, $id_autor);

        if ($stmt->execute()) {
            $mensagem = "Livro cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar: " . $conn->error;
        }
    }
}

// Buscar autores para o select
$autores = $conn->query("SELECT id_autor, nome FROM autores");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Livro</title>
</head>
<body>
    <h1>Cadastrar Livro</h1>
    <a href="index.php">Voltar</a>

    <?php if($mensagem) echo "<p><strong>$mensagem</strong></p>"; ?>

    <form method="POST">
        <label>Título:</label><br>
        <input type="text" name="titulo" required><br><br>

        <label>Gênero:</label><br>
        <input type="text" name="genero"><br><br>

        <label>Ano de Publicação:</label><br>
        <input type="number" name="ano_publicacao" required><br><br>

        <label>Autor:</label><br>
        <select name="id_autor" required>
            <option value="">Selecione</option>
            <?php while($row = $autores->fetch_assoc()){ ?>
                <option value="<?=$row['id_autor']?>"><?=$row['nome']?></option>
            <?php } ?>
        </select><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>