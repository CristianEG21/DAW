<?php

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

    function recuperaPorId($id) {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from productos where id = :id";
        $sth = $this->bd->prepare($sql);
        $sth->execute([':id' => $id]);
        $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Producto::class);
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

}
