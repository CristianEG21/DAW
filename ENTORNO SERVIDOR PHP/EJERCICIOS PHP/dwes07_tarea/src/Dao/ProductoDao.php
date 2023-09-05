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
        $sql = "insert into productos (nombre, nombre_corto, descripcion, pvp, familia) values (:nombre, :nombre_corto, :descripcion, :pvp, :familia)";
        $sth = $this->bd->prepare($sql);
        $result = $sth->execute([":nombre" => $producto->getNombre(), ":nombre_corto" => $producto->getNombreCorto(), ":descripcion" => $producto->getDescripcion(), ":pvp" => $producto->getPvp(), ":familia" => $producto->getFamilia()]);
        if ($result) {
            $result = (int) $this->bd->lastInsertId();
        }

        return ($result);
    }

    function modifica($producto) {
        $sql = "update productos set nombre = :nombre, nombre_corto = :nombre_corto, descripcion = :descripcion, pvp = :pvp, familia = :familia where id = :id";
        $sth = $this->bd->prepare($sql);
        $result = $sth->execute([":nombre" => $producto->getNombre(), ":nombre_corto" => $producto->getNombreCorto(), ":descripcion" => $producto->getDescripcion(), ":pvp" => $producto->getPvp(), ":familia" => $producto->getFamilia(), ":id" => $producto->getId()]);
        return ($result);
    }

    function elimina($id) {
        $sql = "delete from productos where id = :id";
        $sth = $this->bd->prepare($sql);
        $result = $sth->execute([":id" => $id]);
        return $result;
    }

    function recuperaTodo() {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from productos order by nombre";
        $sth = $this->bd->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, Producto::class);
        $productos = $sth->fetchAll();
        foreach ($productos as $producto) {
            $sqlVotos = "select count(*) as total from votos where idPr=:idproducto";
            $sthVotos = $this->bd->prepare($sqlVotos);
            $sthVotos->execute([':idproducto' => $producto->getId()]);
            $votos = ($sthVotos->fetch(PDO::FETCH_OBJ))->total;
            $producto->setVotos($votos);
            $sqlPuntos = "select IFNULL(sum(cantidad),0) as total from votos where idPr=:idproducto";
            $sthPuntos = $this->bd->prepare($sqlPuntos);
            $sthPuntos->execute([':idproducto' => $producto->getId()]);
            $puntos = ($sthPuntos->fetch(PDO::FETCH_OBJ))->total;
            $producto->setPuntos($puntos);
        }
        return $productos;
    }

    function recuperaProductoPorId(int $id): ?Producto {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from productos where id = :id";
        $sth = $this->bd->prepare($sql);
        $sth->execute([':id' => $id]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Producto::class);
        $producto = ($sth->fetch()) ?: null;
        $sqlVotos = "select count(*) as total from votos where idPr=:idproducto";
        $sthVotos = $this->bd->prepare($sqlVotos);
        $sthVotos->execute([':idproducto' => $id]);
        $votos = ($sthVotos->fetch(PDO::FETCH_OBJ))->total;
        $producto->setVotos($votos);
        $sqlPuntos = "select IFNULL(sum(cantidad),0) as total from votos where idPr=:idproducto";
        $sthPuntos = $this->bd->prepare($sqlPuntos);
        $sthPuntos->execute([':idproducto' => $id]);
        $puntos = ($sthPuntos->fetch(PDO::FETCH_OBJ))->total;
        $producto->setPuntos($puntos);
        return $producto;
    }

}
