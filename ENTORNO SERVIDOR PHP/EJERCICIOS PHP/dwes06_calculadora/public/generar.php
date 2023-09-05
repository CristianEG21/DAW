<?php
//Fichero para generar las clases
require '../vendor/autoload.php';

use Wsdl2PhpGenerator\Generator;
use Wsdl2PhpGenerator\Config;

$generator = new Generator();
$generator->generate(
    new Config([
        'inputFile' => 'http://www.dneonline.com/calculator.asmx?WSDL',
        'outputDir' => '../src',
        'namespaceName' => 'Clases'
    ])
);
