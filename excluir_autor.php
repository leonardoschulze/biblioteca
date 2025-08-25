<?php
include("db.php");

$id = $_GET['id'] ?? 0;

if (!$id) {
    header("Location: index.php");
    exit;
}

// Buscar autor para mostrar antes da exclusão
$sql = "SELECT nome FROM autores WHERE id_autor=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Autor não encontrado!");
}

$autor = $result->fetch_assoc();

// Se confirmar exclusão
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM autores WHERE id_autor=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=Autor+excluido+com+sucesso");
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
    <title>Excluir Autor</title>
</head>
<body>
    <h1>Excluir Autor</h1>
    <p>Tem certeza que deseja excluir o autor <strong>"<?=$autor['nome']?>"</strong>?</p>

    <form method="POST">
        <button type="submit">Sim, excluir</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>