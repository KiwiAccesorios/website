<?php
require './Conexion/Conexion.php';


// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Consulta para verificar el usuario
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verifica la contraseña
            if ($password == $user['password']) {
                session_start();
                $_SESSION['email'] = $user['email']; // Guarda el email en la sesión   
                header("Location: index.php"); // Redirige a otra página (dashboard)
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "El usuario no existe.";
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title> 
    <link rel="stylesheet" href="style-login.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <div class="input-group">
                <label for="email">Usuario</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
            <p>¿Aun no te has registrado?<a href="Register.php" id="loginBtn" class="name">Registrarse</a>
            <p>¿Has olvidado tu contraseña? <a href="Actualizar.php" id="ActualizarBtn" class="name">Actualizar</a></p>
            <p>¿Quieres eliminar tu cuenta? <a href="Eliminar.php" id="Eliminar" class="name">Eliminar</a></p>
        </form>
    </div>
</body>
</html>
