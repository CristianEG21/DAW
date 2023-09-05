<?php

// El campo nombre debe tener más de 3 caracteres
function esValidoNombre(string $nombre): bool {
    return (strlen($nombre) > 3);
}

// El campo correo debe tener el formato adecuado
function esValidoPassword(string $pass): bool {
    return (strlen($pass) > 5);
}

// El campo correo debe tener el formato adecuado
function esValidoEmail(string $email): bool {
    return preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $email);
}

// Las contraseñas deben de  coincidir
function esValidoPasswords(string $pass1, string $pass2): bool {
    return ($pass1 === $pass2);
}

if (!empty($_POST) && isset($_POST['petvalida'])) {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $errorUsuario = !esValidoNombre($usuario);
    $password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);
    $errorPassword1 = !esValidoPassword($password1);
    $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
    $errorPasswords = !esValidoPasswords($password1, $password2);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $errorEmail = !esValidoEmail($email);
    $response = compact('errorUsuario', 'errorPassword1', 'errorPasswords', 'errorEmail');
    header('Content-type: application/json');
    echo json_encode($response);
    die;
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- Bootstrap Font Icon CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <title>Registro</title>
    </head>
    <body class="bg-info">
        <div class="container mt-5">
            <?php if (!empty($_POST) && !isset($_POST['petvalida'])): ?>
                <div class="alert alert-success" id="mensaje" role="alert">
                    Registro realizado con éxito
                </div>
            <?php else: ?>
                <div class="d-flex justify-content-center h-100">
                    <div class="card w-50">
                        <div class="card-header">
                            <h3><i class="bi bi-gear p-2"></i>Registro</h3>
                        </div>
                        <div class="card-body">
                            <form id="registro" name="registro" method="POST" novalidate>
                                <div class="input-group my-2">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control"  placeholder="usuario" id="usuario" name='usuario' autofocus>
                                    <div class="invalid-feedback">
                                        Debe tener más de tres caracteres.
                                    </div>
                                </div>
                                <div class="input-group my-2">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control" placeholder="contraseña" id='password1' name='password1'>
                                    <div class="invalid-feedback">
                                        Deben tener más de 5 caracteres o ser iguales.
                                    </div>
                                </div>
                                <div class="input-group my-2">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control"  placeholder="Repita la contraseña" id='password2' name='password2'>
                                    <div class="invalid-feedback">
                                        Deben tener más de 5 caracteres o ser iguales.
                                    </div>
                                </div>
                                <div class="input-group my-2">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" placeholder="e-Mail" name='email' id='email'>
                                    <div class="invalid-feedback">
                                        La dirección de email NO es válida.
                                    </div>
                                </div>
                                <div class="text-end">
                                    <input type="submit" value="Registrar" class="btn btn-info" name='enviar'>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="validar.js"></script>
    </body>
</html>