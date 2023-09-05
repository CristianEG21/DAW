<?php
require_once 'error_handler.php';
require_once 'conexion.php';

$consultaObtenerProductos = "select id, nombre from productos order by nombre";
$stmtObtenerProductos = $conProyecto->prepare($consultaObtenerProductos);
try {
    $stmtObtenerProductos->execute();
    $productos = $stmtObtenerProductos->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $ex) {
    error_log("Error al recuperar los productos " . $ex->getMessage());
    $productos = [];
} finally {
    $stmtObtenerProductos = null;
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
        <title>CRUD Productos</title>
    </head>
    <body class="bg-info">
        <h3 class="text-center mt-2 font-weight-bold">Gestión de Productos</h3>
        <div class="container mt-3">
            <a href="crear.php?pet-crear" class='btn btn-success mt-2 mb-2'>Crear</a>
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
                                <a class="btn btn-warning mr2" href="detalle.php?id=<?= $producto->id ?>">Detalle</a>
                            </th>
                            <td><?= $producto->id ?></td>
                            <td><?= htmlspecialchars($producto->nombre, ENT_NOQUOTES, 'UTF-8') ?></td>
                            <td>
                                <a class="btn btn-warning mr2" href="modificar.php?id=<?= $producto->id ?>">Actualizar</a>
                                <form action="borrar.php" method='GET' class="d-inline">
                                    <input type="hidden" name="id" value="<?= $producto->id ?>"> <!-- mandamos el código del producto a borrar -->
                                    <input type="submit" onclick="return confirm('¿Borrar Producto?')" class="btn btn-danger" value="Borrar" name="pet-borrar">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

