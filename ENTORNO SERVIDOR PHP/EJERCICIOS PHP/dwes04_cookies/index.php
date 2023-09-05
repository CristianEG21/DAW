<?php
// Si el usuario no se ha autentificado, pedimos las credenciales
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header("WWW-Authenticate: Basic realm='Contenido restringido'");
    header("HTTP/1.0 401 Unauthorized");
    die();
}
//Conexión a la base de datos proyecto.
$host = "localhost";
$db = "proyecto";
$user = "gestor";
$pass = "secreto";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$conProyecto = new PDO($dsn, $user, $pass);
$conProyecto->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Hacemos la consulta
$consulta = "select * from usuarios where usuario=:u and pass=:p";
$stmt = $conProyecto->prepare($consulta);
$stmt->execute([
    ':u' => $_SERVER['PHP_AUTH_USER'],
    ':p' => hash('sha256', $_SERVER['PHP_AUTH_PW'])
]);

// Si la Consulta No devuelve ninguna fila las credenciales son erroneas.
if ($stmt->rowCount() == 0) {
    header("WWW-Authenticate: Basic realm='Contenido restringido'");
    header("HTTP/1.0 401 Unauthorized");
    $stmt = null;
    $conProyecto = null;
    die();
}
$stmt = null;
$conProyecto = null;
//Para poner el formato fecha en castellano y recuperar fecha y hora de acceso
setlocale(LC_ALL, 'es-ES.UTF-8');
$ahora = new DateTime('now', new DateTimeZone('Europe/Madrid'));
// si existe la cookie recupero su valor
if (isset($_COOKIE[$_SERVER['PHP_AUTH_USER']])) {
    $timestamp = $_COOKIE[$_SERVER['PHP_AUTH_USER']];
    $mensaje = strftime("Tu última visita fué el %A, %d de %B de %Y a las %H:%M:%S",
        $timestamp);
} //si no existe es la primera visita para este usuario
else {
    $mensaje = "Es la primera vez que visitas la página.";
}
//Creo o actualizo la cookie con la nueva fecha de acceso, la cookie durara una semana
setcookie($_SERVER['PHP_AUTH_USER'], $ahora->format('U'), $ahora->format('U') + 7 * 24 * 60 * 60);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CDN de Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <title>Cookies </title>
    </head>
    <body class="bg-info">
        <p class="float-left m-3">
            <?= $mensaje; ?>
        </p>
        <br><br>
        <h4 class="mt-3 text-center font-weight-bold">Ejercicio Apartado 2 Unidad 4 </h4>
        <div class='container mt-3'>
            <div class='row'>
                <div class='col-md-4 font-weight-bold'>
                    Nombre Usuario:
                </div>
                <div class='col-md-4'>
                    <?= $_SERVER['PHP_AUTH_USER']; ?>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-4 font-weight-bold'>
                    Password Usuario (sha256):
                </div>
                <div class='col-md-4'>
                    <?= hash('sha256', $_SERVER['PHP_AUTH_PW']); ?>
                </div>
            </div>
        </div>
    </body>
</html>