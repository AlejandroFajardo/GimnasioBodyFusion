<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenido Personalizado - Gimnasio</title>
    <link rel="icon" href="../imagenes/pesa1.png" type="image/png">
    <link href="../bootstrap.min (3).css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Roboto', sans-serif;
        }
        h1, h4, .card-title, .username {
            font-family: 'Anton', sans-serif;
        }
        .navbar {
            background-color: #111 !important;
            box-shadow: 0 2px 8px rgba(255, 0, 0, 0.4);
        }
        .username {
            color: #ff4d4d !important;
            font-weight: 700;
        }
        .card {
            background-color: #1a1a1a;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 24px rgba(255, 0, 0, 0.6);
        }
        .card-title {
            color: #ff4d4d;
        }
        .card-text {
            color: #e0e0e0;
        }
        .objetivo-badge {
            background-color: #ff4d4d;
            color: #000;

        }
        .btn-warning {
            background-color: #ff4d4d;
            border-color: #ff4d4d;
            color: #fff;

        }
        .btn-warning:hover {
            background-color: #e60000;
            border-color: #e60000;
        }
        .btn-outline-light {
            border-color: #ff4d4d;
            color: #ff4d4d;

        }
        .btn-outline-light:hover {
            background-color: #ff4d4d;
            color: #000;
        }
    </style>
</head>
<body>

<?php
include '../includes/auth.php';
if ($_SESSION['role'] != 'user') {
    header('Location: ../login.php');
    exit();
}

include '../includes/db.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT objetivo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$objetivoUsuario = $user['objetivo'];
?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid justify-content-between">
        <span class="navbar-brand fw-bold username">Hola, <?php echo $_SESSION['name']; ?></span>
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="btn btn-warning mb3">Objetivo: <?php echo ucfirst($objetivoUsuario);?></button>
            <a href="../logout.php" class="btn btn-outline-light">Cerrar sesión</a>
        </div>
    </div>
</nav>

<main class="container mb-5"><br>
    <h1 class="text-danger text-center mb-4">Contenido personalizado para ti</h1>

    <!-- Rutinas -->
    <h4 class="text-danger text-center mb-4">Rutinas</h4>
    <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
        <?php
        $stmt = $conn->prepare("SELECT * FROM rutinas WHERE objetivo = ? ORDER BY id DESC");
        $stmt->bind_param("s", $objetivoUsuario);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                echo '
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">'.htmlspecialchars($row['titulo']).'</h5>
                            <p class="card-text">'.nl2br(htmlspecialchars($row['descripcion'])).'</p>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col"><div class="alert alert-info">No hay rutinas disponibles para tu objetivo.</div></div>';
        }
        ?>
    </div>

    <!-- Recomendaciones -->
    <h4 class="text-danger text-center mb-4">Recomendaciones</h4>
    <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
        <?php
        $stmt = $conn->prepare("SELECT * FROM recomendaciones WHERE objetivo = ? ORDER BY id DESC");
        $stmt->bind_param("s", $objetivoUsuario);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                echo '
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">'.htmlspecialchars($row['titulo']).'</h5>
                            <p class="card-text">'.nl2br(htmlspecialchars($row['descripcion'])).'</p>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col"><div class="alert alert-info">No hay recomendaciones disponibles para tu objetivo.</div></div>';
        }
        ?>
    </div>

    <!-- Recetas -->
    <h4 class="text-danger text-center mb-4">Recetas</h4>
    <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
        <?php
        $stmt = $conn->prepare("SELECT * FROM recetas WHERE objetivo = ? ORDER BY id DESC");
        $stmt->bind_param("s", $objetivoUsuario);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                echo '
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">'.htmlspecialchars($row['titulo']).'</h5>
                            <p class="card-text">'.nl2br(htmlspecialchars($row['descripcion'])).'</p>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col"><div class="alert alert-info">No hay recetas disponibles para tu objetivo.</div></div>';
        }
        ?>
    </div>
</main>

<script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>
