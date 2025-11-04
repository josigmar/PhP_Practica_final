<?php
/*
Gestión de archivos para que se puedan subir las imágenes de los nuevos productos (dejar para el final por si no me da tiempo)
*/
require_once "./includes/sessions.php";
require_once "./includes/crudCategorias.php";
require_once "./includes/crudProductos.php";

$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}

$categoriaObj = new Categorias();
$listaCategorias = $categoriaObj->showCategorias();

$productoObj = new Productos();
$listaProductos = $productoObj->getAll();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
if (isset($_GET['mens'])){
    $mensaje = $_GET['mens'];
}

// Eliminar producto
if ($accion === "eliminar" && $id) {
    $productoObj->eliminarProducto($id);

    header("Location: productos.php?mens=3");
    exit();
}

// Rellenar los valores del formulario crear/editar
if ($accion === "crear" || ($accion === "editar" && $id)) {
    if ($accion === "crear") {
        $product = [
            "Cod_producto" => '',
            "Categoria" => '',
            "Modelo" => '',
            "Marca" => '',
            "Peso" => '',
            "Precio" => '',
            "Stock" => ''
        ];
    }

    if ($accion === "editar" && $id) {
        $product = $productoObj->getById($id);
    }
}

// Crear o Editar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    $categoria = $_POST['categoria'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $marca = $_POST['marca'] ?? '';
    $peso = $_POST['peso'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $stock = $_POST['stock'] ?? '';

    if ($accion === "crear") {
        $ultimoData = $productoObj->getUltimoCodigoByCategoria($categoria);
        $ultimoCodigo = (int)($ultimoData['MAX(Cod_producto)']);
        $cod_producto = $ultimoCodigo + 1;

        $productoObj->insertarProducto($cod_producto, $categoria, $modelo, $marca, $peso, $precio, $stock);

        header("Location: productos.php?mens=1");
        exit();

    } elseif ($accion === "editar" && $id) {
        $cod_producto = $_POST['cod_producto'];
        $productoObj->actualizarProducto($id, $cod_producto, $categoria, $modelo, $marca, $peso, $precio, $stock);

        header("Location: productos.php?mens=2");
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
    <title>Gestión de productos</title>
</head>
<body>
    <?php include "menu_admin.php" ?>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <h1>Productos</h1>
            </div>          
            <div class="row">
                <?php if ($mensaje == 1) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Producto creado con éxito.</p>
                    </div>                    
                <?php elseif ($mensaje == 2) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Producto modificado con éxito.</p>
                    </div>                    
                <?php elseif ($mensaje == 3) : ?>
                    <div class="alert alert-success" role="alert">
                        <p>Producto eliminado con éxito.</p>
                    </div>                    
                <?php endif ?>
            </div>  
            <div class="row">
                <a href="productos.php?accion=crear">
                    <button type="button" class="btn btn-outline-primary">Añadir nuevo producto</button><br><br>
                </a>
            </div>  
            <div class="row">
                <table class="table table-light table-striped table-hover table-bordered">
                    <thead>
                        <tr>                
                            <th>Código de producto</th>
                            <th>Categoría</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Peso</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaProductos as $producto) : ?>
                            <tr>
                                <td><?= $producto['Cod_producto'] ?></td>
                                <td><?= $producto['nombre_cat'] ?></td>
                                <td><?= $producto['Modelo'] ?></td>
                                <td><?= $producto['Marca'] ?></td>
                                <td><?= $producto['Peso'] ?></td>
                                <td><?= $producto['Precio'] ?></td>
                                <td><?= $producto['Stock'] ?></td>
                                <td>
                                    <a href="productos.php?accion=editar&id=<?= $producto['Cod_producto'] ?>"><button type="button" class="btn btn-outline-success">Editar</button></a>
                                    <a href="productos.php?accion=eliminar&id=<?= $producto['Cod_producto'] ?>" onclick="return confirm('¿Estás seguro?')"><button type="button" class="btn btn-outline-danger">Eliminar</button></a>
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
                            <?= $accion === "crear" ? "Nuevo producto" : "Editar producto" ?>
                        </h3>

                        <form action="" method="POST" class="needs-validation" novalidate>                     
                            <!-- CÓDIGO DEL PRODUCTO -->
                            <!-- Si se crea producto el código_producto se oculta porque se genera automáticamente -->
                            <!-- Si se edita el producto el código_producto es visible y modificable -->
                            <?php if ($accion === "editar" && $id) : ?> 
                                <div class="mb-3">
                                    <label class="form-label">Código de producto</label>
                                    <input type="text" class="form-control" name="cod_producto" 
                                        value="<?= htmlspecialchars($product['Cod_producto']) ?>" required>
                                </div>
                            <?php endif ?>

                            <div class="mb-3">
                                <label class="form-label">Categoría del producto</label>
                                <select name="categoria" class="form-select">
                                    <?php foreach ($listaCategorias as $cat) : ?>
                                        <option value="<?= $cat['indice_cat'] ?>" 
                                            <?= $cat['indice_cat'] == $product['Categoria'] ? 'selected' : '' ?>>
                                            <?= $cat['nombre_cat'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>   

                            <div class="mb-3">
                                <label class="form-label">Modelo</label>
                                <input type="text" class="form-control" name="modelo" 
                                    value="<?= htmlspecialchars($product['Modelo']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Marca</label>
                                <input type="text" class="form-control" name="marca" 
                                    value="<?= htmlspecialchars($product['Marca']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Peso</label>
                                <input type="text" class="form-control" name="peso" 
                                    value="<?= htmlspecialchars($product['Peso']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Precio</label>
                                <input type="text" class="form-control" name="precio" 
                                    value="<?= htmlspecialchars($product['Precio']) ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Stock</label>
                                <input type="text" class="form-control" name="stock" 
                                    value="<?= htmlspecialchars($product['Stock']) ?>" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-outline-success">Guardar</button>
                                <a href="productos.php" class="btn btn-outline-danger">Cancelar</a>
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