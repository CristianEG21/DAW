<?php

require '../vendor/autoload.php';
use Clases\Operaciones;

$uri = 'http://localhost/dwes06_server/servidorSoap';
$parametros = ['uri' => $uri];
try {
    $server = new SoapServer(NULL, $parametros);
    $server->setClass(Operaciones::class);
    $server->handle();
} catch (SoapFault $f) {
    die("error en server: " . $f->getMessage());
}

