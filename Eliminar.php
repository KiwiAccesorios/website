<?php

require './Conexion/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $stmt = $conexion->prepare("DELETE FROM usuarios WHERE email = ? AND password = ?");
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: index.php"); 
                exit();
            } else {
                $error = "El usuario no existe o la contraseña es incorrecta.";
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
        <h2>Eliminar cuenta</h2>
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
            <button type="submit">Eliminar Cuenta</button>
     </form>
    </div>
</body>
</html>
