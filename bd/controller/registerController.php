<?php
namespace controller;

use bd\model\Cliente;

require_once("../model/cliente.php");


// Comprobamos si la sesión ya está iniciada antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Procesar datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['gmail'];
    $password = $_POST['contrasena'];
    $fechaNacimiento = $_POST['fechaNac'];
    $dni = $_POST['DNI'];
    $telefono = $_POST['telefono'];

    // Utilizar la clase Cliente para registrar al cliente
    $mensaje = Cliente::registrarCliente($nombre, $email, $password, $fechaNacimiento, $dni, $telefono);

    echo $mensaje;
}

?>