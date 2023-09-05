<?php
session_start();
if (!(isset($_REQUEST['pet-crear']) || isset($_REQUEST['crear']))) {
    header('Location:index.php');
}

require 'autoload.php';
require 'error_handler.php';

$usuario = ($_SESSION['usuario']) ?? false;
$bd = BD::getConexion();
$productoDao = new ProductoDao($bd);
$familiaDao = new FamiliaDao($bd);

if (isset($_REQUEST['crear'])) {

//recogemos los datos del formlario, trimamos las cadenas
    $nombre = ucwords(trim(filter_input(INPUT_POST, 'nombre')));
    $nombreError = filter_var($nombre, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => "/^[\w\s\-_]{2,100}$/"]]) === false;
    $nombreCorto = strtoupper(trim(filter_input(INPUT_POST, 'nombre_corto')));
    $nombreCortoError = filter_var($nombreCorto, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => "/^[a-zA-Z0-9]{2,15}$/"]]) === false;
    $pvp = filter_input(INPUT_POST, 'pvp', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $pvpError = filter_var($pvp, FILTER_VALIDATE_FLOAT, ["options" => ["min_range" => 0]]) === false;
    $descripcion = trim(filter_input(INPUT_POST, 'descripcion'));
    $familiaCodigo = filter_input(INPUT_POST, 'familia_codigo');
    $valores = [$nombreError, $nombreCortoError, $pvpError];
    $error = count(array_filter($valores)) > 0;
    if (!$error) {
        $producto = new Producto($nombre, $nombreCorto, $descripcion, $pvp, $familiaCodigo);
        try {
            $productoInsertado = $productoDao->crea($producto);
            $producto->setId($productoInsertado);
        } catch (PDOException $ex) {
            if ($ex->getcode() == 23000) {
                $errorDuplicadoNombreCorto = true;
            }
            error_log("Error al crear el producto " . $ex->getMessage());
            $productoInsertado = false;
        }
    }
}
if ($productoInsertado ?? true) {
    try {
        $familias = $familiaDao->recuperaTodo();
    } catch (PDOException $ex) {
        error_log("Error al recuperar información de familias " . $ex->getMessage());
        $familias = [];
    }
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
        <!--Fontawesome CDN-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <title>Crear</title>
    </head>
    <body class="bg-info">
        <div class="float-end d-inline-flex m-5">
            <i class="fas fa-user mr-3 fa-2x"></i>
            <input type="text" size='10px' value="<?= $usuario ?>"
                   class="form-control mr-2 bg-transparent text-white" disabled>
            <a href='index.php?logout' class='btn btn-danger mr-2'>Salir</a>
        </div>
        <br><br>
        <h3 class="text-center mt-2 font-weight-bold">Crear Producto</h3>
        <div class="container mt-3">
            <?php if (isset($productoInsertado) && $productoInsertado): ?>
                <h3 class="text-center mt-2 font-weight-bold">Producto creado con éxito</h3>
                <a href="listado.php" class="btn btn-warning">Volver</a>
            <?php elseif (isset($productoInsertado) && !$productoInsertado && !isset($errorDuplicadoNombreCorto)): ?>
                <h3 class="text-center mt-2 font-weight-bold">Ha habido un problema para crear el producto</h3>
                <a href="listado.php" class="btn btn-warning">Volver</a>
            <?php else: ?>
                <form name="crear" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="<?= "form-control " . ((isset($nombreError) && $nombreError) ? "is-invalid" : "") ?>" id="nombre" placeholder="Nombre"
                                   name="nombre" value="<?= (isset($nombre) ? htmlspecialchars($nombre, ENT_NOQUOTES, 'UTF-8') : '') ?>">
                            <div class="col-sm-10 invalid-feedback">
                                <p>Introduce nombre correcto</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nombre_corto" class="form-label">Nombre Corto</label>
                            <input type="text" class="<?= "form-control " . (isset($errorDuplicadoNombreCorto) || (isset($nombreCortoError) && $nombreCortoError) ? "is-invalid" : "") ?>" id="nombre_corto" placeholder="Nombre Corto"
                                   name="nombre_corto" value="<?= (isset($nombreCorto) ? htmlspecialchars($nombreCorto, ENT_NOQUOTES, 'UTF-8') : '') ?>">
                            <div class="col-sm-10 invalid-feedback">
                                <p><?= (isset($errorDuplicadoNombreCorto) && $errorDuplicadoNombreCorto) ? "Nombre corto duplicado" : "Introduce nombre corto correcto" ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="pvp" class="form-label">Precio (€)</label>
                            <input type="number" class="<?= "form-control " . ((isset($pvpError) && $pvpError) ? "is-invalid" : "") ?>" id="pvp" placeholder="Precio (€)"
                                   name="pvp" min="0" step="0.01" value="<?= (isset($pvp) ? htmlspecialchars($pvp, ENT_NOQUOTES, 'UTF-8') : '') ?>">
                            <div class="col-sm-10 invalid-feedback">
                                <p>Introduce un precio correcto</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="familia" class="form-label">Familia</label>
                            <select id="familia" class="form-control" name="familia_codigo">
                                <?php foreach ($familias as $familia): ?>
                                    <option value='<?= $familia->getCod() ?>' <?= (isset($familiaCodigo) && $familia->getCod() == $familiaCodigo) ? "selected" : "" ?>><?= $familia->getNombre() ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="d" rows="12"> <?= (isset($descripcion) ? htmlspecialchars($descripcion, ENT_NOQUOTES, 'UTF-8') : '') ?></textarea>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary m-3" name="crear" value="Crear">
                    <input type="reset" value="Limpiar" class="btn btn-success m-3" onclick="this.querySelectorAll('input[type=text]').forEach(function (input, i) {
                                input.value = '';
                            })">
                    <!-- <input type="reset" value="Limpiar" class="btn btn-success mr-3"> -->
                    <a href="listado.php" class="btn btn-warning">Volver</a>
                </form>
            <?php endif ?>
        </div>
    </body>
</html>


