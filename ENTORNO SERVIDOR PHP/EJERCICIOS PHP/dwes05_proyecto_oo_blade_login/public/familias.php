<?php

session_start();

require_once '../vendor/autoload.php';
require_once '../src/error_handler.php';

use eftec\bladeone\BladeOne;
use App\BD\BD;
use App\Dao\FamiliaDao;

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
define("BLADEONE_MODE", 1); // (optional) 1=forced (test),2=run fast (production), 0=automatic, default value.
$blade = new BladeOne($views, $cache);

$bd = BD::getConexion();

$familiaDao = new FamiliaDao($bd);

if (isset($_SESSION['usuario'])) {
    $nombreUsuario = $_SESSION['usuario'];
    try {
        $familias = $familiaDao->recuperaTodo();
    } catch (PDOException $ex) {
        error_log("Error al recuperar información de familias " . $ex->getMessage());
        $familias = [];
    }
    echo $blade->run('familias', compact('nombreUsuario', 'familias'));
} else {
    echo $blade->run('login');
}