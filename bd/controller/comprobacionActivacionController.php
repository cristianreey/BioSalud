<?php
namespace controller;

use bd\model\Cliente;

require_once("../model/cliente.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['codigoActivacion'])) {
        $codigoActivacion = $_POST['codigoActivacion'];

        // Verificar el código de activación
        $resultado = Cliente::compararCodigoVerificacion($codigoActivacion);

        // Manejar el resultado según corresponda
        if ($resultado === true) {
            // Redirigir al usuario a la página de inicio
            header("Location: ../view/Tienda.php");
            exit;
        } else {
            // El código de activación no es válido, redirigir a una página de error o mostrar un mensaje
            header("Location: ../view/PaginaErrorActivacion.php");
            exit;
        }
    } else {
        // Si no se recibió el código de activación, redirigir a una página de error o mostrar un mensaje
        header("Location: ../view/codigoActivacion.php");
        exit;
    }
}
?>