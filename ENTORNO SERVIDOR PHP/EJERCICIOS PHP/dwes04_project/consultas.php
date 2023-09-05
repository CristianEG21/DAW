<?php

function recuperarProducto($bd, $id) {
    $consultaProducto = 'select * from productos where id=:i';
    $stmtConsultaProducto = $bd->prepare($consultaProducto);
    $stmtConsultaProducto->execute([':i' => $id]);
    $producto = $stmtConsultaProducto->fetch(PDO::FETCH_OBJ);
    $stmtConsultaProducto = null;
    return $producto;
}

function recuperarProductos($bd) {
    $consultaProductos = 'select id, nombre, pvp from productos order by nombre';
    $stmtConsultaProductos = $bd->prepare($consultaProductos);
    $stmtConsultaProductos->execute();
    $productos = $stmtConsultaProductos->fetchAll(PDO::FETCH_OBJ);
    $stmtConsultaProductos = null;
    return $productos;
}

function autenticarUsuario($bd, $nombre, $pass) {
    $pass1 = hash('sha256', $pass);
    $consultaUsuario = 'select * from usuarios where usuario=:u AND pass=:p';
    $stmtConsultaUsuario = $bd->prepare($consultaUsuario);
       $stmtConsultaUsuario->execute([
            ':u' => $nombre,
            ':p' => $pass1,
        ]);
        return !(0 === $stmtConsultaUsuario->rowCount());
        $stmtConsultaUsuario = null;
}
