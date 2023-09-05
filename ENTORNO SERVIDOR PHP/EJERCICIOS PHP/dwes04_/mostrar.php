<?php
session_start();

// Se pueden establecer las opciones en otro fichero e incluirlo 
$idiomas = ['Español', 'Inglés'];
$perfiles = ['Si', 'No'];
$zonas = ['GMT-2', 'GMT-1', 'GMT', 'GMT+1', 'GMT+2'];

if (isset($_POST['borrar'])) {
    $errorBorrar = empty($_SESSION);
    session_unset();
}

$midioma = isset($_SESSION['idioma']) ? $idiomas[$_SESSION['idioma']] : null;
$miperfil = isset($_SESSION['perfil']) ? $perfiles[$_SESSION['perfil']] : null;
$mizona = isset($_SESSION['zona']) ? $zonas[$_SESSION['zona']] : null;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- css para usar Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- css Fontawesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" 
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" 
              crossorigin="anonymous">
        <title>Tarea Unidad 4</title>
    </head>
    <body style="background: gray">
        <div class="container mt-4">
            <div class="card text-white bg-success mb-3 m-auto" style="width:35rem">
                <div class="card-body">
                    <h3 class="card-title">
                        <i class="fas fa-user-cog mr-2">Preferencias</i>
                    </h3>
                    <?php if (isset($errorBorrar)): ?>
                        <p class='card-text text-danger font-weight-bold' style='font-size: 1.1em'>
                            <?= ($errorBorrar) ? "Debes fijar primero las preferencias" : "Preferencias Borradas" ?></p>
                    <?php endif ?>
                    <p class="card-text" style="font-size: 1.1em">
                        <span class="font-weight-bold">Idioma: </span>
                        <?= $midioma ?? "No establecido" ?>
                    </p>
                    <p class="card-text" style="font-size: 1.1em">
                        <span class="font-weight-bold">Perfil Público: </span>
                        <?= $miperfil ?? "No establecido" ?>
                    </p>
                    <p class="card-text" style="font-size: 1.1em">
                        <span class="font-weight-bold">Zona Horaria: </span>
                        <?= $mizona ?? "No establecido" ?></p>
                    <form class="form-inline" action="<?= $_SERVER['PHP_SELF'] ?>" method='POST' >
                        <a href="index.php" class="btn btn-primary mr-2" style="font-size: 1.1em">Establecer</a>
                        <input type="submit" class="btn btn-danger" value="Borrar"
                               name="borrar" style="font-size: 1.1em">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>