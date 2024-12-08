<?php
// Verifique se o usuário está logado e se o ID está na sessão
session_start();
if (isset($_SESSION['user_id'])) {
    $loggedUserId = $_SESSION['user_id'];
} else {
    $loggedUserId = null; // ou qualquer outro valor padrão se não estiver logado
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/Style.css"/>
    <title>Agenda Vet</title>
</head>
<body>
    <div class="form-container">
        <h1>Faça seu cadastro</h1>

        <form action="../php/Register.php" method="POST">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="register">Cadastrar</button>
            <a href="../html/Login.php">Já possuo cadastro</a>
        </form>
    </div>
</body>
</html>
