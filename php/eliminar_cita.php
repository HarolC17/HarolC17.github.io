<?php
session_start();
include 'conexion_be.php'; // Asegúrate de que la conexión se realiza correctamente

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Obtener el ID de la cita a eliminar
$id = $_GET['id'];

// Consulta para eliminar la cita
$stmt = $conexion->prepare("DELETE FROM citas WHERE id = ? AND usuario = ?");
$stmt->bind_param("is", $id, $_SESSION['usuario']);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la cita.']);
}

// Cerrar la declaración y la conexión
$stmt->close();
mysqli_close($conexion);
?>
