<?php
session_start();

$servername = "127.0.0.1";
$username = "admin";
$password = "admin";
$dbname = "agenda";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

if (isset($_POST['login'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $userpassword = isset($_POST['password']) ? $_POST['password'] : null;

    try {
        // Verifica as credenciais
        $sth = $conn->prepare("SELECT id, nome FROM usuario WHERE email = :email AND senha = MD5(:userpassword)");
        $sth->bindvalue(':email', $email);
        $sth->bindvalue(':userpassword', $userpassword);
        $sth->execute();

        $user = $sth->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Armazena informações do usuário na sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nome'];
            $_SESSION['logado'] = true;

            // Redireciona para a página inicial
            header("Location: Agenda.php");
            exit;
        } else {
            echo "Email ou senha inválidos.";
        }
    } catch (PDOException $e) {
        echo "Erro ao verificar login: " . $e->getMessage();
    }
}
?>
