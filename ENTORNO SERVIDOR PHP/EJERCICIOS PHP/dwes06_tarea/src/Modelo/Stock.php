<?php

namespace App\Modelo;

use PDO;
use App\{
    Producto,
    Tienda
};

class Stock {

    private $productoId;
    private $tiendaId;
    private $unidades;

    public function __construct(int $productoId = null, int $tiendaId = null, int $unidades = null) {
        if (!is_null($producto)) {
            $this->productoId = $productoId;
        }
        if (!is_null($tienda)) {
            $this->tienda = $tienda;
        }
        if (!is_null($unidades)) {
            $this->unidades = $unidades;
        }
    }

    public function getProducto():Producto {
        return $this->producto;
    }

    public function getTienda():Tienda {
        return $this->tienda;
    }

    public function getUnidades():int {
        return $this->unidades;
    }

    public function setProducto($producto): void {
        $this->producto = $producto;
    }

    public function setTienda($tienda): void {
        $this->tienda = $tienda;
    }

    public function setUnidades($unidades): void {
        $this->unidades = $unidades;
    }


}
