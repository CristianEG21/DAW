<?php
session_start();
if (!isset($_POST['pet-borrar'])) {
//si no me llega el código del producto a borrar
//nos vamos a listado.php
    header('Location:listado.php');
}
require_once 'autoload.php';
require_once 'error_handler.php';

$bd = BD::getConexion();

$id = filter_input(INPUT_POST, 'id');

$productoDao = new ProductoDao($bd);

try {
    $productoBorrado = $productoDao->elimina($id);
} catch (PDOException $ex) {
    error_log("Error al borrar el producto" . $ex->getMessage());
    $productoBorrado = false;
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
        <title>Borrar</title>
    </head>
    <body class="bg-info">
        <div class="float-end d-inline-flex m-5">
            <i class="fas fa-user mr-3 fa-2x"></i>
            <input type="text" size='10px' value="<?= $usuario ?>"
                   class="form-control mr-2 bg-transparent text-white" disabled>  
            <a href='index.php?logout' class='btn btn-danger mr-2'>Salir</a>
        </div>
        <h3 class="text-center mt-2 font-weight-bold">Borrar Producto</h3>
        <div class="container mt-3">
            <?php if (isset($productoBorrado) && $productoBorrado): ?>
                <h3 class="text-center mt-2 font-weight-bold">Producto borrado con éxito</h3>
                <a href="index.php" class="btn btn-warning">Volver</a>
            <?php elseif (isset($productoBorrado) && !$productoBorrado): ?>
                <h3 class="text-center mt-2 font-weight-bold">Ha habido un problema para borrar el producto</h3>
                <a href="index.php" class="btn btn-warning">Volver</a>
            <?php endif ?>
        </div>
    </body>
</html>
