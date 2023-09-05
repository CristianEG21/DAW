<?php
session_start();
if (!isset($_REQUEST['id'])) { //si no mandamos el id volvemos a listado
    header('Location:listado.php');
}

require_once 'autoload.php';
require_once 'error_handler.php';

$bd = BD::getConexion();

$productoDao = new ProductoDao($bd);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

try {
    $producto = $productoDao->recuperaPorId($id);
} catch (PDOException $ex) {
    die("Error al recuperar el producto " . $ex->getMessage());
}

$usuario = ($_SESSION['usuario']) ?? false;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- css para usar Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!--Fontawesome CDN-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <title>Detalle</title>
    </head>
    <body class="bg-info">
        <div class="float-end d-inline-flex m-5">
            <i class="fas fa-user mr-3 fa-2x"></i>
            <input type="text" size='10px' value="<?= $usuario ?: 'invitado' ?>"
                   class="form-control mr-2 bg-transparent text-white" disabled>
                   <?php if ($usuario): ?>
                <a href='index.php?logout' class='btn btn-danger mr-2'>Salir</a>
            <?php else: ?>
                <a href='index.php' class='btn btn-primary mr-2'>Login</a>
            <?php endif ?>
        </div>
        <br><br>
        <h3 class="text-center mt-2 font-weight-bold">Detalle Producto</h3>
        <div class="container mt-3">
            <?php if (isset($productoNoEncontrado)): ?>
                <h3 class="text-center mt-2 font-weight-bold">Producto no encontrado</h3>
                <a href="listado.php" class="btn btn-warning">Volver</a>
            <?php endif ?>
            <div class="card text-white bg-info mt-5 mx-auto">
                <div class="card-header text-center text-weight-bold">
                    <?= $producto->getNombre() ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center"><?= "Codigo: {$producto->getId()}" ?></h5>
                    <p class="card-text"><b>Nombre: </b><?= htmlspecialchars($producto->getNombre(), ENT_NOQUOTES, 'UTF-8') ?></p>
                    <p class="card-text"><b>Nombre Corto: </b> <?= htmlspecialchars($producto->getNombreCorto(), ENT_NOQUOTES, 'UTF-8') ?></p>
                    <p class="card-text"><b>Codigo Familia: </b><?= htmlspecialchars($producto->getFamilia(), ENT_NOQUOTES, 'UTF-8') ?></p>
                    <p class="card-text"><b>PVP (€): </b><?= htmlspecialchars($producto->getPvp(), ENT_NOQUOTES, 'UTF-8') ?></p>
                    <p class="card-text"><b>Descripción: </b><?= htmlspecialchars($producto->getDescripcion(), ENT_NOQUOTES, 'UTF-8') ?></p>
                </div>
            </div>
            <div class="container mt-5 text-center">
                <a href="listado.php" class="btn btn-warning">Volver</a>
            </div>
        </div>
    </body>
</html>

