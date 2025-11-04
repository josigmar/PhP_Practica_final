<?php
/*
En el login debe aparecer una opcion recordar contraseña para que se envíe enlace de recuperar contraseña
*/
require_once "./admin/includes/sessions.php";

$sesion = new Sessions();
if (isset($_GET['mens'])){
    $mensaje = $_GET['mens'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['email'];
    $clave = $_POST['password'];

    $datos = $sesion->comprobarCredenciales($usuario, $clave);
    if ($datos) {
        $sesion->crearSesion($datos);
        if ($datos['Cod_cliente'] == '100') {
            header("Location: admin/index_admin.php");
            exit();
        } else {
            header("Location: admin/index.php");
            exit();
        }
    } else {
        header("Location: login.php?mens=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/Bootstrap/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
    <?php include "menu.php" ?>

    <div class="container-fluid">   
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Inicia sesión</h1>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php if ($mensaje == 1) : ?>
                        <div class="alert alert-danger" role="alert">
                            Usuario o contraseña incorrectos.
                        </div>   
                    <?php endif ?>                  
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                            <div id="emailHelp" class="form-text">Este sitio no compartirá tu dirección de e-mail con nadie más.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>

    <?php include "footer.php" ?>
    <script src="./assets/Bootstrap/js/bootstrap.min.js"></script>
</body>
</html>