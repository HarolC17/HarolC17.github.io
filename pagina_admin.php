<?php
// Conectar a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "login_register_db");

// Verificar la conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Manejar la confirmación o eliminación de citas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $usuario = $_POST['usuario'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    if ($_POST['action'] === 'confirmar') {
        // Ocultar la cita
        $query = "UPDATE citas SET confirmado = 1 WHERE usuario = ? AND fecha = ? AND hora = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sss", $usuario, $fecha, $hora);
        $stmt->execute();
    } elseif ($_POST['action'] === 'eliminar') {
        // Eliminar la cita
        $query = "DELETE FROM citas WHERE usuario = ? AND fecha = ? AND hora = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sss", $usuario, $fecha, $hora);
        $stmt->execute();
    }
}

// Consulta para obtener las citas no confirmadas
$query = "SELECT usuario, fecha, hora FROM citas WHERE confirmado IS NULL ORDER BY fecha, hora";
$result = mysqli_query($conexion, $query);

// Verificar si hay citas disponibles
$citas = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $citas[] = $row;
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas Administrador</title>
    <link rel="stylesheet" href="assets/css/estilosAdmin2.css"> <!-- Añadir tu archivo CSS aquí -->
    <script src="assets/js/filtrarCitas.js" defer></script> <!-- Incluye el archivo JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
</head>
<body style="background-color: #e0f7fa;"> <!-- Fondo azul claro -->
    <header>
        <h1>Lista de Citas Disponibles</h1>
        <button onclick="window.location.href='index.php'">Cerrar Sesión</button> <!-- Botón para cerrar sesión -->
    </header>

    <main>
        <div class="filtros">
            <input type="text" id="filterUsuario" placeholder="Filtrar por usuario" onkeyup="filtrarTabla()">
            <input type="date" id="filterFecha" oninput="filtrarTabla()">
            <input type="text" id="filterHora" placeholder="Filtrar por hora (HH:MM)" onkeyup="filtrarTabla()">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaCitas">
                <?php if (!empty($citas)): ?>
                    <?php foreach ($citas as $cita): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cita['usuario']); ?></td>
                            <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($cita['usuario']); ?>">
                                    <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($cita['fecha']); ?>">
                                    <input type="hidden" name="hora" value="<?php echo htmlspecialchars($cita['hora']); ?>">
                                    <button class="confirmar-btn" name="action" value="confirmar">
                                        <i class="fas fa-check-circle"></i> Confirmar
                                    </button>
                                </form>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($cita['usuario']); ?>">
                                    <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($cita['fecha']); ?>">
                                    <input type="hidden" name="hora" value="<?php echo htmlspecialchars($cita['hora']); ?>">
                                    <button class="eliminar-btn" name="action" value="eliminar">
                                        <i class="fas fa-times-circle"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay citas disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </main>

    <script src="assets/js/filtrarCitas.js"></script>
    
</body>
</html>
