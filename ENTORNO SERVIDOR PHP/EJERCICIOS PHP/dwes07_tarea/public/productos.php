<?php

require "../vendor/autoload.php";
require "../src/error_handler.php";

use eftec\bladeone\BladeOne;
use App\BD\BD;
use App\Modelo\Producto;
use App\Modelo\Voto;
use App\Dao\ProductoDao;
use App\Dao\VotoDao;

session_start();

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

$bd = BD::getConexion();

$productoDao = new ProductoDao($bd);
$votoDao = new VotoDao($bd);

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    if (empty($_REQUEST) || isset($_REQUEST['usuario'])) {
        try {
            $productos = $productoDao->recuperaTodo($bd);
        } catch (PDOException $ex) {
            die("Error al recuperar los productos " . $ex->getMessage());
        }
        echo $blade->run('productos', compact('usuario', 'productos'));
    } else {
        $productoId = filter_input(INPUT_POST, 'producto', FILTER_UNSAFE_RAW);
        $puntos = filter_input(INPUT_POST, 'puntos', FILTER_UNSAFE_RAW);
        $voto = new Voto($puntos, $productoId, $usuario->getUsuario());
        $response = [];
        try {
            $votoDao->crea($voto);
            $producto = $productoDao->recuperaProductoPorId($productoId);
            $response['votos'] = $producto->getVotos();
            $response['puntos'] = $producto->getpuntos();
        } catch (Exception $ex) {
            $response['error'] = true;
        }
        header('Content-type: application/json');
        echo json_encode($response);
        die;
    }
} else {
    echo $blade->run('login');
}    