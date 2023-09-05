<?php

class Familia {

    private $cod;
    private $nombre;

    public function __construct($cod = null, $nombre = null) {
        $this->cod = $cod;
        $this->$nombre = $nombre;
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
