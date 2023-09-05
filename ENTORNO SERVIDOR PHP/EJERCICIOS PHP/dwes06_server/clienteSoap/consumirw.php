<?php
$url = "http://localhost/dwes06_server/servidorSoap/servicio.wsdl";
$paramSaludo = ['texto' => "Manolo"];
$param = ['a' => 51, 'b' => 29];
try {
    $cliente = new SoapClient($url);
} catch (SoapFault $ex) {
    echo "Error: ".$ex->getMessage();
}
$saludo = $cliente->__soapCall('saludo', $paramSaludo);
//También podríamos hacer
// $saludo=$cliente->saludo("Manolo");
$suma = $cliente->__soapCall('suma', $param);
$resta=$cliente->__soapCall('resta', $param);
echo $saludo. " La suma es: $suma y la resta es: $resta";
