// // Marcar consulta
// document.addEventListener("DOMContentLoaded", function () {
//     const modal = document.getElementById("modal");
//     const closeModal = document.querySelector(".close");
//     const confirmButton = document.getElementById("submit-button");
//     const saveAppointment = document.getElementById("save-button");
//     const editAppointment = document.getElementById("edit-button");

//     // Abre o modal ao clicar em "Confirmar/Editar Consulta"
//     confirmButton.addEventListener("click", function (event) {
//         event.preventDefault();
//         modal.style.display = "block";
//         saveAppointment.style.display = "block";
//     });

//     // Fecha o modal
//     closeModal.addEventListener("click", function () {
//         modal.style.display = "none";
//     });

//     window.addEventListener("click", function (event) {
//         if (event.target === modal) {
//             modal.style.display = "none";
//         }
//     });

//     // Salva os dados e envia o formulário
//     saveAppointment.addEventListener("click", function () {
//         const petName = document.getElementById("pet-name").value;
//         const consultaMotivo = document.getElementById("consulta-motivo").value;

//         if (petName && consultaMotivo) {
//             // Concatena os dados e insere no campo "motivo" do formulário
//             document.getElementById("selected-day").value += ` - Pet: ${petName}`;
//             document.getElementById("selected-time").value += ` - Motivo: ${consultaMotivo}`;
            
//             // Envia o formulário principal
//             document.getElementById("schedule-form").submit();

//             modal.style.display = "none";
//         } else {
//             alert("Preencha todos os campos!");
//         }
//     });
// });
