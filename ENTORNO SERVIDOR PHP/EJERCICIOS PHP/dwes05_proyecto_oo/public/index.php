<?php
session_start();

require_once 'autoload.php';
require_once 'error_handler.php';

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
} elseif (isset($_SESSION['usuario'])) {
    header('Location:./listado.php');
} elseif (isset($_POST['login'])) {
    $nombre = trim(filter_input(INPUT_POST, 'usuario'));
    $pwd = trim(filter_input(INPUT_POST, 'pass'));
    $errorLoginForm = (0 === strlen($nombre) || 0 === strlen($pwd));
    if (!$errorLoginForm) {
        $usuario = $usuarioDao->recuperaPorCredencial($nombre, $pwd);
        $errorCredenciales = is_null($usuario);
        if (!$errorCredenciales) {
            $_SESSION['usuario'] = $nombre;
            header('Location:listado.php');
        }
    }
} elseif (isset($_POST['invitado'])) {
    header('Location:listado.php');
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!--Fontawesome CDN-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <title>Login</title>
    </head>
    <body style="background:silver;" class="d-flex justify-content-center h-100">
        <div class="mt-5 card" style="width: 20rem;">
            <div class="card-header">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <form name='login' class="p-3" method='POST' action='<?= $_SERVER['PHP_SELF']; ?>'>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="<?= 'form-control ' . ((isset($errorLoginForm) && (empty($Usuario))) ? 'is-invalid' : ''); ?>" placeholder="usuario" name='usuario' >
                        <div class="invalid-feedback">
                            <p>Introduce el usuario</p>
                        </div>
                    </div>
                    <div class="input-group mb-3">                 
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" class="<?= 'form-control ' . ((isset($errorLoginForm) && (empty($pass))) ? 'is-invalid' : ''); ?>" placeholder="contraseña" name='pass' >
                        <div class="invalid-feedback">
                            <p>Introduce el password</p>
                        </div>
                    </div>
                    <?php if (isset($errorCredenciales) && $errorCredenciales): ?>
                        <div class="alert alert-danger" role="alert">
                            Credenciales incorrectos
                        </div>
                    <?php endif ?>
                    <div class="form-group">
                        <input type="submit" value="Acceso como Invitado" class="btn btn-info" name='invitado'>
                        <input type="submit" value="Login" class="btn float-end btn-success" name='login'>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>