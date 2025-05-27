<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recomendaciones - Gimnasio</title>
    
    <!-- Tema Lux de Bootswatch -->
    <link href="../bootstrap.min (3).css" rel="stylesheet">
    
    <!-- CSS personalizado para modo oscuro -->
    <style>
        body {
            background-color: #121212;
            color: #f5f5f5;
        }
        .navbar {
            background-color: #1f1f1f !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.7);
        }
        .username {
            color: rgb(240, 195, 81); !important;
            font-weight: 700;
        }
        .card {
            background-color: #222;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 24px rgb(240, 195, 81);
        }
        .card-title {
            color: #rgb(240, 195, 81);
        }
        .card-text {
            color: #ccc;
        }
        .objetivo-badge {
            background-color:rgb(240, 195, 81);
            color: #121212;
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

    // Obtener el objetivo del usuario
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT objetivo FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $objetivo_usuario = $user['objetivo'];
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid justify-content-between">
            <span class="navbar-brand fw-bold username">Hola, <?php echo $_SESSION['name']; ?></span>
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-warning mb3">Objetivo: <?php echo ucfirst($objetivo_usuario);?></button>
                <a href="../logout.php" class="btn btn-outline-light">Cerrar sesión</a>

     

            </div>
        </div>
    </nav>


    <main class="container mb-5"><br>
        <h1 class="text-secondary">Contenido recomendado para ti</h1><br>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            // Buscar contenido que coincida con su objetivo
            $stmt = $conn->prepare("SELECT * FROM contenidos WHERE objetivo = ? ORDER BY id DESC");
            $stmt->bind_param("s", $objetivo_usuario);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo '
                    <div class="col">
                        <div class="card h-100">
                            <img src="https://images.unsplash.com/photo-1598970434795-0c54fe7c0642?auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="'.$row['tipo'].'">
                            <div class="card-body">
                                <h5 class="card-title">'.$row['titulo'].'</h5>
                                <p class="card-text">'.$row['descripcion'].'</p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <small class="text-muted">'.$row['tipo'].'</small>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12">
                        <div class="alert alert-info">
                            Aún no hay contenido publicado para tu objetivo.
                        </div>
                    </div>';
            }
            ?>
        </div>
    </main>


    <script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>