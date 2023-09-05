<?php
namespace App\Modelo;

use PDO;

class Familia {

    private $cod;
    private $nombre;

    public function __construct($cod = null, $nombre = null) {
        if (!is_null($cod)) {
            $this->cod = $cod;
        }
        if (!is_null($nombre)) {
            $this->$nombre = $nombre;
        }
    }

    public function getCod() {
        return $this->cod;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setCod($cod): void {
        $this->cod = $cod;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

}
