<?php

require '../vendor/autoload.php';
use Clases\Operaciones;

$uri = 'http://localhost/dwes06_server/servidorSoap';
$parametros = ['uri' => $uri];
try {
    $server = new SoapServer("http://localhost/dwes06_server/servidorSoap/servicio2.wsdl");
    $server->setClass(Operaciones::class);
    $server->handle();
} catch (SoapFault $f) {
    die("error en server: " . $f->getMessage());
}

