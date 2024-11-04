function toggleCitas(event) {
    event.preventDefault(); // Evita el comportamiento por defecto del enlace

    const citasAgendadasSection = document.getElementById('citas-agendadas');
    const isVisible = citasAgendadasSection.style.display === 'block';

    if (isVisible) {
        citasAgendadasSection.style.display = 'none'; // Ocultar si ya está visible
    } else {
        // Mostrar las citas y obtenerlas de la base de datos
        fetchCitas(); // Asegúrate de que esta función esté bien definida
        citasAgendadasSection.style.display = 'block'; // Mostrar la sección
    }
}


function fetchCitas() {
    fetch('php/citas_agendadas.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta de la red');
            }
            return response.json();
        })
        .then(data => {
            const citasContainer = document.getElementById('citas-agendadas').querySelector('ul');
            citasContainer.innerHTML = ''; // Limpiar el contenedor

            // Verificar si hay citas
            if (data.length === 0) {
                citasContainer.innerHTML = '<li>No tienes citas agendadas.</li>';
            } else {
                // Mostrar las citas
                data.forEach(cita => {
                    const li = document.createElement('li');
                    li.textContent = `Cita - ${cita.hora} en ${cita.fecha} `;
                    
                    // Crear el botón de eliminar
                    const btnEliminar = document.createElement('button');
                    btnEliminar.textContent = 'Eliminar';
                    btnEliminar.onclick = () => eliminarCita(cita.id); // Llama a la función de eliminación

                    li.appendChild(btnEliminar); // Agrega el botón a la lista
                    citasContainer.appendChild(li);
                });
            }
        })
        .catch(error => {
            console.error('Error al obtener las citas:', error);
            alert('Hubo un problema al obtener las citas. Por favor, intenta de nuevo.');
        });
}

// Función para eliminar una cita
function eliminarCita(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta cita?')) {
        fetch(`php/eliminar_cita.php?id=${id}`, {
            method: 'DELETE' // Utiliza el método DELETE
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al eliminar la cita');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                alert('Cita eliminada exitosamente.');
                fetchCitas(); // Actualiza la lista de citas
            } else {
                alert('Error al eliminar la cita: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al eliminar la cita. Por favor, intenta de nuevo.');
        });
    }
}

