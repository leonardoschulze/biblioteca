<?php
include("db.php");

$tipo = $_GET['tipo'] ?? 'ativos';

if($tipo=='ativos'){
    $sql = "SELECT e.*, l.titulo, le.nome AS leitor
            FROM emprestimos e
            JOIN livros l ON e.id_livro=l.id_livro
            JOIN leitores le ON e.id_leitor=le.id_leitor
            WHERE e.data_devolucao IS NULL";
} else {
    $sql = "SELECT e.*, l.titulo, le.nome AS leitor
            FROM emprestimos e
            JOIN livros l ON e.id_livro=l.id_livro
            JOIN leitores le ON e.id_leitor=le.id_leitor
            WHERE e.data_devolucao IS NOT NULL";
}
$result = $conn->query($sql);
?>
<h1>Empréstimos <?=ucfirst($tipo)?></h1>
<a href="?tipo=ativos">Ativos</a> | <a href="?tipo=concluidos">Concluídos</a>
<a href="cadastrar_emprestimo.php">Novo Empréstimo</a>
<table border="1">
<tr><th>ID</th><th>Livro</th><th>Leitor</th><th>Data Empréstimo</th><th>Data Devolução</th></tr>
<?php while($row=$result->fetch_assoc()){ ?>
<tr>
  <td><?=$row['id_emprestimo']?></td>
  <td><?=$row['titulo']?></td>
  <td><?=$row['leitor']?></td>
  <td><?=$row['data_emprestimo']?></td>
  <td><?=$row['data_devolucao']?></td>
</tr>
<?php } ?>
</table>