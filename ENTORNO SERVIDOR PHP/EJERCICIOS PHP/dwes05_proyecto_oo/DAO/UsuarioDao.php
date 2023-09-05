<?php

class UsuarioDao {

    private $bd;

    function __construct($bd) {
        $this->bd = $bd;
    }

    function crea($usuario) {
        
    }

    function modifica($usuario) {
        
    }

    function elimina($nombre) {
        
    }

    function recuperaPorCredencial($nombre, $pwd) {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $pwdHashed = hash('sha256', $pwd);
        $sql = 'select * from usuarios where usuario=:nombre and pass=:pwdHashed';
        $sth = $this->bd->prepare($sql);
        $sth->execute([":nombre" => $nombre, ":pwdHashed" => $pwdHashed]);
        $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Usuario::class);
        $usuario = ($sth->fetch()) ?: null;
        return $usuario;
    }

}
