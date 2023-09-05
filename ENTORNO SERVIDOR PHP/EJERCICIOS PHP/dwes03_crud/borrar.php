<?php
if (!isset($_POST['pet-borrar'])) {
//si no me llega el código del producto a borrar
//nos vamos a index.php
    header('Location:index.php');
}

require_once 'error_handler.php';
require_once 'conexion.php';

$id = filter_input(INPUT_GET, 'id');

try {
    $delete = "delete from productos where id=:id";
    $stmtBorrarProducto = $conProyecto->prepare($delete);
    $productoBorrado = $stmtBorrarProducto->execute([':id' => $id]);
} catch (PDOException $ex) {
    error_log("Error al borrar el producto" . $ex->getMessage());
    $productoBorrado = false;
} finally {
    $stmt = null;
    $conProyecto = null;
}
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
        <title>Borrar</title>
    </head>
    <body class="bg-info">
        <h3 class="text-center mt-2 font-weight-bold">Borrar Producto</h3>
        <div class="container mt-3">
            <?php if (isset($productoBorrado) && $productoBorrado): ?>
                <h3 class="text-center mt-2 font-weight-bold">Producto borrado con éxito</h3>
                <a href="index.php" class="btn btn-warning">Volver</a>
            <?php elseif (isset($productoModificado) && !$productoBorrado): ?>
                <h3 class="text-center mt-2 font-weight-bold">Ha habido un problema para borrar el producto</h3>
                <a href="index.php" class="btn btn-warning">Volver</a>
            <?php endif ?>
        </form>
    </div>
</body>
</html>
