<?php

session_start();

require_once '../vendor/autoload.php';
require_once '../src/error_handler.php';

use eftec\bladeone\BladeOne;
use App\BD\BD;
use App\Dao\UsuarioDao;

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
define("BLADEONE_MODE", 1); // (optional) 1=forced (test),2=run fast (production), 0=automatic, default value.
$blade = new BladeOne($views, $cache);

$bd = BD::getConexion();

$usuarioDao = new UsuarioDao($bd);

if (isset($_REQUEST['logout'])) {
    session_unset();
    session_destroy();
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
    );
} else if (isset($_SESSION['usuario'])) {
    $nombreUsuario = $_SESSION['usuario'];
    echo $blade->run("portada", compact('nombreUsuario'));
    die;
} else if (isset($_POST['login'])) {
    $nombreUsuario = trim(filter_input(INPUT_POST, 'usuario'));
    $pass = trim(filter_input(INPUT_POST, 'pass'));
    $errorLoginForm = strlen($nombreUsuario) === 0 || strlen($pass) === 0;
    if (!$errorLoginForm) {
        $usuario = $usuarioDao->recuperaPorCredencial($nombreUsuario, $pass);
        $errorCredenciales = is_null($usuario);
        if (!$errorCredenciales) {
            $_SESSION['usuario'] = $nombreUsuario;
            echo $blade->run("portada", compact('nombreUsuario'));
            die;
        } else {
            echo $blade->run("login", compact('errorCredenciales'));
            die;
        }
    } else {
        echo $blade->run("login", compact('errorLoginForm', 'nombreUsuario', 'pass'));
        die;
    }
}

echo $blade->run("login");
