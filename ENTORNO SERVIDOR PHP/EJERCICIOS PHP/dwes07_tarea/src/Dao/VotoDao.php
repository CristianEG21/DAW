<?php

namespace App\Dao;

use PDO;
use App\Modelo\Voto;

class VotoDao {

    private $bd;

    function __construct($bd) {
        $this->bd = $bd;
    }

    function crea($voto) {
        $sql = "insert into votos (cantidad, idPr, idUs) values (:cantidad, :idproducto, :idusuario)";
        $sth = $this->bd->prepare($sql);
        $result = $sth->execute([":cantidad" => $voto->cantidad, ":idproducto" => $voto->idProducto, ":idusuario" => $voto->idUsuario]);
        return ($result);
    }

    function modifica($voto) {
        
    }

    function elimina($id) {
        
    }

    function recuperaPorId($id) {
        
    }

    function existeVoto($voto) {
        $sql = "select * from votos where idPr=:idproducto AND idUs=:idusuario";
        $sth = $this->bd->prepare($sql);
        $sth->execute([':idproducto' => $voto->idProducto, ':idusuario' => $voto->idUsuario]);
        $filas = $sth->rowCount();
        return ($filas !== 0);
    }

}
