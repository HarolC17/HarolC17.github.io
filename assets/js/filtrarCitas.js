function filtrarTabla() {
    const usuarioFiltro = document.getElementById("filterUsuario").value.toLowerCase();
    const fechaFiltro = document.getElementById("filterFecha").value;
    const horaFiltro = document.getElementById("filterHora").value;

    const filas = document.querySelectorAll("#tablaCitas tr");
    filas.forEach(fila => {
        const usuario = fila.cells[0].textContent.toLowerCase();
        const fecha = fila.cells[1].textContent;
        const hora = fila.cells[2].textContent;

        fila.style.display = (usuario.includes(usuarioFiltro) && 
                             (fecha === fechaFiltro || fechaFiltro === "") && 
                             (hora.includes(horaFiltro) || horaFiltro === "")) ? "" : "none";
    });
}
