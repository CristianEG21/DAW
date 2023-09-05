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

if (isset($_REQUEST['pagar'])) {
    unset($_SESSION['carrito']);
    $pagar = true;
} elseif (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
    $listado = [];

    foreach ($carrito as $k => $v) {
        try {
            $producto = recuperarProducto($bd, $k);
            $listado[$k] = [$producto->nombre, $producto->pvp];
        } catch (PDOException $ex) {
            error_log("Error al recuperar el producto " . $ex->getMessage());
        }
    }
    $bd = null;
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- css para usar Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- css Fontawesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" 
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" 
              crossorigin="anonymous">
        <title>Carrito</title>
    </head>
    <body class="bg-info">
        <div class="float-end d-inline-flex mt-2">
            <i class="fa fa-shopping-cart me-2 fa-2x"> </i>
            <?php if (isset($carrito)): ?>
                <input type="text" disabled class="form-control me-2 bg-transparent text-white" value="<?= (isset($carrito)) ? count($carrito) : 0 ?>" size="2px">
            <?php else: ?>
                <input type="text" disabled class="form-control me-2 bg-transparent text-white" value="0" size="2px">
            <?php endif ?>
            <i class="fas fa-user me-3 fa-2x"> </i>
            <input type="text" size='10px' value="<?= $usuario ?>"
                   class="form-control me-2 bg-transparent text-white" disabled>
            <a href="index.php?logout" class="btn btn-warning me-2">Salir </a>
        </div>
        <br>
        <?php if (isset($pagar) && $pagar): ?>
            <div class="container d-flex flex-column align-items-center">
                <h2 class="mt-4 font-weight-bold">Tienda onLine</h2>
                <h4 class="font-weight-bold">Pedido realizado Correctamente.</h4>
                <a href="listado.php" class="btn btn-danger mt-3">Hacer otra Compra</a>
            </div>
        <?php else: ?>
            <div class="container d-flex flex-column align-items-center mt-3">
                <h4 class="mt-4 font-weight-bold">Comprar Productos</h4>
                <div class="card text-white bg-success mb-3" style="width:40rem">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa fa-shopping-cart mr-2">Carrito</i></h5>
                        <?php if (!isset($carrito)): ?>
                            <p class='card-text'>Carrito Vacio</p>
                        <?php else: ?>
                            <div class='card-text'>
                                <ul>
                                    <?php foreach ($listado as $producto): ?>
                                        <li><?= "$producto[0], PVP ($producto[1]) €.</li>" ?></li>
                                    <?php endforeach ?>
                                </ul>
                                <hr>
                                <p><b>Total:</b><span class='m-3'><?= array_sum(array_column($listado, 1)) . "(€)" ?></span></p>
                            </div>                       
                        <?php endif ?>
                        <a href="listado.php" class="btn btn-primary mr-2">Volver</a>
                        <a href="carrito.php?pagar" class="btn btn-danger">Pagar</a>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </body>
</html>

