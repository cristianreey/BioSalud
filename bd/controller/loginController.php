<?php
namespace controller;

use bd\model\Cliente;

require_once("../model/cliente.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['contrasena'];

    // Verificar si el usuario está activo
    $usuarioActivo = Cliente::verificarEstadoCliente($email);

    if ($usuarioActivo) {
        // Verificar las credenciales (ejemplo: comparar contraseña)
        $credencialesValidas = Cliente::verificarCredenciales($email, $password);

        if ($credencialesValidas) {
            // Iniciar sesión u otras operaciones necesarias
            $_SESSION['usuario'] = $email;

            // Redirigir al usuario a la página principal
            header("Location: ../view/Tienda.php");
            exit();
        } else {
            // Credenciales inválidas, puedes mostrar un mensaje de error o redirigir a la página de inicio de sesión
            echo "Credenciales inválidas";
        }
    } else {
        // Usuario no activo, redirigir a la página de código de activación
        header("Location: ../view/codigoActivacion.php");
        exit();
    }
}
?>