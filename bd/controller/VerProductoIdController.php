<?php

namespace controller;

use bd\model\Producto;
use bd\model\Farmacia;

require_once("../model/conexion.php");
require_once("../model/producto.php");

// Comprobamos si la sesión ya está iniciada antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Si la sesión está iniciada y hay usuario, redirigimos a la web principal
// De lo contrario, redireccionamos al login
if (isset($_SESSION['user'])) {
    // Obtener el usuario de la sesión
    $user = $_SESSION['user'];

    // Nos conectamos a BD
    $pdo = Farmacia::conectar();

    // Cargamos los datos de los productos
    $datosProductoId = Producto::obtenerProductoCarrito($pdo);
} else {
    // Si no hay usuario, redireccionamos al login
    header("Location: ../view/login.php");
    exit();
}