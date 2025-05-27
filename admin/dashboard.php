<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Gimnasio</title>
    <link href="../bootstrap.min (3).css" rel="stylesheet">
    <link rel="icon" href="../imagenes/pesa1.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Roboto', sans-serif;
        }
        .navbar {
            background-color: #111 !important;
            box-shadow: 0 2px 8px rgba(255, 0, 0, 0.4);
        }
        .username {
            color: #ff4d4d !important;
            font-weight: 700;
            font-family: 'Anton', sans-serif;
        }
        h3, h4 {
            font-family: 'Anton', sans-serif;
            color: #ff4d4d;
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
            color: #ccc;
        }
        .objetivo-badge {
            background-color: #ff4d4d;
            color: #000;
            font-weight: bold;
        }
        .btn-warning {
            background-color: #ff4d4d;
            border-color: #ff4d4d;
            color: #fff;
            font-weight: bold;
        }
        .btn-warning:hover {
            background-color: #e60000;
            border-color: #e60000;
        }
        .btn-outline-light {
            border-color: #ff4d4d;
            color: #ff4d4d;
            font-weight: bold;
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
if ($_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}
include '../includes/db.php';
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid justify-content-between">
        <span class="navbar-brand fw-bold username">Bienvenido, <?php echo $_SESSION['name']; ?> (Administrador)</span>
        <div class="d-flex align-items-center gap-3">
            <a href="basedatos.php" class="btn btn-outline-light">Ver base de datos</a>
            <a href="../logout.php" class="btn btn-outline-light">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h3 class="text-center">Publicar contenido</h3><br>
    <form method="POST" class="mx-auto" style="max-width: 600px;">
        <input type="text" name="titulo" placeholder="Título" required class="form-control mb-3">
        <select name="tipo" required class="form-select mb-3">
            <option value="rutina">Rutina</option>
            <option value="recomendacion">Recomendación</option>
            <option value="receta">Receta</option>
        </select>
        <label class="text-white">Objetivo:</label>
        <select name="objetivo" required class="form-select mb-3">
            <option value="ganar masa muscular">Ganar masa muscular</option>
            <option value="bajar masa grasa">Bajar masa grasa</option>
            <option value="resistencia">Resistencia</option>
            <option value="fuerza">Fuerza</option>
            <option value="salud general">Salud general</option>
        </select>
        <textarea class="form-control mb-3" rows="3" name="descripcion" placeholder="Descripción detallada" required></textarea>
        <button type="submit" name="publicar" class="btn btn-warning w-100">Publicar</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['publicar'])) {
        $titulo = $_POST['titulo'];
        $tipo = $_POST['tipo'];
        $objetivo = $_POST['objetivo'];
        $descripcion = $_POST['descripcion'];

        $tabla = ($tipo == 'rutina') ? 'rutinas' : (($tipo == 'receta') ? 'recetas' : 'recomendaciones');

        $stmt = $conn->prepare("INSERT INTO $tabla (titulo, objetivo, descripcion) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $titulo, $objetivo, $descripcion);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success mt-3">Contenido publicado correctamente en ' . htmlspecialchars($tabla) . '.</div>';
        } else {
            echo '<div class="alert alert-danger mt-3">Error: ' . htmlspecialchars($stmt->error) . '</div>';
        }
    }
    ?>

    <h4 class="text-center mt-5">Contenidos publicados</h4>
    <div class="container text-center mt-5">
        <h4 class="text-warning mb-4">Selecciona qué contenido ver</h4>
        <div class="btn-group mb-4" role="group">
            <button class="btn btn-outline-light" onclick="mostrarCategoria('rutinas')">Rutinas</button>
            <button class="btn btn-outline-light" onclick="mostrarCategoria('recetas')">Recetas</button>
            <button class="btn btn-outline-light" onclick="mostrarCategoria('recomendaciones')">Recomendaciones</button>
        </div>

        <?php
        $tablas = [
            'rutinas' => 'Rutinas de entrenamiento',
            'recetas' => 'Recetas alimenticias',
            'recomendaciones' => 'Recomendaciones generales'
        ];

        foreach ($tablas as $tabla => $titulo) {
            $res = $conn->query("SELECT * FROM $tabla ORDER BY id DESC");

            echo '<div id="' . $tabla . '" class="categoria-contenido" style="display: none;">';
            if ($res->num_rows > 0) {
                echo '<h3 class="text-center text-warning mb-4">' . htmlspecialchars($titulo) . '</h3>';
                echo '<div class="row">';
                while ($row = $res->fetch_assoc()) {
                    echo '<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header text-uppercase text-center fw-bold">' . strtoupper($tabla) . '</div>
                        <div class="card-body">
                            <h5 class="card-title text-center">' . htmlspecialchars($row['titulo']) . '</h5>
                            <div class="text-center mb-2">
                                <span class="badge objetivo-badge">' . htmlspecialchars($row['objetivo']) . '</span>
                            </div>
                            <p class="card-text">' . nl2br(htmlspecialchars($row['descripcion'])) . '</p>
                        </div>
                    </div>
                </div>';
                }
                echo '</div>'; // row
            } else {
                echo '<p class="text-muted">No hay contenidos disponibles.</p>';
            }
            echo '</div>'; // fin categoría
        }
        ?>
    </div>

    <script>
        function mostrarCategoria(id) {
            const categorias = document.querySelectorAll('.categoria-contenido');
            categorias.forEach(div => {
                div.style.display = 'none';
            });
            const activo = document.getElementById(id);
            if (activo) {
                activo.style.display = 'block';
            }
        }
    </script>

</div>
</body>
</html>
