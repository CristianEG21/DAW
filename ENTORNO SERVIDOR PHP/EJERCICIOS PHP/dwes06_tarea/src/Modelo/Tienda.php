<?php
namespace App\Modelo;

use PDO;

class Tienda
{
    private $id;
    private $nombre;
    private $tlf;

    public function __construct(string $nombre = null, string $tlf = null)
    {
        if (!is_null($nombre)) {
            $this->nombre = $nombre;
        }
        if (!is_null($tlf)) {
            $this->tlf = $tlf;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getTlf() {
        return $this->tlf;
    }


    public function setId($id): void {
        $this->id = $id;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setTlf($tlf): void {
        $this->tlf = $tlf;
    }
    
}

