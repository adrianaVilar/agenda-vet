<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/Style.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Agenda Vet</title>
</head>
<body>
    <?php 
        session_start();
        if(!$_SESSION['logado']) {
            header("Location: Login.php");
            exit;
        }
    ?>
<div class="container">
    <!-- Aba lateral -->
    <div class="sidebar form-container">
        <form id="logout" action="Logout.php" method="POST">
            <button class="logout-btn" id="logout" >
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>

        <div class="profile">
            <img src="../imgs/Foto.png" alt="Foto do Usuário" class="profile-photo">
            <h3>Nome do Usuário</h3>
            <p><strong>Pets:</strong> 2 gatos, 1 cachorro</p>
            <form action="../php/Support.php" method="POST">
                <label for="support">Entre em contato:</label>
                <input type="text" id="support" name="support" required>
                <button type="submit" name="send">Enviar</button>

                <h3 id="side-alert" name="side-alert" style="display: none;"></h3>
            </form>
        </div>
    </div>

    <!-- Agenda -->
    <div class="agenda">
        <div class="agenda-header">
            <button class="btn" id="prev-week">&#x2039;</button>
            <h2 id="week-label"> </h2>
            <button class="btn" id="next-week">&#x203A;</button>
        </div>

        <table class="agenda-table">
            <thead></thead>
            <tbody>
                
            </tbody>
        </table>
    
        <form id="schedule-form" action="Save.php" method="POST">

            <!-- Campos escondidos para enviar os dados -->
            <input type="hidden" name="id" id="appointment-id">
            <input type="hidden" name="day" id="selected-day">
            <input type="hidden" name="time" id="selected-time">

            <!-- Modal Salvar e Editar -->
            <div id="modal" class="modal">
                <div class="modal-content form-container">
                    <span class="close">&times;</span>
                    <h2>Detalhes da Consulta</h2>
                    
                    <label for="pet-name">Nome do Pet:</label>
                    <input type="text" id="pet-name" name="pet-name" required>

                    <label for="pet-age">Idade:</label>
                    <input type="text" id="pet-age" name="pet-age" required>

                    <label for="consulta-motivo">Motivo da Consulta:</label>
                    <textarea type="text" id="consulta-motivo" name="consulta-motivo" required></textarea>

                    <button type="button" id="save-button" name="save-button" style="display: none;"></button>
                </div>
            </div>

            <!-- Modal Cancelar -->
                <div id="confirm-modal" class="modal">
                <div class="modal-content form-container">
                    <span class="close" id="close-confirm-modal">&times;</span>
                    <p>Deseja realmente cancelar esta consulta?</p>
                    <div class="modal-buttons">
                        <button id="confirm-cancel" class="btn-confirm">Sim</button>
                        <button id="cancel-cancel" class="btn-cancel">Não</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="../js/MarkAppointment.js"></script>
<script src="../js/Agenda.js"></script>

</body>
</html>