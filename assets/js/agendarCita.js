document.getElementById('form-agendar-cita').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el envío del formulario por defecto

    const formData = new FormData(this);
    
    // Verificar qué se está enviando
    for (let pair of formData.entries()) {
        console.log(`${pair[0]}: ${pair[1]}`);
    }

    fetch('php/agendar_cita.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        const mensajeCita = document.getElementById('mensaje-cita');
        mensajeCita.textContent = data.message; // Muestra el mensaje de respuesta
        mensajeCita.style.color = data.status === 'success' ? 'green' : 'red'; // Cambia el color del texto según el estado
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
