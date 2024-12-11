<?php
// Conexão com o banco de dados
$servername = "127.0.0.1";
$username = "admin";
$password = "admin";
$dbname = "agenda";

// Busca os dados no banco
$id_usuario = 2; // ID do usuário logado REVER!
$idade = 30; // Idade do usuário REVER!

// Recebe os dados do formulário
$data = explode(' - ', $_POST['day'])[0];
echo($data); // Extrai apenas a data
$hora = explode(' - ', $_POST['time'])[0]; // Extrai apenas a hora
$motivo = "Pet: " . $_POST['pet-name'] . ", " . $_POST['consulta-motivo']; // Combina as informações

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$sth = $conn->prepare("INSERT INTO consultas (`id_usuario`, `idade`, `data`, `hora`, `motivo`) VALUES (:id_usuario, :idade, :data_consulta, :hora, :motivo)");

$sth->bindvalue(':id_usuario', $id_usuario);
$sth->bindvalue(':idade', $idade);
$sth->bindvalue(':data_consulta', $data);
$sth->bindvalue(':hora', $hora);
$sth->bindvalue(':motivo', $motivo);

$sth->execute();

header("Location: Agenda.php");
// // Registro
// if (isset($_POST['save-button'])) {
//     try {
//         $sth = $conn->prepare("INSERT INTO consultas (`id_usuario`, `idade`, `data`, `hora`, `motivo`) VALUES (:id_usuario, :idade, :data_consulta, :hora, :motivo)");
//         $sth->bindvalue(':id_usuario', $id_usuario);
//         $sth->bindvalue(':idade', $idade);
//         $sth->bindvalue(':data_consulta', $data);
//         $sth->bindvalue(':hora', $hora);
//         $sth->bindvalue(':motivo', $motivo);

//         $sth->execute();

//         // Marcar a data e voltar para agenda
//         header("Location: ../html/Agenda.html");
//         exit;
//     } catch (PDOException $e) {
//         echo "Erro ao cadastrar: " . $e->getMessage();
//     }
// }

?>