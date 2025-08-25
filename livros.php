<?php
include("db.php");

$filtroGenero = $_GET['genero'] ?? '';
$filtroAutor = $_GET['autor'] ?? '';
$filtroAno = $_GET['ano'] ?? '';

$where = [];
if($filtroGenero) $where[] = "l.genero LIKE '%$filtroGenero%'";
if($filtroAutor) $where[] = "a.nome LIKE '%$filtroAutor%'";
if($filtroAno) $where[] = "l.ano_publicacao = '$filtroAno'";

$whereSQL = count($where) ? "WHERE ".implode(" AND ", $where) : "";

$sql = "SELECT l.*, a.nome AS autor_nome FROM livros l
        JOIN autores a ON l.id_autor=a.id_autor
        $whereSQL";
$result = $conn->query($sql);
?>
<h1>Livros</h1>
<form method="get">
    Gênero: <input name="genero" value="<?=$filtroGenero?>">
    Autor: <input name="autor" value="<?=$filtroAutor?>">
    Ano: <input name="ano" value="<?=$filtroAno?>">
    <button>Filtrar</button>
</form>
<a href="cadastrar.php">Novo Livro</a>
<table border="1">
<tr><th>ID</th><th>Título</th><th>Gênero</th><th>Ano</th><th>Autor</th><th>Ações</th></tr>
<?php while($row=$result->fetch_assoc()){ ?>
<tr>
  <td><?=$row['id_livro']?></td>
  <td><?=$row['titulo']?></td>
  <td><?=$row['genero']?></td>
  <td><?=$row['ano_publicacao']?></td>
  <td><?=$row['autor_nome']?></td>
  <td>
    <a href="editar.php?id=<?=$row['id_livro']?>">Editar</a>
    <a href="excluir.php?id=<?=$row['id_livro']?>" onclick="return confirm('Excluir?')">Excluir</a>
  </td>
</tr>
<?php } ?>
</table>