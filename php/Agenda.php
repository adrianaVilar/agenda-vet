<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/Style.css"/>
    <title>Agenda Vet</title>
</head>
<body>
<div class="container">
    <!-- Aba lateral -->
        <div class="sidebar form-container">
            <div class="profile">
                <img src="../imgs/Foto.png" alt="Foto do Usuário" class="profile-photo">
                <h3>Nome do Usuário</h3>
                <p><strong>Pets:</strong> 2 gatos, 1 cachorro</p>
                <form action="../php/Support.php" method="POST">
                    <label for="support">Entre em contato:</label>
                    <input type="text" id="support" name="support" required>

                    <button type="submit" name="send">Enviar</button>
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

            <form id="schedule-form" action="SaveAppointment.php" method="POST">

                <table class="agenda-table">
                    <thead></thead>
                    <tbody>
                        
                    </tbody>
                </table>

                <!-- Campos escondidos para enviar os dados -->
                <input type="hidden" name="day" id="selected-day">
                <input type="hidden" name="time" id="selected-time">
                <button type="submit" id="submit-button" disabled>Confirmar Consulta</button>

                <!-- Modal -->
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Detalhes da Consulta</h2>
                      
                        <label for="pet-name">Nome do Pet:</label>
                        <input type="text" id="pet-name" name="pet-name" required>

                        <label for="consulta-motivo">Motivo da Consulta:</label>
                        <textarea id="consulta-motivo" name="consulta-motivo" required></textarea>

                        <button type="button" id="save-button" name="save-button">Salvar Consulta</button>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
<script src="../js/MarkAppointment.js"></script>
<script src="../js/Agenda.js"></script>

</body>
</html>