<?php
include("db.php");

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 5;
$inicio = ($pagina-1) * $limite;

$result = $conn->query("SELECT * FROM autores LIMIT $inicio,$limite");
$total = $conn->query("SELECT COUNT(*) as t FROM autores")->fetch_assoc()['t'];
?>
<h1>Autores</h1>
<a href="cadastrar_autor.php">Novo Autor</a>
<table border="1">
<tr><th>ID</th><th>Nome</th><th>Nacionalidade</th><th>Ano Nasc</th><th>Ações</th></tr>
<?php while($row=$result->fetch_assoc()){ ?>
<tr>
  <td><?=$row['id_autor']?></td>
  <td><?=$row['nome']?></td>
  <td><?=$row['nacionalidade']?></td>
  <td><?=$row['ano_nascimento']?></td>
  <td>
    <a href="editar_autor.php?id=<?=$row['id_autor']?>">Editar</a>
    <a href="excluir_autor.php?id=<?=$row['id_autor']?>" onclick="return confirm('Excluir?')">Excluir</a>
  </td>
</tr>
<?php } ?>
</table>
<?php
$totalPaginas = ceil($total/$limite);
for($i=1;$i<=$totalPaginas;$i++){
  echo "<a href='?pagina=$i'>$i</a> ";
}
?>