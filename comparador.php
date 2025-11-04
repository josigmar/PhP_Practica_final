<?php
require_once "./admin/includes/crudProductos.php";

$productosObj = new Productos();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $producto = $productosObj->getById($id);    
}

$listaProductos = $productosObj->getAll();

// Recoger datos del segundo producto 
$p2 = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id2 = $_POST['producto2'];
    $producto2 = $productosObj->getById($id2);
    $p2 = true;
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
        <div class="container">  
            <div class="row">  
                <!-- Producto original --> 
                <div class="col">    
                    <?php if (!empty($producto)) : ?>        
                        <div class="row">
                            <div class="col">
                                <h1><?= $producto['Modelo'] ?></h1>
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
                                <a href="carrito.php?id=<?= $producto['Cod_producto'] ?>">
                                    <button class="btn btn-outline-primary">Añadir al carrito</button>
                                </a> 
                            </div>
                            <div class="col">
                                <a href="index_productos.php?cat=<?=$producto['Categoria']?>">
                                    <button class="btn btn-outline-secondary">Volver</button>
                                </a> 
                            </div>
                        </div>                
                    <?php else : ?>
                            <div class="alert alert-danger" role="alert">
                                No se encontró el producto.
                            </div>
                    <?php endif ?>
                </div>

                <!-- Mostrar el segundo producto -->
                <?php if ($p2 == true) : ?>
                    <div class="col">                        
                        <div class="row">
                            <div class="col">
                                <h1><?= $producto2['Modelo'] ?></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <img src="assets/productos/<?= $producto2['Cod_producto'] ?>.avif" alt="<?= $producto2['Modelo'] ?>" width="500px">                       
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><strong>Marca: </strong><?= $producto2['Marca'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><strong>Peso: </strong><?= $producto2['Peso'] ?> gr.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><strong>Precio: </strong><?= $producto2['Precio'] ?> €</p>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <br><br>
            
            <div class="row">
                <!-- Selector de segundo producto -->
                <div class="col">                                
                    <form action="" method="POST">
                        <button type="submit" value="producto2" class="btn btn-outline-info">Comparar</button><br>
                        <select name="producto2">
                            <?php foreach ($listaProductos as $p) : ?>
                                <?php if ($producto['Categoria'] == $p['Categoria']) : ?>
                                    <option value="<?= $p['Cod_producto'] ?>"><?= $p['Modelo'] ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </form>
                </div>
                
                <!-- Resultados de la comparación -->
                <?php if ($p2 == true) : ?>
                    <div class="col">  
                        <table class="table table-light table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="1"></th>
                                    <th><?= $producto['Modelo'] ?></th>
                                    <th><?= $producto2['Modelo'] ?></th>
                                </tr>                
                            </thead>
                            <tbody>
                                <tr> 
                                    <td>Peso</td> 
                                    <td>
                                        <?php if ($producto['Peso'] <= $producto2['Peso']) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                            </svg>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                            </svg>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if ($producto2['Peso'] <= $producto['Peso']) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                            </svg>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                            </svg>
                                        <?php endif ?>
                                    </td>                    
                                    
                                </tr>
                                <tr>
                                    <td>Precio</td>
                                    <td>
                                        <?php if ($producto['Precio'] <= $producto2['Precio']) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                            </svg>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                            </svg>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if ($producto2['Precio'] <= $producto['Precio']) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                            </svg>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                            </svg>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Popularidad</td>
                                    <td>
                                        <?php if ($producto['Visitas'] >= $producto2['Visitas']) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                            </svg>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                            </svg>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if ($producto2['Visitas'] >= $producto['Visitas']) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                            </svg>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                            </svg>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        </div> 
    </div>

    <?php include "footer.php" ?>
    <script src="./assets/Bootstrap/js/bootstrap.min.js"></script>
</body>
</html>