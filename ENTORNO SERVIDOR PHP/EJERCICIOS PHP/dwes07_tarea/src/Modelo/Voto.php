<?php

namespace App\Modelo;

use PDO;

class Voto {

    public $cantidad;
    public $idProducto;
    public $idUsuario;

    public function __construct(int $cantidad = null, int $idProducto = null, string $idUsuario = null) {
        if (!is_null($cantidad)) {
            $this->cantidad = $cantidad;
        }
        if (!is_null($idProducto)) {
            $this->idProducto = $idProducto;
        }
        if (!is_null($idUsuario)) {
            $this->idUsuario = $idUsuario;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getIdProducto() {
        return $this->idProducto;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setCantidad($cantidad): void {
        $this->cantidad = $cantidad;
    }

    public function setIdProducto($idProducto): void {
        $this->idProducto = $idProducto;
    }

    public function setIdUsuario($idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

}
