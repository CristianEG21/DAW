<?php

namespace App\Modelo;

class Producto {

    private $id;
    private $nombre;
    private $nombreCorto;
    private $pvp;
    private $familia;
    private $descripcion;

    public function __construct(string $nombre = null, string $nombreCorto = null, string $descripcion = null, float $pvp = null, string $familia = null) {
        $this->nombre = $nombre;
        $this->nombreCorto = $nombreCorto;
        $this->descripcion = $descripcion;
        $this->pvp = $pvp;
        $this->familia = $familia;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNombreCorto() {
        return $this->nombre_corto;
    }

    public function getPvp() {
        return $this->pvp;
    }

    public function getFamilia() {
        return $this->familia;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setNombreCorto($nombreCorto): void {
        $this->nombreCorto = $nombreCorto;
    }

    public function setPvp($pvp): void {
        $this->pvp = $pvp;
    }

    public function setFamilia($familia): void {
        $this->familia = $familia;
    }

    public function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

}
