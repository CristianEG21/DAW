<?php
session_start();

// Se pueden establecer las opciones en otro fichero e incluirlo aquí

$idiomas = ['Español', 'Inglés'];
$perfiles = ['Si', 'No'];
$zonas = ['GMT-2', 'GMT-1', 'GMT', 'GMT+1', 'GMT+2'];
// Si hemos enviado las preferencias la guardamos en sesiones.
if (isset($_POST['enviar'])) {
    $idioma = filter_input(INPUT_POST, 'idioma');
    if (strlen($idioma) > 0) {
        $_SESSION['idioma'] = $idioma;
    }
    $perfil = filter_input(INPUT_POST, 'perfil');
    if (strlen($perfil) > 0) {
        $_SESSION['perfil'] = $perfil;
    }
    $zona = filter_input(INPUT_POST, 'zona');
    if (strlen($zona) > 0) {
        $_SESSION['zona'] = $zona;
    }
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
        <!-- css Fontawesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" 
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" 
              crossorigin="anonymous">
        <title>Tarea Unidad 4</title>
    </head>
    <body style="background:silver;">

        <div class="container mt-5">
            <div class="d-flex justify-content-center h-100">
                <div class="card" style="width: 30rem">
                    <div class="card-header">
                        <h3>Preferencias Usuario </h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_POST['enviar'])): ?>
                            <p class='card-text textprimary'>Preferencias de usuario guardadas.</p>
                        <?php endif ?>
                        <form name='preferencias' method='POST' action='<?= $_SERVER['PHP_SELF'] ?>'>
                            <label class="" for="idioma">Idioma </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-language"></i></span>
                                <select class="form-control" name='idioma' id="idioma">
                                    <?php if (!isset($_SESSION['idioma'])): ?>
                                        <option selected ></option>
                                    <?php endif ?>
                                    <?php foreach ($idiomas as $index => $idioma): ?>
                                        <option value='<?= $index ?>' <?= (isset($_SESSION['idioma']) && $_SESSION['idioma'] == $index) ? "selected" : "" ?> >
                                            <?= $idioma ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <label class="" for="perfil">Perfil Público </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"> </i> </span>          
                                <select class="form-control" name='perfil' id="perfil">
                                    <?php if (!isset($_SESSION['perfil'])): ?>
                                        <option selected ></option>
                                    <?php endif ?>
                                    <?php foreach ($perfiles as $index => $perfil): ?>
                                        <option value='<?= $index ?>' <?= (isset($_SESSION['perfil']) && $_SESSION['perfil'] == $index) ? "selected" : "" ?> >
                                            <?= $perfil ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <label class="" for="zona-horaria">Zona Horaria </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-clock"> </i> </span>
                                <select class="form-control" name='zona' id="zona-horaria">
                                    <?php if (!isset($_SESSION['zona'])): ?>
                                        <option selected ></option>
                                    <?php endif ?>
                                    <?php foreach ($zonas as $index => $zona): ?>
                                        <option value='<?= $index ?>' <?= (isset($_SESSION['zona']) && $_SESSION['zona'] == $index) ? "selected" : "" ?> >
                                            <?= $zona ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <a href="mostrar.php" class="btn btn-primary">Mostrar Preferencias</a>
                                <input type="submit" value="Establecer Preferencias" class="btn float-right btn-success" name='enviar'>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>