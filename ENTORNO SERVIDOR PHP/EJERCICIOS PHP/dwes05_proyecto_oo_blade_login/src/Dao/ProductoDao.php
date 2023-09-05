<?php

namespace App\Dao;

use PDO;
use App\Modelo\Producto;

class ProductoDao {

    private $bd;

    function __construct($bd) {
        $this->bd = $bd;
    }

    function crea($producto) {
        
    }

    function modifica($producto) {
        
    }

    function elimina($id) {
        
    }

    function recuperaPorId($id) {
        
    }

    function recuperaTodo() {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from productos order by nombre";
        $sth = $this->bd->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Producto::class);
        $productos = $sth->fetchAll();
        return $productos;
    }

}
