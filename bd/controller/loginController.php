<?php
namespace controller;

use bd\model\Farmacia;
use bd\model\Cliente;

require_once("../model/cliente.php");

// Verificar inactividad antes de procesar cualquier solicitud
Cliente::verificarInactividad();

// Comprobar si se ha enviado el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['contrasena'];

    // Intentar iniciar sesión con los datos proporcionados
    $mensaje = Cliente::iniciarSesion($email, $password);

    // Verificar si el inicio de sesión fue exitoso
    if (strpos($mensaje, "Inicio de sesión exitoso") !== false) {
        // Iniciar sesión y redirigir al usuario a la página principal
        session_start();
        $_SESSION['usuario'] = $email;
        header("Location: ../view/Tienda.php");
        exit();
    } else {
        // Mostrar un mensaje de error si las credenciales son incorrectas
        echo $mensaje;
    }
}
?>