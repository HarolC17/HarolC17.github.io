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

// Obtener el usuario de la sesión
$usuario = $_SESSION['usuario'];

// Consulta para obtener las citas del usuario, ordenadas por fecha y hora
$stmt = $conexion->prepare("SELECT id, fecha, hora FROM citas WHERE usuario = ? AND (confirmado = 0 OR confirmado IS NULL) ORDER BY fecha, hora");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

// Crear un array para almacenar las citas
$citas = [];
while ($row = $result->fetch_assoc()) {
    $citas[] = [
        'id' => $row['id'], // Asegúrate de incluir el ID
        'fecha' => $row['fecha'],
        'hora' => $row['hora']
    ];
}

// Cerrar la declaración y la conexión
$stmt->close();
mysqli_close($conexion);

// Mostrar las citas en formato JSON
header('Content-Type: application/json');
echo json_encode($citas);
?>
