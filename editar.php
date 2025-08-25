<?php
include("db.php");

$id = $_GET['id'] ?? 0;
$mensagem = "";

// Buscar dados do livro
$sql = "SELECT * FROM livros WHERE id_livro=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Livro não encontrado!");
}

$livro = $result->fetch_assoc();

// Buscar autores para o select
$autores = $conn->query("SELECT id_autor, nome FROM autores");

// Se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $id_autor = $_POST['id_autor'];

    $anoAtual = date("Y");
    if ($ano_publicacao <= 1500 || $ano_publicacao > $anoAtual) {
        $mensagem = "Ano de publicação inválido (deve ser >1500 e <= $anoAtual)";
    } else {
        $sql = "UPDATE livros SET titulo=?, genero=?, ano_publicacao=?, id_autor=? WHERE id_livro=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $titulo, $genero, $ano_publicacao, $id_autor, $id);

        if ($stmt->execute()) {
            $mensagem = "Livro atualizado com sucesso!";
            // Atualiza dados na tela
            $livro = [
                'titulo' => $titulo,
                'genero' => $genero,
                'ano_publicacao' => $ano_publicacao,
                'id_autor' => $id_autor
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
    <title>Editar Livro</title>
</head>
<body>
    <h1>Editar Livro</h1>
    <a href="index.php">Voltar</a>

    <?php if($mensagem) echo "<p><strong>$mensagem</strong></p>"; ?>

    <form method="POST">
        <label>Título:</label><br>
        <input type="text" name="titulo" value="<?=$livro['titulo']?>" required><br><br>

        <label>Gênero:</label><br>
        <input type="text" name="genero" value="<?=$livro['genero']?>"><br><br>

        <label>Ano de Publicação:</label><br>
        <input type="number" name="ano_publicacao" value="<?=$livro['ano_publicacao']?>" required><br><br>

        <label>Autor:</label><br>
        <select name="id_autor" required>
            <?php while($row = $autores->fetch_assoc()){ ?>
                <option value="<?=$row['id_autor']?>" <?=($livro['id_autor']==$row['id_autor']?'selected':'')?>>
                    <?=$row['nome']?>
                </option>
            <?php } ?>
        </select><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>