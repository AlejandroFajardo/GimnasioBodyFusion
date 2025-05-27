<?php
include '../includes/db.php';

// Eliminar usuario
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: basedatos.php");
    exit;
}

// Actualizar usuario
if (isset($_POST['update_user'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $objetivo = $_POST['objetivo'] ?? '';

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, objetivo = ? WHERE id = ? AND role != 'admin'");
    $stmt->bind_param("sssi", $name, $email, $objetivo, $id);
    $stmt->execute();
    header("Location: basedatos.php");
    exit;
}

$stmt = $conn->prepare("SELECT id, name, email, objetivo FROM users WHERE role != 'admin' ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Administrar Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../imagenes/pesa1.png" type="image/png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap');

        body {
            background-color: #000;
            color: #fff;
            font-family: 'Orbitron', sans-serif;
        }

        .navbar {
            background-color: #111;
            border-bottom: 2px solid #ff0000;
        }

        .navbar-brand {
            font-size: 1.4rem;
            color: #ff0000 !important;
        }

        .btn-outline-light:hover {
            background-color: #ff0000;
            color: #fff;
            border-color: #ff0000;
        }

        h2 {
            color: #ff0000;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            border-bottom: 2px solid #ff0000;
            padding-bottom: 10px;
        }

        .table thead {
            background-color: #ff0000;
            color: #fff;
        }

        .table tbody tr:hover {
            background-color: #1a1a1a;
        }

        .btn-edit, .btn-delete {
            font-weight: bold;
            border: none;
            background: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-edit {
            color: #ff0000;
        }

        .btn-edit:hover {
            text-shadow: 0 0 5px #ff0000;
        }

        .btn-delete {
            color: #ffffff;
        }

        .btn-delete:hover {
            text-shadow: 0 0 5px #ffffff;
        }

        .modal-content {
            background-color: #111;
            color: #fff;
            border: 1px solid #ff0000;
            border-radius: 12px;
        }

        .modal-title {
            color: #ff0000;
        }

        .btn-danger {
            background-color: #ff0000;
            color: #fff;
            font-weight: bold;
        }

        .btn-danger:hover {
            background-color: #cc0000;
        }

        .btn-secondary {
            background-color: #333;
            border: none;
        }

        .form-label {
            color: #ff0000;
        }

        .form-control {
            background-color: #222;
            color: #fff;
            border: 1px solid #555;
        }

        .form-control:focus {
            border-color: #ff0000;
            box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25);
        }
    </style>
</head>
<body class="p-4">

<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container-fluid justify-content-between">
        <span class="navbar-brand">🏋️ Base de Datos de Usuarios</span>
        <div class="d-flex align-items-center gap-3">
            <a href="dashboard.php" class="btn btn-outline-light">Ver y publicar contenido</a>
            <a href="../logout.php" class="btn btn-outline-light">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2>Administrar Usuarios</h2>

    <table class="table table-dark table-hover table-bordered text-center align-middle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Objetivo</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['objetivo']) ?></td>
                <td>
                    <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Editar</button> |
                    <a href="?delete_id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>

                    <!-- Modal -->
                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?= $row['id'] ?>">Editar Usuario #<?= $row['id'] ?></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['email']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Objetivo</label>
                                        <input type="text" name="objetivo" class="form-control" value="<?= htmlspecialchars($row['objetivo']) ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" name="update_user" class="btn btn-danger">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
