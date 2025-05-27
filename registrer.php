<?php include 'includes/db.php'; ?>

<?php
// Procesamiento del formulario
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $objetivo = $_POST['objetivo'];

    // Validación de campos vacíos
    if (empty($name) || empty($email) || empty($password) || empty($objetivo)) {
        $message = '
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <strong>Error:</strong> Todos los campos son obligatorios.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        // Conexión a la base de datos (ajusta según tu configuración)
        $servername = "localhost";
        $username = "root";
        $password_db = "";
        $dbname = "gimnasio";

        $conn = new mysqli($servername, $username, $password_db, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Verificar si el correo ya está registrado
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Si ya existe un usuario con ese correo
            $message = '
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Error:</strong> El correo electrónico ya está registrado.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            // Hashear la contraseña antes de insertarla
            $pass_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Preparar la consulta de inserción
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, objetivo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $pass_hashed, $objetivo);

            // Ejecutar la consulta y mostrar el mensaje correspondiente
            if ($stmt->execute()) {
                $message = '
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong>¡Registro exitoso!</strong> Ahora puedes iniciar sesión.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                $message = '
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>Error:</strong> ' . $stmt->error . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }

        // Cerrar la consulta y la conexión
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link rel="stylesheet" href="./bootstrap.min (3).css">
    <link rel="icon" href="imagenes/pesa1.png" type="image/png">
    <style>
        body {
            background-image: url('imagenes/gym2.png');
            background-size: cover;
            background-position: center;
            font-family: 'Segoe UI', sans-serif;
            letter-spacing: 0.5px;
        }

        .btn-red {
            color: white;
            background-color: #d90429;
            border: 1px solid #ff2e63;
            letter-spacing: 1px;
            font-size: 18px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }

        .btn-red:hover {
            background-color: #ff2e63;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.8);
        }

        .btn-red-outline {
            background-color: transparent;
            color: #ff2e63;
            border: 1px solid #ff2e63;
            letter-spacing: 1px;
            font-size: 18px;
            transition: all 0.3s ease-in-out;
        }

        .btn-red-outline:hover {
            background-color: #ff2e63;
            color: white;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.6);
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 12px;
            width: 800px;
            padding-right: 150px;
        }
    </style>
</head>

<body style="background-size: cover;">

<?php if (isset($message)) echo $message; ?>


<div class="d-flex justify-content-end align-items-center vh-100">
    <div class="form-container">

        <h3 class="text-center text-white fw-bold mb-4">Registro</h3>

        <form action="registrer.php" method="POST">
            <div class="d-flex gap-3">
                <div style="width: 100%;">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Correo" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    </div>
                    <div >
                        <label class="form-label text-white">Objetivo:</label>
                        <select class="form-select" name="objetivo">
                            <option value="ganar masa">Ganar masa muscular</option>
                            <option value="bajar grasa">Bajar masa grasa</option>
                            <option value="resistencia">Resistencia</option>
                            <option value="fuerza">Fuerza</option>
                            <option value="salud general">Salud general</option>
                        </select>
                    </div>
                </div>


            </div>

            <br>

            <button type="submit" name="register" class="btn btn-red w-100">Registrarse</button>
        </form>

        <br>

        <a href="login.php">
            <button class="btn btn-red-outline w-100">Iniciar Sesión</button>
        </a>

    </div>
</div>

<script src="./js/bootstrap.bundle.min.js"></script>

</body>
</html>

