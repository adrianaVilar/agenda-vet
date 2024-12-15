document.addEventListener("DOMContentLoaded", function () {
    const tableContainer = document.querySelector(".agenda-table");
    const theadRow = document.querySelector(".agenda-table thead");
    const weekLabel = document.getElementById("week-label");
    const submitButton = document.getElementById("submit-button");
    const modal = document.getElementById("modal");
    const closeModal = document.querySelector(".close");
    const saveAppointment = document.getElementById("save-button");
    const form = document.getElementById("schedule-form");
    const dayInput = document.getElementById("selected-day");
    const timeInput = document.getElementById("selected-time");
    const startHour = 8; // Hora inicial (8:00)
    const endHour = 18; // Hora final (18:00)
    const unavailableHours = [12, 13]; // Horários indisponíveis
    let currentDate = new Date(); // Data atual
    let loggedUserId = null;
    let dataId = null;
    let normalizedAppointments = null;

    function getWeekDates(date) {
        const startOfWeek = new Date(date);
        startOfWeek.setDate(date.getDate() - date.getDay() + 1); // Segunda-feira
        return Array.from({ length: 5 }, (_, i) => {
            const day = new Date(startOfWeek);
            day.setDate(startOfWeek.getDate() + i);
            return day;
        });
    }

    async function fetchScheduledAppointments(startDate, endDate) {
        try {
            const response = await fetch(`../php/GetAppointments.php?start_date=${startDate}&end_date=${endDate}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error("Erro ao buscar consultas:", error);
            return [];
        }
    }

    async function updateAgenda() {
        const weekDates = getWeekDates(currentDate);
        theadRow.innerHTML = '';
        // Atualizar o rótulo da semana
        const start = weekDates[0].toLocaleDateString("pt-BR");
        const end = weekDates[4].toLocaleDateString("pt-BR");
        const startDateEN = weekDates[0].toLocaleDateString("pt-BR").split("/").reverse().join("-");
        const endDateEN = weekDates[4].toLocaleDateString("pt-BR").split("/").reverse().join("-");
        weekLabel.textContent = `Semana: ${start} - ${end}`;

        // Atualizar cabeçalho
        const th = document.createElement("th");
        th.textContent = "Horários";  // Cabeçalho fixo para horários
        theadRow.appendChild(th);

        // Dias abreviados no cabeçalho
        weekDates.forEach((day) => {
            const th = document.createElement("th");
            th.textContent = day.toLocaleDateString("pt-BR", { weekday: "short" });
            theadRow.appendChild(th);
        });

        // Atualizar corpo da tabela
        const tbody = document.querySelector(".agenda-table tbody");
        tbody.innerHTML = '';  // Limpa o corpo anterior

        let appointments = await fetchScheduledAppointments(startDateEN, endDateEN);

        // Normalizar os dados vindos do banco
        normalizedAppointments = appointments.map(app => ({
            data: new Date(`${app["data"]?.trim()}` + "T" + `${app["hora"]?.trim()}`).getTime(), // Remove caracteres invisíveis e transforma em Date
            hora: app["hora"]?.trim(),
            id_usuario: app["id_usuario"]?.trim(),
            motivo: app["motivo"]?.trim(),
            id: app["id"]?.trim()
        }));

        for (let hour = startHour; hour <= endHour; hour++) {
            const row = document.createElement("tr");

            // Primeira coluna fixa: horários
            const timeCell = document.createElement("td");
            timeCell.textContent = `${hour.toString().padStart(2, "0")}:00`;
            row.appendChild(timeCell);

            // Colunas dos dias da semana
            weekDates.forEach((day) => {
                const cell = document.createElement("td");
                const availableSlots = document.querySelectorAll(".available");
                const date = new Date(`${day.toLocaleDateString("pt-BR").split("/").reverse().join("-")}` + "T" + `${hour.toString().padStart(2, "0")}:00`).getTime();
                const today = new Date();
                const isPast = new Date(date) < today || (new Date(date).toDateString() === today.toDateString() && hour <= today.getHours());

            const appointment = normalizedAppointments.find(app => app.data === date);

            if (appointment) {
                fetch('session.php')
                    .then(response => response.json())
                    .then(loggedUserId => {
                        if (loggedUserId.user_id === appointment.id_usuario) {
                            cell.innerHTML = `
                                <button class="edit-button" data-id="e${appointment.id}" >✏️</button>
                                <button class="cancel-button" data-id="c${appointment.id}" >❌</button><br>
                                <span class="occupied">Marcado</span>
                            `;
                            cell.dataset.date = date;
                        } else {
                            cell.textContent = "Ocupado";
                            cell.classList.add("disabled");
                        }
                    })
                    .catch(error => console.error('Erro ao obter os dados da sessão:', error));
            } else if (!unavailableHours.includes(hour) && !isPast) {
                cell.classList.add("available");
                cell.textContent = "Disponível";
                cell.dataset.date = date;
                cell.dataset.time = `${hour.toString().padStart(2, "0")}:00`;
            } else {
                cell.classList.add("disabled");
                cell.textContent = "-";
            }

            availableSlots.forEach(slot => {
                slot.addEventListener("click", function () {
                    removeSelected();

                    // Marca o horário clicado como selecionado
                    this.classList.add("selected");

                    // Atualiza os campos ocultos do formulário
                    const a = new Date(Number(this.dataset.date));
                    const formattedDate = new Intl.DateTimeFormat("en-CA").format(a); 
                    dayInput.value = formattedDate;
                    timeInput.value = this.dataset.time;

                    // Habilita o botão de envio
                    submitButton.disabled = false;
                    submitButton.classList.add("activated");
                    submitButton.textContent = "Confirmar consulta";
                });
            });

            row.appendChild(cell);
        });

        tbody.appendChild(row);
        
        }
    }

    // Eventos para editar e cancelar
    tableContainer.addEventListener("click", function (event) {
        if (event.target.classList.contains("edit-button")) {
            dataId = event.target.dataset.id; // Recupera o data-id do botão clicado
            console.log(`Botão edit clicado! Data-id: ${dataId}`);
            document.getElementById("appointment-id").value = dataId; // Atualiza o campo oculto no formulário
            handleEditAppointment(); // Chama a função de edição
        }
    });

    // Função de edição
    function handleEditAppointment() {
        removeSelected();

        // Habilita o botão de envio
        submitButton.disabled = false;
        submitButton.classList.add("activated");
        submitButton.textContent = "Editar consulta";
    }

    document.querySelectorAll(".cancel-button").forEach(button => {
        console.log("aqui");
        button.addEventListener("click", handleCancelAppointment);
    });

    function handleCancelAppointment(event) {
        removeSelected();

        const appointmentId = event.target.dataset.id;
        console.log(appointmentId);

        if (confirm("Deseja realmente cancelar esta consulta?")) {
            fetch(`../php/DeleteAppointment.php?id=${appointmentId}`, { method: "POST" })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Consulta cancelada com sucesso!");
                        updateAgenda(); // Atualiza a agenda
                    } else {
                        alert("Erro ao cancelar a consulta.");
                    }
                })
                .catch(error => {
                    console.error("Erro ao cancelar a consulta:", error);
                });
        }
    }

    // Navegação entre semanas
    document.getElementById("prev-week").addEventListener("click", () => {
        currentDate.setDate(currentDate.getDate() - 7);
        updateAgenda();
    });

    document.getElementById("next-week").addEventListener("click", () => {
        currentDate.setDate(currentDate.getDate() + 7);
        updateAgenda();
    });

    updateAgenda();

    // Abre o modal ao clicar em "Confirmar/Editar Consulta"
    submitButton.addEventListener("click", function (event) {
        event.preventDefault();
        modal.style.display = "block";

            console.log("data id => " + dataId);

        if(dataId != null) {
            saveAppointment.style.display = "block";
            form.action = "EditAppointment.php";
            saveAppointment.textContent = "Salvar edição"
        } else {
            saveAppointment.style.display = "block";
            form.action = "SaveAppointment.php";
            saveAppointment.textContent = "Salvar consulta"
        }
    });

    // Fecha o modal
    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
        saveAppointment.style.display = "none";
        dataId = null;
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // Salva os dados e envia o formulário
    saveAppointment.addEventListener("click", function () {
        document.getElementById("selected-day").value = dayInput.value;
        document.getElementById("selected-time").value = timeInput.value;

        form.submit();
        modal.style.display = "none";
    });

    // Função para remover seleção anterior do dia
    function removeSelected() {
        document.querySelectorAll(".selected").forEach(selected => {
            selected.classList.remove("selected");
        });
    }
});