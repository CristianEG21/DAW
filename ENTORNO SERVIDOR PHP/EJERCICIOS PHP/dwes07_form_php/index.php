<?php

// El campo nombre debe tener más de 3 caracteres
function validarNombre($nombre) {
    return !(strlen($nombre) < 4);
}

// El campo correo debe tener el formato adecuado
function validarEmail($email) {
    return preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $email);
}

// Las contraseñas deben de  coincidir
function validarPasswords($pass1, $pass2) {
    return ($pass1 == $pass2) && (strlen($pass1) > 5);
}

if (!empty($_POST)) {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $errorUsuario = !validarNombre($usuario);
    $password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);
    $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
    $errorPassword = !validarPasswords($password1, $password2);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $errorEmail = !validarEmail($email);
    $formError = $errorUsuario || $errorPassword || $errorEmail;
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
            <?php if (isset($_POST['enviar']) && !$formError): ?>
                <div class="alert alert-success" role="alert">
                    Registro realizado con éxito
                </div>
            <?php endif ?>
            <div class="d-flex justify-content-center h-100">
                <div class="card w-50">
                    <div class="card-header">
                        <h3><i class="bi bi-gear p-2"></i>Registro</h3>
                    </div>
                    <div class="card-body">
                        <form name='registro' method='POST' action='<?= $_SERVER['PHP_SELF']; ?>' novalidate>
                            <div class="input-group my-2">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="<?= "form-control " . ((isset($errorUsuario) && $errorUsuario) ? "is-invalid" : ((isset($usuario)) ? "is-valid" : "")) ?>" 
                                       placeholder="usuario" id='usuario' name='usuario' value='<?= $usuario ?? '' ?>'>
                                <div class="invalid-feedback">
                                    Debe tener más de tres caracteres.
                                </div>
                            </div>
                            <div class="input-group my-2">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" class="<?= "form-control " . ((isset($errorPassword) && $errorPassword) ? "is-invalid" : ((isset($password1)) ? "is-valid" : "")) ?>" 
                                       placeholder="contraseña" id='password1' name='password1'>
                            </div>
                            <div class="input-group my-2">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" class="<?= "form-control " . ((isset($errorPassword) && $errorPassword) ? "is-invalid" : ((isset($password2)) ? "is-valid" : "")) ?>"  
                                       placeholder="Repita la contraseña" id='password2' name='password2'>
                                <div class="invalid-feedback">
                                    Deben tener más de 5 caracteres o ser iguales.
                                </div>
                            </div>
                            <div class="input-group my-2">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="<?= "form-control " . ((isset($errorEmail) && $errorEmail) ? "is-invalid" : ((isset($email)) ? "is-valid" : "")) ?>" 
                                       placeholder="e-Mail" name='email' id='email' value='<?= $email ?? '' ?>'>
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
        </div>
    </body>
</html>