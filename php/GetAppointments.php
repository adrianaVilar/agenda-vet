<?php
header('Content-Type: application/json; charset=utf-8');
// session_start();
// ob_start(); // Garante que não haja saída antes do JSON
// include 'db_connection.php';

// // ID do usuário logado
// $userId = $_SESSION['user_id'];

session_start();

$servername = "127.0.0.1";
$username = "admin";
$password = "admin";
$dbname = "agenda";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Consulta para obter as consultas marcadas
$sth = $conn->prepare("SELECT c.data, c.hora, c.motivo, c.id_usuario FROM consultas c WHERE c.data BETWEEN :start AND :end");

$sth->bindValue(':start', $_GET['start_date']); // Início da semana
$sth->bindValue(':end', $_GET['end_date']);     // Fim da semana
$sth->execute();

$result = $sth->fetchAll(PDO::FETCH_ASSOC);

// Retorna os dados como JSON
echo json_encode($result);
?>
