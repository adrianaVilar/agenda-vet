<?php
session_start();

if(!$_SESSION['logado']) {
    header("Location: Login.php");
    exit;
}

// // Conexão com o banco de dados
// $servername = "127.0.0.1";
// $username = "admin";
// $password = "admin";
// $dbname = "agenda";

// // Busca os dados no banco
// session_start();
// $id_usuario = $_SESSION['user_id']; // ID do usuário logado REVER!

// // Recebe os dados do formulário
// $data = explode(' - ', $_POST['day'])[0]; // Extrai apenas a data
// $hora = explode(' - ', $_POST['time'])[0]; // Extrai apenas a hora
// $idade = $_POST['pet-age'];
// $motivo = "Pet: " . $_POST['pet-name'] . ", " . $_POST['consulta-motivo']; // Combina as informações

// $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// $sth = $conn->prepare("INSERT INTO consultas (`id_usuario`, `idade`, `data`, `hora`, `motivo`) VALUES (:id_usuario, :idade, :data_consulta, :hora, :motivo)");

// $sth->bindvalue(':id_usuario', $id_usuario);
// $sth->bindvalue(':idade', $idade);
// $sth->bindvalue(':data_consulta', $data);
// $sth->bindvalue(':hora', $hora);
// $sth->bindvalue(':motivo', $motivo);

// $sth->execute();

// header("Location: Agenda.php");



echo json_encode($_SESSION);
?>