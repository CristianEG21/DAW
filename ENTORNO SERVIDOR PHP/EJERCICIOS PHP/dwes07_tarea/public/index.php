<?php

require "../vendor/autoload.php";
require "../src/error_handler.php";

use eftec\bladeone\BladeOne;
use App\BD\BD;
use App\Modelo\Usuario;
use App\Dao\UsuarioDao;

session_start();

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

$bd = BD::getConexion();

$usuarioDao = new UsuarioDao($bd);

if (isset($_SESSION['usuario'])) {
    if (isset($_REQUEST['logout'])) {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', 0, '/');
        echo $blade->run("login");
    } else {
        header('Location:productos.php');
    }
} else if (isset($_POST['usuario'])) {
    $nombreUsuario = trim(filter_input(INPUT_POST, 'usuario', FILTER_UNSAFE_RAW));
    $pass = trim(filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW));
    $usuario = $usuarioDao->recuperaPorCredencial($nombreUsuario, $pass);
    $valid = !(is_null($usuario));
    if ($valid) {
        $_SESSION['usuario'] = $usuario;
    }
    $response['login'] = $valid;
    header('Content-type: application/json');
    echo json_encode($response);
    die;
} else {
    echo $blade->run("login");
}
