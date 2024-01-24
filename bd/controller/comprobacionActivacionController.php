<?php
namespace controller;

use bd\model\Cliente;

require_once("../model/cliente.php");


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoActivacion = $_POST['codigoActivacion'];
    $email = $_SESSION['email'];

    // Verificar el código de activación
    $codigoCorrecto = Cliente::verificarCodigoActivacion($codigoActivacion, $email);

    if ($codigoCorrecto) {
        // Actualizar el estado del usuario a activo en la base de datos
        Cliente::activarCuentaCliente($email);

        // Redirigir al usuario a la página principal
        header("Location: ../view/Tienda.php");
        exit();
    } else {
        // Código incorrecto, muestra un mensaje de error y permite al usuario intentar nuevamente
        echo "Código incorrecto. Por favor, inténtelo nuevamente.";
    }
}
?>