<?php
require_once "./includes/sessions.php";
$sesion = new Sessions();

if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/Bootstrap/css/bootstrap.min.css">
    <title>Mi cuenta</title>
</head>
<body>
    <?php include "./menu_admin.php"; ?>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <h1>Bienvenido al panel de administración</h1>
            </div>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Usuario y contraseña correctos.
                </div>
            </div>
            <div class="row">
                <p>Hola, <strong><?= $usuario['Nombre'] ?></strong>. Has accedido correctamente al área de administración.</p>
            </div>            
        </div>
    </div>

    <?php include "../footer.php"; ?>
    <script src="./assets/Bootstrap/js/bootstrap.min.js"></script>
</body>
</html>