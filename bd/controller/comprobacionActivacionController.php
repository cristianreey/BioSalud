<?php
namespace controller;

use bd\model\Carrito;
use bd\model\Producto;
use bd\model\Farmacia;

require_once("../model/conexion.php");
require_once("../model/producto.php");
require_once("../model/carrito.php");
require_once("../model/cliente.php");


// Comprobamos si la sesión ya está iniciada antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Comprobamos si la sesión ya está iniciada antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Después de registrar al usuario
$estadoUsuario = Cliente::verificarEstadoCliente($email);

if ($estadoUsuario === true) {
    echo "El usuario está activo.";
    // Aquí puedes redirigir al usuario a la página deseada
} elseif ($estadoUsuario === false) {
    echo "El usuario no está activo. Se requiere activación.";
    // Redirigir al usuario a otra página
    header("Location: ../view/codigoActivacion.php");
    exit(); // Asegúrate de salir después de la redirección para evitar ejecución adicional de código
} else {
    echo "Error: " . $estadoUsuario;
}

?>