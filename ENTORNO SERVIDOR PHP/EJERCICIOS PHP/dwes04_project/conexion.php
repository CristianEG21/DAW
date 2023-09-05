<?php

$host = 'localhost';
$db = 'proyecto';
$user = 'gestor';
$pass = 'secreto';

function conectar($host, $db, $user, $pass) {
    $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";
    $conProyecto = new PDO($dsn, $user, $pass);
    $conProyecto->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return ($conProyecto);
}

return conectar($host, $db, $user, $pass);
