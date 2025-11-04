<?php
require_once "./admin/includes/crudProductos.php";

$productosObj = new Productos();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $productosObj->sumarVisita($id);
    $producto = $productosObj->getById($id);    
}

$origen = $_GET['ori'];

// Comprobar si es un producto popular
$populares = $productosObj->getPopulares();

$esPopular = false;
foreach ($populares as $popular) {
    if ($popular['Cod_producto'] == $producto['Cod_producto']) {
        $esPopular = true;
        break;
    }
}

// Comprobar si es últimas unidades
$ultimos = $productosObj->getUltimos();

$esUltimo = false;
foreach ($ultimos as $ultimo) {
    if ($ultimo['Cod_producto'] == $producto['Cod_producto']) {
        $esUltimo = true;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/Bootstrap/css/bootstrap.min.css">
    <title>Detalle Producto</title>
</head>
<body>
    <?php include "menu.php" ?>

    <div class="container-fluid">
        <?php if (!empty($producto)) : ?>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1>
                            <?= $producto['Modelo'] ?>
                            <span class="badge bg-light">
                                <?php if ($esPopular): ?>
                                    <img src="assets/mas_popular.png" alt="Producto popular" width="50px">
                                <?php endif ?>
                                <?php if ($esUltimo): ?>
                                    <img src="assets/ultimas_unidades.png" alt="Ultimas unidades" width="90px">                          
                                <?php endif ?>
                            </span>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <img src="assets/productos/<?= $producto['Cod_producto'] ?>.avif" alt="<?= $producto['Modelo'] ?>" width="500px">                        
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p><strong>Marca: </strong><?= $producto['Marca'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p><strong>Peso: </strong><?= $producto['Peso'] ?> gr.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p><strong>Precio: </strong><?= $producto['Precio'] ?> €</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="comparador.php?id=<?= $producto['Cod_producto'] ?>&cat=<?=$producto['Categoria']?>">
                            <button class="btn btn-outline-info">Comparar</button>
                        </a>  
                    </div>
                    <div class="col">
                        <a href="carrito.php?id=<?= $producto['Cod_producto'] ?>">
                            <button class="btn btn-outline-primary">Añadir al carrito</button>
                        </a>                        
                    </div>
                    <div class="col">
                        <?php if ($origen === "inicio") : ?>
                            <a href="index_inicio.php">
                                <button class="btn btn-outline-secondary">Volver</button>
                            </a>  
                        <?php elseif ($origen === "productos") : ?>  
                            <a href="index_productos.php?cat=<?=$producto['Categoria']?>">
                                <button class="btn btn-outline-secondary">Volver</button>
                            </a>   
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                No se encontró el producto.
            </div>
        <?php endif ?>
    </div>
    <br><br><br>

    <?php include "footer.php" ?>
    <script src="./assets/Bootstrap/js/bootstrap.min.js"></script>
</body>
</html>