<?php
require_once "./includes/sessions.php";
require_once "./includes/crudCategorias.php";

$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}

$categoriaObj = new Categorias();
$listaCategorias = $categoriaObj->showCategorias();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
if (isset($_GET['mens'])){
    $mensaje = $_GET['mens'];
}

// Eliminar categoría
if ($accion === "eliminar" && $id) {
    $categoriaObj->eliminarCategoria($id);

    header("Location: categorias.php?mens=3");
    exit();
}

// Rellenar los valores del formulario editar
$categoria = ['categoria' => ''];
if ($accion === "editar" && $id) {
    $categoria = $categoriaObj->getCategoriaById($id);
}

// Crear o Editar categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['categoria'] ?? '';
    if ($accion === "crear") {
        $categoriaObj->insertarCategoria($nombre);

        header("Location: categorias.php?mens=1");
        exit();

    } elseif ($accion === "editar" && $id) {
        $categoriaObj->actualizarCategoria($id, $nombre);

        header("Location: categorias.php?mens=2");
        exit();
    } 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/Bootstrap/css/bootstrap.min.css">
    <title>Gestión de categorías</title>
</head>
<body>
    <?php include "menu_admin.php" ?>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <h1>Categorías</h1>
            </div>  
            <div class="row">
                <?php if ($mensaje == 1) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Categoría creada con éxito.</p>
                    </div>                    
                <?php elseif ($mensaje == 2) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Categoría modificada con éxito.</p>
                    </div>                    
                <?php elseif ($mensaje == 3) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Categoría eliminada con éxito.</p>
                    </div>                    
                <?php endif ?>
            </div>  
            <div class="row">
                <a href="categorias.php?accion=crear">
                    <button type="button" class="btn btn-outline-primary">Añadir nueva categoría</button><br><br>
                </a>
            </div> 
            <div class="row">
                <table class="table table-light table-striped table-hover table-bordered">
                    <thead>
                        <tr>                
                            <th>Nombre de la categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaCategorias as $cat) : ?>
                            <tr>
                                <td><?= $cat['nombre_cat'] ?></td>
                                <td>
                                    <a href="categorias.php?accion=editar&id=<?= $cat['indice_cat'] ?>"<button type="button" class="btn btn-outline-success">Editar</button></a>
                                    <a href="categorias.php?accion=eliminar&id=<?= $cat['indice_cat'] ?>" onclick="return confirm('¿Estás seguro?')"><button type="button" class="btn btn-outline-danger">Eliminar</button></a>
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
                            <?= $accion === "crear" ? "Nueva categoría" : "Editar categoría" ?>
                        </h3>

                        <form action="" method="POST" class="needs-validation" novalidate>
                            <div class="mb-4">
                                <label class="form-label">Nombre de la categoría</label>
                                <input type="text" class="form-control" name="categoria" 
                                    value="<?= htmlspecialchars($categoria['nombre_cat']) ?>" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-outline-success">Guardar</button>
                                <a href="categorias.php" class="btn btn-outline-danger">Cancelar</a>
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