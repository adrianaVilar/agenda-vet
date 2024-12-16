<?php
// Conexão com o banco de dados
$servername = "127.0.0.1";
$username = "admin";
$password = "admin";
$dbname = "agenda";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Busca os dados no banco
session_start();
$id_usuario = $_SESSION['user_id']; // ID do usuário logado

// Recebe os dados do formulário
$data = explode(' - ', $_POST['day'])[0]; // Extrai apenas a data
$hora = explode(' - ', $_POST['time'])[0]; // Extrai apenas a hora
$idade = $_POST['pet-age'];
$motivo = "Pet: " . $_POST['pet-name'] . ", " . $_POST['consulta-motivo']; // Combina as informações

$sth = $conn->prepare("UPDATE `consultas` SET `idade`=:idade,`motivo`=:motivo WHERE id = :id");

$sth->bindvalue(':idade', $idade);
$sth->bindvalue(':motivo', $motivo);
$id = substr($_POST['id'], 1);
$sth->bindvalue(':id', $id);

$sth->execute();

header("Location: Agenda.php");

?>