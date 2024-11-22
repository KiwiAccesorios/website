<?php

require './Conexion/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password']);
    if (!empty($password)) {

        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
?>

<form method="POST" action="">
<h1>actualizar contraseña</h1>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Actualizar</button>
 </form>