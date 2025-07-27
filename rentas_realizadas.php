<?php
session_start();
require 'conexion.php';

$usuario = $_SESSION['usuario'] ?? null;
if (!$usuario) {
    header("Location: login.php"); // o donde tengas la página de login
    exit();
}

// Consulta para obtener las rentas del usuario con datos del auto
$stmt = $conn->prepare(
    "SELECT r.*, a.nombre AS nombre_auto, a.imagen AS imagen_auto
     FROM rentas r
     JOIN autos a ON r.auto_id = a.id
     WHERE r.cliente = ?
     ORDER BY r.fecha_inicio DESC"
);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Mis Rentas Realizadas</title>
    <link rel="stylesheet" href="css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<?php include 'header.php'; ?>

<h1>Mis Rentas Realizadas</h1>

<?php if ($result->num_rows === 0): ?>
    <p>No has realizado ninguna renta aún.</p>
<?php else: ?>
    <div class="rentas-list">
        <?php while ($renta = $result->fetch_assoc()): ?>
            <div class="renta-item" style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
                <img src="<?php echo htmlspecialchars($renta['imagen_auto']); ?>" alt="Auto" style="width:150px; height:auto;">
                <h2><?php echo htmlspecialchars($renta['nombre_auto']); ?></h2>
                <p><strong>Desde:</strong> <?php echo htmlspecialchars($renta['fecha_inicio']); ?></p>
                <p><strong>Hasta:</strong> <?php echo htmlspecialchars($renta['fecha_fin']); ?></p>
                <p><strong>Total:</strong> $<?php echo number_format($renta['total'], 2); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

</body>
</html>