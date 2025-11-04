<?php
require_once "./includes/sessions.php";
require_once "./includes/crudClientes.php";

$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}

$clienteObj = new Clientes();
$listaClientes = $clienteObj->showClientes();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
if (isset($_GET['mens'])){
    $mensaje = $_GET['mens'];
}


// Eliminar cliente
if ($accion === "eliminar" && $id) {
    $clienteObj->eliminarCliente($id);

    header("Location: clientes.php?mens=3");
    exit();
}

// Rellenar los valores del formulario crear/editar
if ($accion === "crear" || ($accion === "editar" && $id)) {
    if ($accion === "crear") {
        $client = [
            "Nombre" => '',
            "Apellidos" => '',
            "Telefono" => '',
            "Email" => '',
            "Password" => ''
        ];
    }

    if ($accion === "editar" && $id) {
        $client = $clienteObj->getClienteById($id);
    }
}

// Crear o Editar cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    
    if ($accion === "crear") {
        $clienteObj->insertarCliente($nombre, $apellidos, $telefono, $email, $password);

        header("Location: clientes.php?mens=1");
        exit();
     
    } elseif ($accion === "editar" && $id) {
        $clienteObj->actualizarCliente($id, $nombre, $apellidos, $telefono, $email);

        header("Location: clientes.php?mens=2");
        exit();
    } // Mensaje de error si alguno de los campos está duplicado
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/Bootstrap/css/bootstrap.min.css">
    <title>Gestión de clientes</title>
</head>
<body>
    <?php include "menu_admin.php" ?>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <h1>Clientes</h1>
            </div>
            <div class="row">
                <?php if ($mensaje == 1) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Cliente creado con éxito.</p>
                    </div>                    
                <?php elseif ($mensaje == 2) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Cliente modificado con éxito.</p>
                    </div>                    
                <?php elseif ($mensaje == 3) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Cliente eliminado con éxito.</p>
                    </div>                    
                <?php endif ?>
            </div>  
            <div class="row">
                <a href="clientes.php?accion=crear">
                    <button type="button" class="btn btn-outline-primary">Añadir nuevo cliente</button><br><br>
                </a>
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
                        <?php foreach ($listaClientes as $cliente) : ?>
                            <tr>
                                <td><?= $cliente['Nombre'] ?></td>
                                <td><?= $cliente['Apellidos'] ?></td>
                                <td><?= $cliente['Telefono'] ?></td>
                                <td><?= $cliente['Email'] ?></td>
                                <td>
                                    <a href="clientes.php?accion=editar&id=<?= $cliente['Cod_cliente'] ?>"><button type="button" class="btn btn-outline-success">Editar</button></a>
                                    <a href="clientes.php?accion=eliminar&id=<?= $cliente['Cod_cliente'] ?>" onclick="return confirm('¿Estás seguro?')"><button type="button" class="btn btn-outline-danger">Eliminar</button></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div> 
        </div> 
        <?php if ($accion === "crear" || ($accion === "editar" && $id)) : ?>
            <div class="container d-flex justify-content-center mt-4">
                <div class="card shadow-sm w-25">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">
                            <?= $accion === "crear" ? "Nuevo cliente" : "Editar cliente" ?>
                        </h3>

                        <form action="" method="POST" class="needs-validation" novalidate>
                            <div class="mb-4">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" 
                                    value="<?= htmlspecialchars($client['Nombre']) ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" 
                                    value="<?= htmlspecialchars($client['Apellidos']) ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" 
                                    value="<?= htmlspecialchars($client['Telefono']) ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">E-mail</label>
                                <input type="text" class="form-control" name="email" 
                                    value="<?= htmlspecialchars($client['Email']) ?>" required>
                            </div>
                            <!-- Adjuntar el test input etc -->
                            <?php if ($accion === "crear") : ?>
                                <div class="mb-4">
                                    <label class="form-label">Contraseña</label>
                                    <input type="text" class="form-control" name="password" 
                                        value="<?= htmlspecialchars($client['Password']) ?>" required>
                                </div>
                            <?php endif ?>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-outline-success">Guardar</button>
                                <a href="clientes.php" class="btn btn-outline-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif ?> 
    </div>

    <?php include "../footer.php" ?>
    <script src="./assets/Bootstrap/js/bootstrap.min.js"></script>
</body>
</html>