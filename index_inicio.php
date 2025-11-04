<?php
require_once "./admin/includes/crudProductos.php";

$productosObj = new Productos();
$populares = $productosObj->getPopulares();
$ultimos = $productosObj->getUltimos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/Bootstrap/css/bootstrap.min.css">
    <title>Tienda de tenis</title>
</head>
<body>
    <?php include "menu.php"; ?>

    <div class="container-fluid">

        <h1>Bienvenid@ a Tienda de tenis</h1>
        <br><br>
        
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3><span class="badge bg-light"><img src="assets/mas_popular.png" alt="Producto popular" width="40px"></span>  Productos más populares</h3>
                </div>
            </div>
            <div class="row">
                <?php foreach ($populares as $popular) : ?>
                    <div class="col">
                        <a href="producto.php?id=<?= $popular['Cod_producto'] ?>&ori=inicio">
                            <img src="assets/productos/<?= $popular['Cod_producto'] ?>.avif" alt="<?= $popular['Modelo'] ?>" width="200px">
                        </a> 
                        <p><?= $popular['Modelo'] ?></p>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <br><br><br>

        <div class="container">
            <div class="row">
                <div class="col">
                    <h3><span class="badge bg-light"><img src="assets/ultimas_unidades.png" alt="Producto popular" width="60px"></span>  Últimas unidades</h3>
                </div>
            </div>
            <div class="row">
                <?php foreach ($ultimos as $ultimo) : ?>
                    <div class="col">
                        <a href="producto.php?id=<?= $ultimo['Cod_producto'] ?>&ori=inicio">
                            <img src="assets/productos/<?= $ultimo['Cod_producto'] ?>.avif" alt="<?= $ultimo['Modelo'] ?>" width="200px">
                        </a> 
                        <p><?= $ultimo['Modelo'] ?></p>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <br>
    </div>

    <?php include "footer.php" ?>
    <script src="./assets/Bootstrap/js/bootstrap.min.js"></script>
</body>
</html>