<?php

namespace controller;

use bd\model\Carrito;
use bd\model\Producto;
use bd\model\Farmacia;

require_once("../model/conexion.php");
require_once("../model/producto.php");
require_once("../model/carrito.php");

// Comprobamos si la sesión ya está iniciada antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    // Nos conectamos a BD
    $pdo = Farmacia::conectar();
    // Cargamos los datos de los productos
    $datosProducto = Producto::getProducto($pdo);

    $datosCarrito = Carrito::getCarrito($pdo);
}