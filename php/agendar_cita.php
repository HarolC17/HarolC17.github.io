<?php
session_start();
include 'conexion_be.php'; // Asegúrate de que la conexión se realiza correctamente

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establecer la zona horaria
date_default_timezone_set('America/Bogota'); // Cambia a la zona horaria adecuada

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Obtener datos del formulario y sanitizar
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$usuario = $_SESSION['usuario'];

// Mensajes de depuración
error_log("Fecha recibida: $fecha, Hora recibida: $hora");

// Validar la fecha y hora (por ejemplo, asegurarse de que no sea en el pasado)
$fecha_actual = date("Y-m-d");
$hora_actual = date("H:i");

$fecha_hora_seleccionada = strtotime($fecha . ' ' . $hora);
$fecha_hora_actual = strtotime($fecha_actual . ' ' . $hora_actual);

// Mostrar valores actuales para depuración
error_log("Fecha actual: $fecha_actual, Hora actual: $hora_actual");

if ($fecha_hora_seleccionada <= $fecha_hora_actual) {
    echo json_encode([
        "status" => "error",
        "message" => "La fecha y hora seleccionadas deben ser futuras."
    ]);
    exit();
}

// Consulta para verificar si la cita ya existe
$stmt = $conexion->prepare("SELECT * FROM citas WHERE fecha = ? AND hora = ?");
$stmt->bind_param("ss", $fecha, $hora);
$stmt->execute();
$result_verificar = $stmt->get_result();

// Verificar si hay alguna cita en esa fecha y hora
if ($result_verificar->num_rows > 0) {
    // Si existe una cita en esa fecha y hora, devolver un mensaje de error en JSON
    echo json_encode([
        "status" => "error",
        "message" => "La fecha y hora seleccionadas ya están ocupadas. Por favor, elige otra."
    ]);
} else {
    // Insertar la cita en la base de datos
    $stmt_insertar = $conexion->prepare("INSERT INTO citas (usuario, fecha, hora) VALUES (?, ?, ?)");
    $stmt_insertar->bind_param("sss", $usuario, $fecha, $hora);
    
    if ($stmt_insertar->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Cita agendada exitosamente."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Error al agendar la cita: " . $stmt_insertar->error
        ]);
    }

    // Cerrar la declaración
    $stmt_insertar->close();
}

// Cerrar la declaración de verificación
$stmt->close();

// Cerrar la conexión
mysqli_close($conexion);
?>
