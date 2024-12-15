<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if(!$_SESSION['logado']) {
    header("Location: Login.php");
    exit;
}

$servername = "127.0.0.1";
$username = "admin";
$password = "admin";
$dbname = "agenda";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Consulta para obter as consultas marcadas
$sth = $conn->prepare("SELECT c.id, c.data, c.hora, c.motivo, c.id_usuario FROM consultas c WHERE c.id_usuario = :user_id");

$sth->bindValue(':user_id', $_SESSION['user_id']);      // ID do usuário logado
$sth->execute();

$result = $sth->fetchAll(PDO::FETCH_ASSOC);

// Retorna os dados como JSON
echo json_encode($result);
?>
