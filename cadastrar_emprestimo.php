<?php
include("db.php");

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_livro = $_POST['id_livro'];
    $id_leitor = $_POST['id_leitor'];
    $data_emprestimo = $_POST['data_emprestimo'];
    $data_devolucao = $_POST['data_devolucao'];

    // Validação básica
    if (empty($id_livro) || empty($id_leitor) || empty($data_emprestimo)) {
        $mensagem = "Preencha todos os campos obrigatórios!";
    } else {
        $sql = "INSERT INTO emprestimos (id_livro, id_leitor, data_emprestimo, data_devolucao)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $id_livro, $id_leitor, $data_emprestimo, $data_devolucao);

        if ($stmt->execute()) {
            $mensagem = "Empréstimo cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar: " . $conn->error;
        }
    }
}

// Buscar livros e leitores para preencher os selects
$livros = $conn->query("SELECT id_livro, titulo FROM livros");
$leitores = $conn->query("SELECT id_leitor, nome FROM leitores");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Empréstimo</title>
</head>
<body>
    <h1>Cadastrar Empréstimo</h1>
    <a href="index.php">Voltar</a>

    <?php if($mensagem) echo "<p><strong>$mensagem</strong></p>"; ?>

    <form method="POST">
        <label>Livro:</label><br>
        <select name="id_livro" required>
            <option value="">Selecione</option>
            <?php while($row = $livros->fetch_assoc()){ ?>
                <option value="<?=$row['id_livro']?>"><?=$row['titulo']?></option>
            <?php } ?>
        </select><br><br>

        <label>Leitor:</label><br>
        <select name="id_leitor" required>
            <option value="">Selecione</option>
            <?php while($row = $leitores->fetch_assoc()){ ?>
                <option value="<?=$row['id_leitor']?>"><?=$row['nome']?></option>
            <?php } ?>
        </select><br><br>

        <label>Data de Empréstimo:</label><br>
        <input type="date" name="data_emprestimo" required><br><br>

        <label>Data de Devolução (prevista):</label><br>
        <input type="date" name="data_devolucao"><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>