<?php
$host = "localhost";
$user = "root";
$password = "root";
$dbname = "biblioteca_leo";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>