<?php
/*
Funcionalidades a añadir:
Generar ticket o factura

Una vez tenga el carrito acabado, se debe guardar en la base de datos en una nueva tabla Carrito para poder recuperar el carrito una vez el usuario ha hecho login.

Los datos de esa tabla se borrarán con una función cuando el usuario finalice la compra.
*/
require_once "./admin/includes/crudProductos.php";
$productosObj = new Productos();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    session_start();
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }//Esto debería a ir a sessions.php y ser llamado desde allí, cambiarlo si da tiempo

    $productoCarrito = $productosObj->getById($id);
    $_SESSION['carrito'][] = $productoCarrito['Cod_producto'];

    print_r($_SESSION['carrito']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/Bootstrap/css/bootstrap.min.css">
    <title>Carrito</title>
</head>
<body>
    <?php include "./menu.php"; ?>

    <h1>Tu carrito</h1>

    <a href="index_inicio.php">
        <button class="btn btn-outline-danger">Volver</button>
    </a>

    <?php include "footer.php" ?> 
    <script src="./assets/Bootstrap/js/bootstrap.min.js"></script>   
</body>
</html>