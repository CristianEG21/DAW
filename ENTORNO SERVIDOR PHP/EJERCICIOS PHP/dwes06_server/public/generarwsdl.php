<?php
require '../vendor/autoload.php';

use PHP2WSDL\PHPClass2WSDL;
use Clases\Operaciones;

$class = "Operaciones";
$uri = 'http://localhost/dwes06_server/servidorSoap/servidorw.php';
$wsdlGenerator = new PHPClass2WSDL(Operaciones::class, $uri);
$wsdlGenerator->generateWSDL(true);
$fichero = $wsdlGenerator->save('../servidorSoap/servicio.wsdl');