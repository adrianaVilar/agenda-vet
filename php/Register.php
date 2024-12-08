<?php
// Conexão com o banco de dados
$servername = "127.0.0.1";
$username = "admin";
$password = "admin";
$dbname = "agenda";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Recebe os dados do formulário
$username = isset($_POST['name']) ? $_POST['name'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$userpassword = isset($_POST['password']) ? $_POST['password'] : null;

// Registro
if (isset($_POST['register'])) {
    try {
        $sth = $conn->prepare("INSERT INTO usuario (`nome`, `email`, `senha`) VALUES (:username, :email, MD5(:userpassword))");
        $sth->bindvalue(':username', $username);
        $sth->bindvalue(':email', $email);
        $sth->bindvalue(':userpassword', $userpassword);

        $sth->execute();

        // Redirecionar para a página de login após o cadastro
        header("Location: ../html/Login.html");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}

// Já possuo cadastro
if (isset($_POST['for-login'])) {
    header("Location: ../html/Login.html");
    exit;
}
?>