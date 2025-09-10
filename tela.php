<?php
session_start(); 

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head> 
</head>
<body>
    <h1>Sistema Biblioteca</h1>
    <nav>
        <a href="autores.php">Autores</a> |
        <a href="livros.php">Livros</a> |
        <a href="leitor.php">Leitores</a> |
        <a href="emprestimo.php">Empréstimos</a>
    </nav>

    <?php if (!empty($_SESSION["user_id"])): ?>
      <div class="card">
        <h3>Bem-vindo, <?= htmlspecialchars($_SESSION["username"]) ?>!</h3>
        <p>Sessão ativa.</p>
        <p><a href="?logout=1">Sair</a></p>
      </div>
    <?php else: ?>
      <p>Você não está logado.</p>
    <?php endif; ?>
</body>
</html>