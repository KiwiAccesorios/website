<?php

require './Conexion/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);

    if (!empty($email) && !empty($password) && !empty($newPassword) && !empty($confirmPassword)) {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($password == $user['password']) {
                if ($newPassword === $confirmPassword) {
                    $updateStmt = $conexion->prepare("UPDATE usuarios SET password = ? WHERE email = ?");
                    $updateStmt->bind_param("ss", $newPassword, $email);

                    if ($updateStmt->execute()) {
                        echo "Contraseña actualizada con éxito.";
                        header("Location: login.php");
                        exit();
                    } else {
                        $error = "Error al actualizar la contraseña.";
                    }
                } else {
                    $error = "Las contraseñas no coinciden.";
                }
            } else {
                $error = "La contraseña actual es incorrecta.";
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Contraseña</title>
    <link rel="stylesheet" href="style-actualizar.css">
</head>
<body>

    <div class="form-container">
        <h2>Actualizar Contraseña</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="">
            <div class="input-group">
                <label for="email">Usuario</label>
                <input type="text" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Contraseña Actual</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="input-group">
                <label for="newPassword">Nueva Contraseña</label>
                <input type="password" id="newPassword" name="newPassword" required>
            </div>

            <div class="input-group">
                <label for="confirmPassword">Confirmar Nueva Contraseña</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>

            <button type="submit" class="button">Actualizar Contraseña</button>
        </form>
    </div>

</body>
</html>
