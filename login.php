<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'includes/db.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $user = $res->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Iniciar sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            // Redirigir según el rol
            if ($user['role'] == 'admin') {
                header('Location: admin/dashboard.php');
                exit();
            } else {
                header('Location: user/dashboard.php');
                exit();
            }
        } else {
            $message = '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Error:</strong> Contraseña incorrecta.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    } else {
        $message = '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <strong>Error:</strong> Correo no registrado
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php if (isset($message)) echo $message; ?>
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Body Fusion</title>
    <link rel="stylesheet" href="./bootstrap.min (3).css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="icon" href="imagenes/pesa1.png" type="image/png">
    <style>
        body {
            background-image: url('imagenes/gym2.png'); /* Usa la imagen generada */
            background-size: cover;
            background-position: center;
            font-family: 'Bebas Neue', sans-serif;
            margin: 0;
        }

        .login-container {
            height: 100vh;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-right: 5%;
        }

        .login-box {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 40px;
            border-radius: 15px;
            width: 350px;
            color: white;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.3);
            margin-right: 150px;
        }

        .login-box h3 {
            text-align: center;
            margin-bottom: 25px;
            letter-spacing: 2px;
            text-shadow: 0 0 5px red;
            color: white;
        }

        .form-control {
            background-color: #1a1a1a;
            border: 1px solid #444;
            color: white;
            font-size: 18px;
            letter-spacing: 1px;
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .btn-outline-light, .btn-outline-warning {
            font-size: 18px;
            letter-spacing: 1px;
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

    </style>
</head>

<body>
<?php if (isset($message)) echo $message; ?>

<div class="login-container">
    <div class="login-box">
        <h3>Iniciar Sesión</h3>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Correo" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-red w-100 mb-3" name="login">Entrar</button>
            <a href="registrer.php" class="btn btn-red-outline w-100">Registrarse</a>
        </form>
    </div>
</div>

<script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>

