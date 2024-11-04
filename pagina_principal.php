<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include 'php/conexion_be.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería - Página Principal</title>
    <link rel="stylesheet" href="assets/css/estilosPagina2.css">
</head>
<body>

<header>
    <h1>Profeta Barber Shop</h1>
    <nav>
        <ul>
            <li><a href="#servicios">Servicios</a></li>
            <li><a href="#barbero">Sobre el Barbero</a></li>
            <li><a href="#cortes">Galería de Cortes</a></li>
            <li><a href="#agendar-cita" class="btn-agendar">Agendar Cita</a></li>
            <li><a href="php/cerrar_sesion.php" class="btn-cerrar-sesion">Cerrar Sesión</a></li>
        </ul>
    </nav>
</header>

<main>

<section id="servicios">
    <h2>Nuestros Servicios</h2>
    <p>Ofrecemos una variedad de servicios personalizados para nuestros clientes.</p>
    <div class="servicios-container">
        <!-- Fila superior -->
        <div class="servicio-card">
            <div class="servicio-icon">
                <img src="assets/images/iconos/corte.jpg" alt="Icono Corte de Pelo">
            </div>
            <div class="servicio-titulo">
                <h3>Corte de Pelo</h3>
            </div>
            <div class="servicio-descripcion">
                <p>Desde cortes clásicos hasta los más modernos, adaptados a tu estilo.</p>
            </div>
        </div>

        <div class="servicio-card">
            <div class="servicio-icon">
                <img src="assets/images/iconos/barba.jpg" alt="Icono Barba">
            </div>
            <div class="servicio-titulo">
                <h3>Barba</h3>
            </div>
            <div class="servicio-descripcion">
                <p>Modelado y arreglo de barba para un look impecable.</p>
            </div>
        </div>

        <div class="servicio-card">
            <div class="servicio-icon">
                <img src="assets/images/iconos/cejas.jpg" alt="Icono Cejas">
            </div>
            <div class="servicio-titulo">
                <h3>Cejas</h3>
            </div>
            <div class="servicio-descripcion">
                <p>Diseño y perfilado para destacar tu mirada.</p>
            </div>
        </div>

        <!-- Fila inferior -->
        <div class="servicio-card middle-card">
            <div class="servicio-icon">
                <img src="assets/images/iconos/corte_personalizado.jpg" alt="Icono Cortes Personalizados">
            </div>
            <div class="servicio-titulo">
                <h3>Cortes Personalizados</h3>
            </div>
            <div class="servicio-descripcion">
                <p>Trabajamos junto a ti para crear un estilo único adaptado a tus preferencias.</p>
            </div>
        </div>
    </div>
</section>




    <section id="barbero">
        <h2>Sobre el Barbero</h2>
        <p>Con más de 10 años de experiencia, nuestro barbero ha perfeccionado su arte en cortes y estilo, garantizando una 
            experiencia inigualable y un servicio de alta calidad</p>
        <div class="barbero-foto">
            <img src="assets/images/barbero.jpg" alt="Foto del Barbero">
        </div>
    </section>

    <section id="agendar-cita">
    <h2>Agendar Cita</h2>
    <form id="form-agendar-cita" method="POST" action="php/agendar_cita.php">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required>

        <label for="hora">Hora:</label>
        <input type="time" id="hora" name="hora" required>

        <button type="submit">Agendar</button>
        <p id="mensaje-cita"></p>
    </form>

    <!-- Botón para mostrar citas agendadas -->
    <a href="#" class="btn-citas-agendadas" onclick="toggleCitas(event)">Citas Agendadas</a>
</section>

<!-- Sección de Citas Agendadas (oculta por defecto) -->
<div id="citas-agendadas" style="display: none;">
    <h2>Citas Agendadas</h2>
    <ul id="citasContainer"> <!-- Este id debe coincidir con el usado en tu JavaScript -->
        <!-- Las citas se añadirán aquí mediante JavaScript -->
    </ul>
</div>

    <section id="cortes">
        <h2>Galería de Cortes</h2>
        <div class="galeria-imagenes">
            <img src="assets/images/cortes/corte1.jpg" alt="Corte 1">
            <img src="assets/images/cortes/corte2.jpg" alt="Corte 2">
            <img src="assets/images/cortes/corte3.jpg" alt="Corte 3">
            <img src="assets/images/cortes/corte4.jpg" alt="Corte 4">
            <img src="assets/images/cortes/corte5.jpg" alt="Corte 5">
            <img src="assets/images/cortes/corte6.jpg" alt="Corte 6">
            <img src="assets/images/cortes/corte7.jpg" alt="Corte 7">
            <img src="assets/images/cortes/corte8.jpg" alt="Corte 8">
            <img src="assets/images/cortes/corte9.jpg" alt="Corte 9">
        </div>
    </section>
</main>

<script src="assets/js/calendar.js"></script>
<script src="assets/js/citas_agendadas.js"></script>
<script src="assets/js/agendarCita.js"></script>

</body>
</html>



