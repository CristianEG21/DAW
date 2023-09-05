<?php

namespace App;

require '../vendor/autoload.php';

use App\Modelo\{
    Producto,
    Stock,
    Familia
};
use App\BD\BD;
use App\Dao\{
    ProductoDao,
    FamiliaDao,
    TiendaDao,
    StockDao
};

class Operaciones {

    private $productoDao;
    private $familiaDao;
    private $tiendaDao;
    private $stockDao;

    public function __construct() {
        try {
            $bd = BD::getConexion();
            $this->productoDao = new ProductoDao($bd);
            $this->familiaDao = new FamiliaDao($bd);
            $this->tiendaDao = new TiendaDao($bd);
            $this->stockDao = new StockDao($bd);
        } catch (PDOException $error) {
            die("Error en la conexión con la BD");
        }
    }

    /**
     * Obtiene el PVP de un producto a partir de su codigo
     * @soap
     * @param int $codP
     * @return float
     */
    public function getPvp($codP): ?float {
        $producto = $this->productoDao->recuperaPorId($codP);
        return $producto ? $producto->getPvp() : null;
    }

    /**
     * Devuelve el numero de unidades que existen en una tienda de un producto
     * @soap
     * @param int $codP
     * @param int $codT
     * @return int
     */
    public function getStock($codP, $codT): ?int {
        $stock = $this->stockDao->recuperaPorProductoIdTiendaId($codP, $codT);
        return $stock ? $stock->getUnidades() : null;
    }

    /**
     * Devuelve un array con los codigos de todas las familias
     * @soap
     * @param
     * @return string[]
     */
    public function getFamilias() {
        $familias = $this->familiaDao->recuperaTodo();
        $codFamilias = array_map(fn($familia) => $familia->getCod(), $familias);
        return $codFamilias;
    }

    /**
     * Devuelve un array con los nombres de los productos de una familia
     * @soap
     * @param string $codF
     * @return string[]
     */
    public function getProductosFamilia($codF) {
        $productos = $this->productoDao->recuperaPorFamiliaId($codF);
        $nombresProductos = array_map(fn($producto) => $producto->getNombre(), $productos);
        return $nombresProductos;
    }

}
