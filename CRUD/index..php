<?php
require 'conexion.php';

// 1. CREAR (Insertar usuario)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    if (!empty($nombre) && !empty($email)) {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email) VALUES (?, ?)");
        $stmt->execute([$nombre, $email]);
        header("Location: index.php");
        exit;
    }
}

// 2. BORRAR (Eliminar usuario)
if (isset($_GET['borrar'])) {
    $id = $_GET['borrar'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// 3. LEER (Obtener todos los usuarios)
$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Básico PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-borrar { color: red; margin-left: 10px; }
    </style>
</head>
<body>

    <h2>Agregar Usuario (Crear)</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <button type="submit" name="agregar">Guardar</button>
    </form>

    <h2>Lista de Usuarios (Leer)</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['id']) ?></td>
                <td><?= htmlspecialchars($u['nombre']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <a href="editar.php?id=<?= $u['id'] ?>">Editar</a>
                    <a class="btn-borrar" href="index.php?borrar=<?= $u['id'] ?>" onclick="return confirm('¿Seguro?')">Borrar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
