// Marcar consulta
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modal");
    const closeModal = document.querySelector(".close");
    const confirmButton = document.getElementById("submit-button");
    const saveButton = document.getElementById("save-button");

    // Abre o modal ao clicar em "Confirmar Consulta"
    confirmButton.addEventListener("click", function (event) {
        event.preventDefault();
        modal.style.display = "block";
    });

    // Fecha o modal
    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // Salva os dados e envia o formulário
    saveButton.addEventListener("click", function () {
        const petName = document.getElementById("pet-name").value;
        const consultaMotivo = document.getElementById("consulta-motivo").value;

        if (petName && consultaMotivo) {
            // Concatena os dados e insere no campo "motivo" do formulário
            document.getElementById("selected-day").value += ` - Pet: ${petName}`;
            document.getElementById("selected-time").value += ` - Motivo: ${consultaMotivo}`;
            
            // Envia o formulário principal
            document.getElementById("schedule-form").submit();
        } else {
            alert("Preencha todos os campos!");
        }
    });
});
