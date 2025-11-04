<?php
require_once "./admin/includes/crudCategorias.php";
require_once "./admin/includes/crudProductos.php";

$productosObj = new Productos();
$categoriaObj = new Categorias();
$categorias = $categoriaObj->showCategorias();

// Obtener los productos de una categoría
if (isset($_GET['cat'])) {
    $productosCat = $productosObj->getByCategoria($_GET['cat']);
}

// Ordenar los productos por precio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ordenValue = $_POST['orden'];
    
    if ($ordenValue == 'precioAsc') {
        $productosCat = $productosObj->getByPrecioAsc($_GET['cat']);
    }

    if ($ordenValue == 'precioDesc') {
        $productosCat = $productosObj->getByPrecioDesc($_GET['cat']);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/Bootstrap/css/bootstrap.min.css">
    <title>Productos</title>
</head>
<body>
    <?php include "menu.php"; ?>

    <div class="container-fluid">        
         <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Categorías</h1>
                </div>
            </div>
            <!-- Lista de categorias -->
            <div class="row">
                <div class="col">
                    <ul class="nav nav-tabs nav-fill">
                        <?php foreach ($categorias as $categoria) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index_productos.php?cat=<?=$categoria['indice_cat']?>"><?= $categoria['nombre_cat'] ?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                    <br><br>
                </div>
            </div>
            <!-- Lista de productos -->
            <div class="row">
                <?php foreach ($productosCat as $productoCat) : ?>
                    <div class="col">                    
                        <a href="producto.php?id=<?= $productoCat['Cod_producto'] ?>&ori=productos">
                            <img src="assets/productos/<?= $productoCat['Cod_producto'] ?>.avif" alt="<?= $productoCat['Modelo']?>" width="200px">
                        </a>        
                        <p><?= $productoCat['Modelo']?></p><br>                    
                    </div>
                <?php endforeach ?>                
            </div>
            <!-- Botones para ordenar por precio -->
            <?php if (isset($_GET['cat'])) : ?>            
                <div class="row justify-content-end">
                    <div class="col">                    
                        <form action="" method="POST">
                            <ul class="nav nav-pills justify-content-end">
                                <li class="nav-item">
                                    <button class="btn btn-outline-primary" type="submit" name="orden" value="precioAsc">Ordenar por precio asc</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn btn-outline-primary" type="submit" name="orden" value="precioDesc">Ordenar por precio desc</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div> 
    <br><br><br>  

    <?php include "footer.php" ?>
    <script src="./assets/Bootstrap/js/bootstrap.min.js"></script>
</body>
</html>