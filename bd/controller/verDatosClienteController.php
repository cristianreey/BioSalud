<?php

namespace controller;

use bd\model\Cliente;
use bd\model\Farmacia;

require_once("../model/conexion.php");
require_once("../model/cliente.php");

// Comprobamos si la sesión ya está iniciada antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    // Obtener el usuario de la sesión
    $user = $_SESSION['user'];

    // Nos conectamos a BD
    $pdo = Farmacia::conectar();

    // Cargamos los datos de los productos
    $datosCliente = Cliente::getDatosCliente($pdo);
} else {
    exit();
}