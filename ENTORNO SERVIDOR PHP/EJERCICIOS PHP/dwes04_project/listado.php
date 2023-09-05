<?php
session_start();
$bd = require_once 'conexion.php';
require_once 'consultas.php';
require_once 'error_handler.php';

if (!isset($_SESSION['usuario'])) {
    header('Location:index.php');
    die();
}

$usuario = $_SESSION['usuario'];

if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
}
if (isset($_POST['vaciar'])) {
    $carrito = [];
    $_SESSION['carrito'] = $carrito;
} else if (isset($_POST['comprar'])) {
    $id = filter_input(INPUT_POST, 'id');
    $carrito[$id] = $id;
    $_SESSION['carrito'] = $carrito;
}
try {
    $productos = recuperarProductos($bd);
} catch (PDOException $ex) {
    error_log("Error al recuperar productos " . $ex->getMessage());
    $errorRecuperarProductos = true;
    $productos = [];
}
$bd = null;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0,
              maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- css para usar Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- css Fontawesome CDN-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
              crossorigin="anonymous">
        <title>listado</title>
    </head>
    <body class="bg-info">
        <div class="float-end d-inline-flex mt-2">
            <i class="fa fa-shopping-cart me-2 fa-2x"> </i>
            <input type="text" disabled class="form-control me-2 bg-transparent text-white" value="<?= (isset($carrito)) ? count($carrito) : 0 ?>" size="2px">        
            <i class="fas fa-user me-3 fa-2x"> </i>
            <input type="text" size="10px" value="<?= $usuario ?>" class="form-control me-2 bg-transparent text-white" disabled>
            <a href="index.php?logout" class="btn btn-warning me-2">Salir</a>
        </div>
        <br>
        <h4 class="container text-center mt-4 font-weight-bold">Tienda onLine</h4>
        <div class="container mt-3">
            <form class="form-inline" name="vaciar" method="POST" action='<?= $_SERVER['PHP_SELF'] ?>'>
                <a href="carrito.php" class="btn btn-success mr-2">Ir al carrito</a>
                <input type='submit' value='Vaciar Carrito' class="btn btn-danger" name="vaciar">
            </form>
            <table class="table table-striped table-dark mt-3">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Añadir</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Añadido</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <th scope="row" class="text-center">
                                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <input type="hidden" name="id" value="<?= $producto->id ?>">
                                    <input type="submit" class="btn btn-primary" name="comprar" value="Añadir">
                                </form>
                            </th>
                            <td><?= $producto->nombre ?>, Precio: <?= $producto->pvp ?> (€)</td>
                            <td class="text-center">
                                <?php if (isset($carrito[$producto->id])): ?>
                                    <i class="fas fa-check fa-2x"></i>
                                <?php else: ?>
                                    <i class="far fa-times-circle fa-2x"></i>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </body>
</html>