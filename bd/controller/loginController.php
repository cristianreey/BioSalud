<?php
namespace controller;

use bd\model\Cliente;

require_once("../model/cliente.php");


// Comprueba si se ha enviado el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['contrasena'];

    // Si el inicio de sesión es exitoso, configura la sesión y redirige al usuario
    if (Cliente::iniciarSesion($email, $password)) {
        // Inicia sesión y redirige al usuario a la página principal
        $_SESSION['usuario'] = $email;
        header("Location: ../view/Tienda.php");
        exit();
    } else {
        // Si el inicio de sesión falla mostramos un mensaje de error
        echo "Credenciales incorrectas. Por favor, inténtelo de nuevo.";
    }
} else {
    exit();
}