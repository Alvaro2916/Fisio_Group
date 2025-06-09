document.addEventListener("DOMContentLoaded", function () {
    const areas = document.querySelectorAll("area[data-zona]");
    const zonaInput = document.getElementById("zonaInput");
    const zonaTexto = document.getElementById("zonaSeleccionada");

    areas.forEach(area => {
        area.addEventListener("click", function () {
            const zona = this.dataset.zona;
            zonaInput.value = zona;
            zonaTexto.textContent = "Zona seleccionada: " + zona;
        });
    });
});
