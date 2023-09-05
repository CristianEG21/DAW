<?php
if (!(isset($_REQUEST['id']) || isset($_POST['modificar']))) {
    header('Location:index.php');
}
require_once 'error_handler.php';
require_once 'conexion.php';
if (isset($_POST['modificar'])) {
    $nombre = ucwords(trim(filter_input(INPUT_POST, 'nombre')));
    $nombreError = filter_var($nombre, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => "/^[\w\s\-_]{2,100}$/"]]) === false;
    $nombreCorto = strtoupper(trim(filter_input(INPUT_POST, 'nombre_corto')));
    $nombreCortoError = filter_var($nombreCorto, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => "/^[a-zA-Z0-9]{2,15}$/"]]) === false;
    $pvp = filter_input(INPUT_POST, 'pvp');
    $pvpError = filter_var($pvp, FILTER_VALIDATE_FLOAT, ["options" => ["min_range" => 0]]) === false;
    $descripcion = trim(filter_input(INPUT_POST, 'descripcion'));
    $familiaCodigo = filter_input(INPUT_POST, 'familia_codigo');
    $id = filter_input(INPUT_POST, 'id');
    $valores = [$nombreError, $nombreCortoError, $pvpError];
    $error = count(array_filter($valores)) > 0;
    if (!$error) {
        $modifica = "update productos set nombre=:nombre, nombre_corto=:nombre_corto, pvp=:pvp, descripcion=:descripcion, familia=:familia where id=:id";
        $stmtModificaProducto = $conProyecto->prepare($modifica);
        try {
            $productoModificado = $stmtModificaProducto->execute([
                ':nombre' => $nombre,
                ':nombre_corto' => $nombreCorto,
                ':pvp' => $pvp,
                ':familia' => $familiaCodigo,
                ':descripcion' => $descripcion,
                ':id' => $id
            ]);
        } catch (PDOException $ex) {
            if ($ex->getcode() == 23000) {
                $errorDuplicadoNombreCorto = true;
            }
            error_log("Error al modificar el producto " . $ex->getMessage());
            $productoModificado = false;
        }
        $stmtModificaProducto = null;
    }
} else {
    $id = filter_input(INPUT_GET, 'id'); 
    try {
        $consultaDatosProducto = "select * from productos where id=:id";
        $stmtObtenerDatosProducto = $conProyecto->prepare($consultaDatosProducto);
        $stmtObtenerDatosProducto->execute([':id' => $id]);
        $producto = $stmtObtenerDatosProducto->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        error_log("Error al recuperar información de producto " . $ex->getMessage());
        $productoNoEncontrado = true;
    }
    //no hace falta while, esta consulta devuelve una fila.
}
if (!isset($productoModificado) || (isset($productoModificado) && $productoModificado === false)) {
    try {
        $consultaFamilias = "select cod, nombre from familias order by nombre";
        $stmtObtenerFamilias = $conProyecto->prepare($consultaFamilias);
        $stmtObtenerFamilias->execute();
        $familias = $stmtObtenerFamilias->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        error_log("Error al recuperar información de familias " . $ex->getMessage());
    } finally {
        $stmtObtenerFamilias = null;
        $familias = [];
    }
}

$conProyecto = null;
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
        <title>Modificar</title>
    </head>
    <body class="bg-info">
        <h3 class="text-center mt-2 font-weight-bold">Modificar Producto</h3>
        <div class="container mt-3">
            <?php if (isset($productoModificado) && $productoModificado): ?>
                <h3 class="text-center mt-2 font-weight-bold">Producto modificado con éxito</h3>
                <a href="index.php" class="btn btn-warning">Volver</a>
            <?php elseif (isset($productoModificado) && !$productoModificado && !isset($errorDuplicadoNombreCorto)): ?>
                <h3 class="text-center mt-2 font-weight-bold">Ha habido un problema para modificar el producto</h3>
                <a href="index.php" class="btn btn-warning">Volver</a>
            <?php elseif (isset($productoNoEncontrado)) : ?>
                <h3 class="text-center mt-2 font-weight-bold">Ha habido un problema para encontrar el producto</h3>
                <a href="index.php" class="btn btn-warning">Volver</a>
            <?php else: ?>
                <form method="POST" action="<?= "{$_SERVER['PHP_SELF']}" ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="id" value="<?= $id ?>" >
                            <label for="nombre">Nombre</label>
                            <input type="text" class="<?= "form-control " . ((isset($nombreError) && $nombreError) ? "is-invalid" : "") ?>" 
                                   id="nombre" placeholder="Nombre" name="nombre"
                                   value="<?= (isset($producto)) ? htmlspecialchars($producto->nombre, ENT_NOQUOTES, 'UTF-8') : htmlspecialchars($nombre, ENT_NOQUOTES, 'UTF-8') ?>" >
                            <div class="col-sm-10 invalid-feedback">
                                <p>Introduce nombre correcto</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nombre_corto">Nombre Corto</label>
                            <input type="text" class="<?= "form-control " . ((isset($errorDuplicadoNombreCorto) || (isset($nombreCortoError) && $nombreCortoError)) ? "is-invalid" : "") ?>"
                                   id="nombre_corto" value = "<?= (isset($producto)) ? htmlspecialchars($producto->nombre_corto, ENT_NOQUOTES, 'UTF-8') : htmlspecialchars($nombreCorto, ENT_NOQUOTES, 'UTF-8') ?>" name="nombre_corto" >
                            <div class="col-sm-10 invalid-feedback">
                                <p><?= isset($errorDuplicadoNombreCorto) ? "Nombre corto duplicado" : "Introduce nombre corto correcto" ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="pvp">Precio (€)</label>
                            <input type="text" class="<?= "form-control " . ((isset($pvpError) && $pvpError) ? "is-invalid" : "") ?>"
                                   id="pvp" value='<?= isset($producto) ? htmlspecialchars($producto->pvp, ENT_NOQUOTES, 'UTF-8') : htmlspecialchars($pvp, ENT_NOQUOTES, 'UTF-8') ?>' name="pvp" >
                            <div class="col-sm-10 invalid-feedback">
                                <p>Introduce un precio correcto</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="familia">Familia</label>
                            <select class="form-control" name="familia_codigo">
                                <?php foreach ($familias as $familia): ?>
                                    <option value='<?= $familia->cod ?>' <?= ($familia->cod == (isset($producto) ? $producto->familia : $familiaCodigo)) ? "selected" : "" ?>><?= $familia->nombre ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <label for="descripcion">Descripción</label>
                            <textarea class="<?= "form-control " . ((isset($descripcionError) && $descripcionError) ? "is-invalid" : "") ?>" name="descripcion" id="descripcion" rows="12">
                                <?= isset($producto) ? htmlspecialchars($producto->descripcion, ENT_NOQUOTES, 'UTF-8') : htmlspecialchars($descripcion, ENT_NOQUOTES, 'UTF-8') ?>
                            </textarea>
                            <div class="col-sm-10 invalid-feedback">
                                <p>Introduce una descripción correcta</p>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary m-3" name="modificar" value="Modificar">
                    <input type="submit" class="btn btn-warning" formaction="index.php" value="Volver" >
                </form>
            <?php endif ?>
        </div>
    </body>
</html>