<?php
session_start();
//Hacemos el autoload de las clases
require_once 'autoload.php';
require_once 'error_handler.php';

$bd = BD::getConexion();

$productoDao = new ProductoDao($bd);

try {
    $productos = $productoDao->recuperaTodo();
} catch (PDOException $ex) {
    error_log("Error al recuperar información de productos " . $ex->getMessage());
    $productos = [];
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
        <title>CRUD Productos</title>
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
        <h3 class="text-center mt-2 font-weight-bold">Gestión de Productos</h3>
        <div class="container mt-3">
            <a href="crear.php?pet-crear"  class="btn btn-success mt-2 mb-2 <?= (!$usuario ? 'disabled' : '') ?>">Crear</a>
            <table class="table table-striped table-dark">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Detalle</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr class='text-center'>
                            <th scope="row">
                                <a class="btn btn-warning mr2" href="detalle.php?id=<?= $producto->getId() ?>">Detalle</a>
                            </th>
                            <td><?= $producto->getId() ?></td>
                            <td><?= htmlspecialchars($producto->getNombre(), ENT_NOQUOTES, 'UTF-8') ?></td>
                            <td>
                                <a class="btn btn-warning mr2 <?= (!$usuario ? 'disabled' : '') ?>"
                                   href="modificar.php?id=<?= $producto->getId() ?>">Actualizar</a>
                                   <?php if ($usuario): ?>
                                    <form action="borrar.php" method='POST' class="d-inline">
                                        <input type="hidden" name="id" value="<?= $producto->getId() ?>"> <!-- mandamos el código del producto a borrar -->
                                        <input type="submit" onclick="return confirm('¿Borrar Producto?')" class="btn btn-danger" value="Borrar" name="pet-borrar">
                                    </form>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

