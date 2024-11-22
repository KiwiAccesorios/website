<?php
require './Conexion/Conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Por favor, llena todos los campos.";
    } else {
        $checkEmail = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conexion->prepare($checkEmail);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "El correo ya está registrado.";
        } else {
            $insertUser = "INSERT INTO usuarios (email, password) VALUES (?, ?)";
            $stmt = $conexion->prepare($insertUser);
            $stmt->bind_param("ss", $email, $password);

            if ($stmt->execute()) {
                $success = "Usuario registrado con éxito. <a href='login.php'>Iniciar sesión</a>";
            } else {
                $error = "Error al registrar el usuario.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - DiseñoSoft</title>
    <link rel="stylesheet" href="style-login.css">
</head>
<body>
    <div class="login-container">
        <h2>Registrarse</h2>
        <?php if (isset($error)): ?>
            <p class="error">Error al registrarse</p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success">Usuario registrado con éxito</p>
        <?php endif; ?>
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
        </form>
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>
