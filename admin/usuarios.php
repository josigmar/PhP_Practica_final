<?php
//Por hacer: Si el usuario es el que pide cambiar la contraseña que se le envíe un enlace
// Mensaje de error al editar si alguno de los campos está duplicado con otro cliente de la DB
require_once "./includes/sessions.php";
require_once "./includes/crudClientes.php";

$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}
$usuario = $_SESSION['usuario'];

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
if (isset($_GET['mens'])){
    $mensaje = $_GET['mens'];
}
$mostrar_form_pass = false;

$usuarioObj = new Clientes();

// Rellenar los valores del formulario
if ($accion === "editar" && $id) {
    $user = $usuarioObj->getClienteById($id);
}

if ($accion === "editarPass" && $id) {
    $mostrar_form_pass = true;
}

// Editar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($accion === "editar" && $id) {
        $usuarioObj->actualizarCliente($id, $nombre, $apellidos, $telefono, $email);

        header("Location: usuarios.php?mens=1");
        exit();
    } 
    
    if ($accion === "editarPass" && $id) {
        $password_nueva = $_POST['password_nueva'] ?? '';
        $password_repetir = $_POST['password_repetir'] ?? '';

        if ($password_nueva === $password_repetir) {
            $password = password_hash($password_nueva, PASSWORD_DEFAULT);

            $usuarioObj->actualizarPassword($id, $password);

            header("Location: usuarios.php?mens=2");
            exit();

        } else {
            header("Location: usuarios.php?accion=editarPass&id={$usuario['Cod_cliente']}&mens=3");
            exit();
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/Bootstrap/css/bootstrap.min.css">
    <title>Gestión de usuario</title>
</head>
<body>
    <?php include "menu.php" ?>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <h1>Cuenta de usuario</h1>
            </div> 
            <div class="row">
                <?php if ($mensaje == 1) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Datos actualizados con éxito.</p>
                    </div>                    
                <?php elseif ($mensaje == 2) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Contraseña actualizada con éxito.</p>
                    </div>                    
                <?php elseif ($mensaje == 3) : ?>
                    <div class="alert alert-danger" role="alert">
                        <p>Las contraseñas no coinciden.</p>
                    </div>                    
                <?php endif ?>
            </div>
            <div class="row">
                <table class="table table-light table-striped table-hover table-bordered">
                    <thead>
                        <tr>                
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Teléfono</th>
                            <th>E-mail</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $usuario['Nombre'] ?></td>
                            <td><?= $usuario['Apellidos'] ?></td>
                            <td><?= $usuario['Telefono'] ?></td>
                            <td><?= $usuario['Email'] ?></td>
                            <td>
                                <a href="usuarios.php?accion=editar&id=<?= $usuario['Cod_cliente'] ?>"><button type="button" class="btn btn-outline-success">Editar</button></a>
                                <a href="usuarios.php?accion=editarPass&id=<?= $usuario['Cod_cliente'] ?>"><button type="button" class="btn btn-outline-warning">Cambiar contraseña</button></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> 
        </div>
        <div class="container d-flex justify-content-center mt-4">
            <div class="card shadow-sm w-25">
                <div class="card-body">
                    <form action="" method="POST" class="needs-validation" novalidate>
                        <?php if ($accion === "editar" && $id) : ?>
                            <div class="row">
                                <h3 class="card-title text-center mb-4">
                                    Editar datos
                                </h3>
                            </div> 
                            <div class="mb-4">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" 
                                    value="<?= htmlspecialchars($user['Nombre']) ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" 
                                    value="<?= htmlspecialchars($user['Apellidos']) ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" 
                                    value="<?= htmlspecialchars($user['Telefono']) ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">E-mail</label>
                                <input type="text" class="form-control" name="email" 
                                    value="<?= htmlspecialchars($user['Email']) ?>" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-outline-success">Guardar</button>
                                <a href="usuarios.php" class="btn btn-outline-danger">Cancelar</a>
                            </div>
                        <?php endif ?>

                        <?php if ($mostrar_form_pass) : ?>
                            <div class="row">
                                <h3 class="card-title text-center mb-4">
                                    Editar contraseña
                                </h3>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Nueva contraseña</label>
                                <input type="password" class="form-control" name="password_nueva">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Repetir contraseña</label>
                                <input type="password" class="form-control" name="password_repetir">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-outline-success">Cambiar contraseña</button>
                                <a href="usuarios.php" class="btn btn-outline-danger">Cancelar</a>
                            </div>
                        <?php endif ?> 
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include "../footer.php" ?>
    <script src="./assets/Bootstrap/js/bootstrap.min.js"></script>
</body>
</html>