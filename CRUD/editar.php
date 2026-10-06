<?php
require 'conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Obtener datos actuales del usuario
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    die("Usuario no encontrado.");
}

// 4. ACTUALIZAR (Modificar usuario)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    if (!empty($nombre) && !empty($email)) {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
        $stmt->execute([$nombre, $email, $id]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <style>body { font-family: Arial, sans-serif; margin: 30px; }</style>
</head>
<body>

    <h2>Editar Usuario (Actualizar)</h2>
    <form method="POST">
        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        <button type="submit" name="actualizar">Actualizar</button>
        <a href="index.php">Cancelar</a>
    </form>

</body>
</html>
