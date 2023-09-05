<?php
if (!isset($_REQUEST['id'])) { //si no mandamos el id volvemos a listado
header('Location:index.php');
}

require_once 'error_handler.php';
require_once 'conexion.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

try {
$consulta = "select * from productos where id=:i";
$stmt = $conProyecto->prepare($consulta);
$stmt->execute([':i' => $id]);
$producto = $stmt->fetch(PDO::FETCH_OBJ);
} catch (PDOException $ex) {
error_log("Error al recuperar información de producto " . $ex->getMessage());
$productoNoEncontrado = true;
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
        <title>Detalle</title>
    </head>
    <body class="bg-info">
        <h3 class="text-center mt-2 font-weight-bold">Detalle Producto</h3>
        <div class="container mt-3">
            <?php if (isset($productoNoEncontrado)): ?>
            <h3 class="text-center mt-2 font-weight-bold">Producto no encontrado</h3>
            <a href="index.php" class="btn btn-warning">Volver</a>
            <?php endif ?>
            <div class="card text-white bg-info mt-5 mx-auto">
                <div class="card-header text-center text-weight-bold">
                    <?= $producto->nombre ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center"><?= "Codigo: {$producto->id}" ?></h5>
                    <p class="card-text"><b>Nombre:</b><?= htmlspecialchars($producto->nombre, ENT_NOQUOTES, 'UTF-8') ?></p>
                    <p class="card-text"><b>Nombre Corto: </b> <?= htmlspecialchars($producto->nombre_corto, ENT_NOQUOTES, 'UTF-8') ?></p>
                    <p class="card-text"><b>Codigo Familia: </b><?= htmlspecialchars($producto->familia, ENT_NOQUOTES, 'UTF-8') ?></p>
                    <p class="card-text"><b>PVP (€): </b><?= htmlspecialchars($producto->pvp, ENT_NOQUOTES, 'UTF-8') ?></p>
                    <p class="card-text"><b>Descripción: </b><?= htmlspecialchars($producto->descripcion, ENT_NOQUOTES, 'UTF-8') ?></p>
                </div>
            </div>
            <div class="container mt-5 text-center">
                <a href="index.php" class="btn btn-warning">Volver</a>
            </div>
        </div>
    </body>
</html>

