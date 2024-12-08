document.addEventListener("DOMContentLoaded", function () {
    const theadRow = document.querySelector(".agenda-table thead");
    const weekLabel = document.getElementById("week-label");
    const startHour = 8; // Hora inicial (8:00)
    const endHour = 18; // Hora final (18:00)
    const unavailableHours = [12, 13]; // Horários indisponíveis
    let currentDate = new Date(); // Data atual

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
            return await response.json();
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
        weekLabel.textContent = `Semana: ${start} - ${end}`;

        // Atualizar cabeçalho
        const th = document.createElement("th");
        th.textContent = "Horários";  // Cabeçalho fixo para horários
        theadRow.appendChild(th);

        weekDates.forEach((day) => {
            const th = document.createElement("th");
            th.textContent = day.toLocaleDateString("pt-BR", { weekday: "short" });
            theadRow.appendChild(th);
        });

        // Atualizar corpo da tabela
        const tbody = document.querySelector(".agenda-table tbody");
        tbody.innerHTML = '';  // Limpa o corpo anterior

        const appointments = await fetchScheduledAppointments(
            weekDates[0].toISOString().split('T')[0],
            weekDates[4].toISOString().split('T')[0]
        );

        for (let hour = startHour; hour <= endHour; hour++) {
            const row = document.createElement("tr");

            // Primeira coluna fixa: horário
            const timeCell = document.createElement("td");
            timeCell.textContent = `${hour.toString().padStart(2, "0")}:00`;
            row.appendChild(timeCell);

            // Colunas dos dias da semana
            weekDates.forEach((day) => {
                const cell = document.createElement("td");
            //     const today = new Date();
                const date = day.toLocaleDateString("pt-BR").split("/").reverse().join("-"); // AAAA-MM-DD
            //     const isPast = new Date(date) < today || (new Date(date).toDateString() === today.toDateString() && hour <= today.getHours());
            //     const availableSlots = document.querySelectorAll(".available");
            //     const dayInput = document.getElementById("selected-day");
            //     const timeInput = document.getElementById("selected-time");
            //     const submitButton = document.getElementById("submit-button");

            //     if (unavailableHours.includes(hour) || isPast) {
            //         cell.classList.add("disabled");
            //         cell.textContent = "-";
            //     } else {
            //         cell.classList.add("available");
            //         cell.dataset.date = date;
            //         cell.dataset.time = `${hour.toString().padStart(2, "0")}:00`;
            //         cell.textContent = "Disponível";
                    
            //         availableSlots.forEach(slot => {
            //             slot.addEventListener("click", function () {
            //                 // Remove seleção anterior
            //                 document.querySelectorAll(".selected").forEach(selected => {
            //                     selected.classList.remove("selected");
            //                 });

            //                 // Marca o horário clicado como selecionado
            //                 this.classList.add("selected");

            //                 // Atualiza os campos ocultos do formulário
            //                 dayInput.value = this.dataset.date;
            //                 timeInput.value = this.dataset.time;

            //                 // Habilita o botão de envio
            //                 submitButton.disabled = false;
            //             });
            //         });
            //     }
            //     row.appendChild(cell);
            // });
            // tbody.appendChild(row);
        //}

            const appointment = appointments.find(app => app.data === date && app.hora === `${hour.toString().padStart(2, "0")}:00`);

            if (appointment) {
                if (appointment.id_usuario === loggedUserId) {
                    cell.innerHTML = `
                        <span class="occupied">Ocupado</span>
                        <button class="edit-button" data-id="${appointment.id}">✏️</button>
                        <button class="cancel-button" data-id="${appointment.id}">❌</button>
                    `;
                } else {
                    cell.textContent = "Indisponível";
                    cell.classList.add("disabled");
                }
            } else if (!unavailableHours.includes(hour)) {
                cell.classList.add("available");
                cell.textContent = "Disponível";
                cell.dataset.date = date;
                cell.dataset.time = `${hour.toString().padStart(2, "0")}:00`;
            } else {
                cell.classList.add("disabled");
                cell.textContent = "-";
            }
            row.appendChild(cell);
        });

        tbody.appendChild(row);
        
        console.log("Logged User ID:", loggedUserId);
        }
    }

    // Eventos para editar e cancelar
    document.querySelectorAll(".edit-button").forEach(button => {
        button.addEventListener("click", handleEditAppointment);
    });

    document.querySelectorAll(".cancel-button").forEach(button => {
        button.addEventListener("click", handleCancelAppointment);
    });

    function handleEditAppointment(event) {
        const appointmentId = event.target.dataset.id;
        // Mostra o modal de edição com os dados do horário
        openEditModal(appointmentId);
    }

    function handleCancelAppointment(event) {
        const appointmentId = event.target.dataset.id;

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
});
