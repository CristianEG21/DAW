<?php
require '../vendor/autoload.php';

use Clases\Clases1\ClasesOperacionesService;

$url = 'http://localhost/dwes06_tarea/servidorSoap/servicio.wsdl';

$codP = 3;
$codT = 2;
$codF = 'CONSOL';

$operaciones = new ClasesOperacionesService();

try {
    $pvp = $operaciones->getPvp($codP);
    $familias = $operaciones->getFamilias();
    $productos = $operaciones->getProductosFamilia($codF);
    $unidades = $operaciones->getStock($codP, $codT);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/stylesheet.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <p>PVP de producto de Código <?= $codP ?>: <?= $pvp ?? "No existe es Producto" ?> </p>
        <p>Código de Familas</p>
        <ul>
            <?php foreach ($familias as $familia): ?>
                <code><li><?= $familia ?></li></code>
            <?php endforeach ?> 
        </ul>
        <p>Productos de la Famila <?= $codF ?>: </p>
        <ul>
            <?php foreach ($productos as $producto): ?>
                <code><li><?= $producto ?></li></code>
            <?php endforeach ?>
        </ul>
        <p>Unidades del producto de código <?= $codP ?> en la tienda de código: <?= $codT ?>: <?= $unidades ?? "No hay información de stock" ?> </p>
    </body>
</html>
