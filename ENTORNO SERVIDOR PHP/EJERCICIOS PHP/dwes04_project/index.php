<?php
session_start();

require_once 'error_handler.php';
$bd = require_once 'conexion.php';
require_once 'consultas.php';

if (isset($_SESSION['usuario'])) {
    if (isset($_REQUEST['logout'])) {
        session_unset();
        session_destroy();
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
        );
    } else {
        header('Location:listado.php');
        die();
    }
} else {
    if (isset($_POST['login'])) {
        $_POST = filter_var($_POST, FILTER_CALLBACK, ['options' => 'trim']);
        $nombreUsuario = filter_input(INPUT_POST, 'usuario');
        $pass = filter_input(INPUT_POST, 'pass');
        $errorLoginForm = empty($nombreUsuario) || empty($pass);
        if (!$errorLoginForm) {
            try {
                $credencialesOK = autenticarUsuario($bd, $nombreUsuario, $pass);
                if ($credencialesOK) {
                    $_SESSION['usuario'] = $nombreUsuario;
                    header('Location:listado.php');
                    die();
                }
            } catch (PDOEXception $ex) {
                error_log("Error al autenticar usuario " . $ex->getMessage());
                $errorBBDDAutenticacion = true;
            }
        }
    }
}
$bd = null;
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
    <body class="h-100 bg-info d-flex justify-content-center">      
        <div class="mt-5 card" style="width: 20rem;">
            <div class="card-header">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <form name="login" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="<?= 'form-control ' . ((isset($errorLoginForm) && (empty($nombreUsuario))) ? 'is-invalid' : ''); ?>" placeholder="usuario" name='usuario' >
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
                    <?php if (isset($credencialesOK) && !$credencialesOK): ?>
                        <div class="alert alert-danger" role="alert">
                            Credenciales incorrectos
                        </div>
                    <?php endif ?>
                    <?php if (isset($errorBBDDAutenticacion)): ?>
                        <div class="alert alert-danger" role="alert">
                            Problemas para autenticar su acceso
                        </div>
                    <?php endif ?>
                    <div class="form-group">
                        <input type="submit" value="Login" class="btn float-end btn-success" name="login">
                    </div>
                </form>
            </div>           
        </div>
    </body>
</html>

