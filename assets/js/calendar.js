document.addEventListener('DOMContentLoaded', function() {
    const formAgendarCita = document.getElementById('form-agendar-cita');
    const fechaInput = document.getElementById('fecha');
    const horaInput = document.getElementById('hora');
    const mensajeCita = document.getElementById('mensaje-cita');

    // Desactivar los domingos y fechas anteriores a ayer
    fechaInput.addEventListener('input', function() {
        const fechaSeleccionada = new Date(fechaInput.value);
        const diaSemana = fechaSeleccionada.getUTCDay();
        const fechaAyer = new Date();
        fechaAyer.setDate(fechaAyer.getDate() - 1); // Ajustar a ayer
        fechaAyer.setHours(0, 0, 0, 0); // Ajustar a medianoche

        if (diaSemana === 0) { // 0 es domingo
            mensajeCita.textContent = "No se pueden agendar citas los domingos.";
            fechaInput.value = "";
        } else if (fechaSeleccionada < fechaAyer) {
            mensajeCita.textContent = "No se pueden agendar citas para fechas anteriores a ayer.";
            fechaInput.value = "";
        } else {
            mensajeCita.textContent = ""; // Limpiar mensaje si la fecha es válida
        }
    });

    // Restringir las horas disponibles
    horaInput.addEventListener('input', function(e) {
        let time = e.target.value;
        let [hours, minutes] = time.split(':');

        // Si los minutos no son '00', ajusta automáticamente.
        if (minutes !== '00') {
            e.target.value = `${hours}:00`;
        }

        // Validar si la hora está dentro del rango permitido
        let horaSeleccionada = new Date(`1970-01-01T${e.target.value}:00`);
        let horaInicioMañana = new Date('1970-01-01T09:00:00');
        let horaFinMañana = new Date('1970-01-01T14:00:00');
        let horaInicioTarde = new Date('1970-01-01T16:00:00');
        let horaFinTarde = new Date('1970-01-01T21:00:00');
        let ahora = new Date(); // Fecha y hora actual

        // Ajustar la hora actual para comparar solo la hora, no la fecha
        let horaActual = new Date(`1970-01-01T${ahora.getHours()}:${ahora.getMinutes()}:00`);

        // Validar la hora dentro del rango permitido
        if (horaSeleccionada < horaInicioMañana || horaSeleccionada > horaFinTarde ||
            (horaSeleccionada > horaFinMañana && horaSeleccionada < horaInicioTarde)) {
            mensajeCita.textContent = "Hora no válida. Debe ser entre 9:00 AM y 2:00 PM o entre 4:00 PM y 9:00 PM.";
            horaInput.value = "";
        } else if (fechaInput.value) {
            const fechaCita = new Date(`${fechaInput.value}T${e.target.value}:00`);
            const fechaHoy = new Date();

            // Si la fecha es hoy, comparar la hora con la hora actual
            if (fechaCita.toDateString() === fechaHoy.toDateString() && horaSeleccionada < horaActual) {
                mensajeCita.textContent = "No se pueden agendar citas para horas anteriores a la hora actual.";
                horaInput.value = "";
            } else {
                mensajeCita.textContent = ""; // Limpiar mensaje si la hora es válida
            }
        }
    });

    // Manejador de envío del formulario
    formAgendarCita.addEventListener('submit', function(event) {
        event.preventDefault();

        const fecha = fechaInput.value;
        const hora = horaInput.value;

        // Enviar datos al backend para verificar y agendar la cita
        fetch('php/agendar_cita.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'fecha': fecha,
                'hora': hora
            })
        })
        .then(response => response.json())
        .then(data => {
            mensajeCita.textContent = data.message; // Muestra el mensaje de respuesta
            mensajeCita.style.color = data.status === 'success' ? 'green' : 'red'; // Cambia el color del texto según el estado

            // Resetear el formulario si la cita fue agendada exitosamente
            if (data.status === 'success') {
                formAgendarCita.reset();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mensajeCita.textContent = "Ocurrió un error al agendar la cita.";
            mensajeCita.style.color = 'red';
        });
    });
});
