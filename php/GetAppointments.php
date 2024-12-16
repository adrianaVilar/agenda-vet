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
$sth = $conn->prepare("SELECT c.id, c.data, c.hora, c.motivo, c.id_usuario FROM consultas c WHERE c.data BETWEEN :start AND :end");

$sth->bindValue(':start', $_GET['start_date']); // Início da semana
$sth->bindValue(':end', $_GET['end_date']);     // Fim da semana
$sth->execute();

// Retorna todos os dados do banco
$result = $sth->fetchAll(PDO::FETCH_ASSOC);

// Variáveis para filtrar os dados
$loggedUserId = $_SESSION['user_id']; // ID do usuário logado

// Processa os resultados
$response = [];

foreach ($result as $row) {
    // Verifica se o agendamento pertence ao usuário logado
    if ($row['id_usuario'] == $loggedUserId) {
        // Se for do usuário logado, adiciona o agendamento completo
        $response[] = $row;
    } else {
        // Se não for do usuário logado, retorna apenas data e hora
        $response[] = [
            'data' => $row['data'],
            'hora' => $row['hora'],
            'motivo' => null,  // Campos não logados como null
            'id_usuario' => null,  // Campos não logados como null
            'id' => '-1'  // ID como -1
        ];
    }
}

echo json_encode($response);
?>