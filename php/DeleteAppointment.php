<?php
include 'db_connection.php';

if(!$_SESSION['logado']) {
    header("Location: Login.php");
    exit;
}

$id = $_POST['id'];
$query = $conn->prepare("DELETE FROM consultas WHERE id = :id");
$query->bindValue(':id', $id);

if ($query->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
?>
