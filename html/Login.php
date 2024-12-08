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
    <h1>Faça seu login</h1>

    <form action="../php/Login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login">Entrar</button>
    </form>
</div>
    <script>
    <?php session_start(); ?>
    // Verificar se o usuário está logado e passar o ID para o JavaScript
    var loggedUserId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
    console.log("LOGGED: " + loggedUserId);
</script>
<script src="../js/Agenda.js"></script>
</body>
</html>