<?php
namespace controller;

use bd\model\Farmacia;

require_once("../model/cliente.php");

// Comprobar si se ha enviado el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['contrasena'];

    // Intentar iniciar sesión con los datos proporcionados
    $usuario = Cliente::iniciarSesion($email, $password);

    // Verificar si el inicio de sesión fue exitoso
    if ($usuario) {
        // Iniciar sesión y redirigir al usuario a la página principal
        session_start();
        $_SESSION['usuario'] = $usuario;
        header("Location: ../view/Tienda.php");
        exit();
    } else {
        // Mostrar un mensaje de error si las credenciales son incorrectas
        echo "Correo electrónico o contraseña incorrectos.";
    }
}
?>