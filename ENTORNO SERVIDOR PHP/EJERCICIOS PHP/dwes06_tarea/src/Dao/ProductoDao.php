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

    public function recuperaPorId(int $id): ?Producto
    {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from productos where id = :id";
        $sth = $this->bd->prepare($sql);
        $sth->execute([':id' => $id]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Producto::class);
        $producto = ($sth->fetch()) ?: null;
        return $producto;
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
    
    public function recuperaPorFamiliaId($famId): array
    {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from productos where familia=:fam_id order by nombre";
        $sth = $this->bd->prepare($sql);
        $sth->execute(([':fam_id' => $famId]));
        $sth->setFetchMode(PDO::FETCH_CLASS, Producto::class);
        $productos = $sth->fetchAll();
        return $productos ?? [];
    }

}
