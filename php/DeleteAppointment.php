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
$id = $_POST['id'];

$sth = $conn->prepare("DELETE FROM consultas WHERE id = :id");
$sth->bindValue(':id', $id);

if ($sth->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}

?>
