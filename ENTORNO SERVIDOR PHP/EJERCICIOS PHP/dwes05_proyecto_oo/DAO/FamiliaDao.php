<?php

class FamiliaDao {

    private $bd;

    function __construct($bd) {
        $this->bd = $bd;
    }

    function crea($familia) {
        
    }

    function modifica($familia) {
        
    }

    function elimina($id) {
        
    }

    function recuperaPorId($id) {
        
    }

    function recuperaTodo() {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from familias order by nombre";
        $sth = $this->bd->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Familia::class);
        $familias = $sth->fetchAll();
        return $familias;
    }

}
