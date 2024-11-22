<?php
session_start();
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $mensaje = trim($_POST['mensaje']);
    
    if (!empty($nombre) && !empty($email) && !empty($mensaje)) {

        echo "<script type='text/javascript'>document.getElementById('mensaje-notificacion').innerHTML = 'Enviado correctamente';</script>";
    } else {
        echo "<script type='text/javascript'>document.getElementById('mensaje-notificacion').innerHTML = 'Por favor, completa todos los campos.';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIWI ACCESORIOS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="https://i.ibb.co/JCdbNk6/lgoo.jpg">
    <script src="https://kit.fontawesome.com/b3dfc81ff8.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="./images/logo.jpg" alt="Logo" class="logo-img">
            <h2 class="logo">KIWI ACCESORIOS</h2>
        </div>
        <input type="checkbox" id="check">
        <label for="check" class="mostrar-menu">&#8801</label>
        <nav class="menu">
            <a href="#">Inicio</a>
            <a href="#personas">Sobre Nosotros</a>
            <a href="#contacto">Contacta con nosotros</a>
            <?php
            if (isset($_SESSION['email'])) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
                    $_SESSION = [];

                    if (ini_get("session.use_cookies")) {
                        $params = session_get_cookie_params();
                        setcookie(session_name(), '', time() - 42000,
                            $params["path"], $params["domain"],
                            $params["secure"], $params["httponly"]
                        );
                    }
                    session_destroy();
                    header("Location: index.php");
                    exit;
                }
                echo '
                <form action="" method="POST" style="display: inline;">
                 <a ><button style="width: 19%;" type="submit" name="logout" id="logoutBtn" class="name">Cerrar Sesión</button></a>
                </form>';
            } else {
                echo '<a href="Login.php" id="loginBtn" class="name">Iniciar Sesión</a>';
            }
            ?>

            <label for="check" class="esconder-menu">&#215</label>
        </nav>
    </header>