<?php
include("db.php");

$id = $_GET['id'] ?? 0;

// Se não houver ID, redireciona
if (!$id) {
    header("Location: index.php");
    exit;
}

// Buscar livro para exibir nome antes de excluir
$sql = "SELECT titulo FROM livros WHERE id_livro=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Livro não encontrado!");
}

$livro = $result->fetch_assoc();

// Se o formulário for enviado (confirmação)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM livros WHERE id_livro=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=Livro+excluido+com+sucesso");
        exit;
    } else {
        echo "Erro ao excluir: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Excluir Livro</title>
</head>
<body>
    <h1>Excluir Livro</h1>
    <p>Tem certeza que deseja excluir o livro <strong>"<?=$livro['titulo']?>"</strong>?</p>

    <form method="POST">
        <button type="submit">Sim, excluir</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>