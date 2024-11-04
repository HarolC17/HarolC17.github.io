document.addEventListener("DOMContentLoaded", function() {
    // Mostrar el modal al hacer clic en el botón correspondiente
    document.getElementById("adminBtn").addEventListener("click", function() {
        var modal = document.getElementById("adminModal");
        modal.style.display = "flex"; // Mostrar el modal con flexbox

        // Añadir clase 'show' al modal para aplicar el cambio de color
        setTimeout(function() {
            modal.classList.add("show");
        }, 100);
    });

    // Manejar el clic en el botón "Entrar"
    document.getElementById("adminLoginBtn").addEventListener("click", validarCredenciales);

    // Detectar la tecla Enter en los campos de usuario y contraseña
    ["adminUser", "adminPassword"].forEach(function(id) {
        document.getElementById(id).addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Evita el comportamiento por defecto del Enter
                validarCredenciales();  // Llama a la función de validación
            }
        });
    });

    // Función para validar credenciales y redirigir o mostrar error
    function validarCredenciales() {
        var user = document.getElementById("adminUser").value;
        var password = document.getElementById("adminPassword").value;

        if (user === "Profeta" && password === "Barberia") {
            // Redirigir a la página de administrador
            window.location.href = "pagina_admin.php";
        } else {
            alert("Usuario o contraseña incorrectos");
        }
    }

    // Cerrar el modal si se hace clic fuera de él
    window.onclick = function(event) {
        var modal = document.getElementById("adminModal");
        if (event.target === modal) {
            modal.style.display = "none";
            modal.classList.remove("show");
        }
    };
});
