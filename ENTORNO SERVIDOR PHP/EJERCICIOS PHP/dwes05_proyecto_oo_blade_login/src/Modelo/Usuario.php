<?php
namespace App\Modelo;

class Usuario
{
    private $usuario;
    private $pass;

    public function __construct(string $usuario = null, string $pass = null)
    {
        if (!is_null($usuario)) {
            $this->usuario = $usuario;
        }
        if (!is_null($pass)) {
            $this->pass = $pass;
        }
    }  

    public function getUsuario(): string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario)
    {
        $this->usuario = $usuario;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function setPass(string $pass)
    {
        $this->pass = $pass;
    }

}
