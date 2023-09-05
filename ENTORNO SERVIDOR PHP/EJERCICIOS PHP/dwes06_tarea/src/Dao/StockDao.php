<?php

namespace App\Dao;

use PDO;
use App\Modelo\Stock;
use App\Dao\{ProductoDao,
    TiendaDao
};

class StockDao {

    private $bd;

    function __construct($bd) {
        $this->bd = $bd;
        $this->productoDao = new ProductoDao($bd);
        $this->TiendaDao = new TiendaDao($bd);
    }

    function crea($familia) {
        
    }

    function modifica($familia) {
        
    }

    function elimina($id) {
        
    }

    function recuperaPorId(int $id): ?Tienda {
        
    }

    function recuperaPorProductoIdTiendaId(int $prodId, int $tiendaId) {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from stocks where producto = :prod_id and tienda = :tienda_id";
        $sth = $this->bd->prepare($sql);
        $sth->execute([':prod_id' => $prodId, ':tienda_id' => $tiendaId]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Stock::class);
        $stock = ($sth->fetch()) ?: null;
        return $stock;
    }

    function recuperaTodo() {
        
    }

}
