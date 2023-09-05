<?php

namespace App\Dao;

use PDO;
use App\Modelo\Tienda;

class TiendaDao {

    private $bd;

    function __construct($bd) {
        $this->bd = $bd;
    }

    function crea($familia) {
        
    }

    function modifica($familia) {
        
    }

    function elimina($id) {
        
    }

    public static function recuperaPorId(PDO $bd, int $id): ?Tienda {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from tiendas where id = :id";
        $sth = $this->bd->prepare($sql);
        $sth->execute([':id' => $id]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Tienda::class);
        $tienda = ($sth->fetch()) ?: null;
        return $tienda;
    }

    function recuperaTodo() {
        
    }

}
