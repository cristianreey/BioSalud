<?php
session_start();

use bd\model\Cliente;
use bd\model\Farmacia;

require_once("../model/conexion.php"); // Suponiendo que tienes un archivo de conexión a la base de datos
require_once("../model/cliente.php"); // Suponiendo que tienes un archivo que contiene la definición de la clase Cliente y la función updateCliente

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $fechaNac = $_POST['fechaNac'];
    $DNI = $_POST['DNI'];
    $emailUsuario = $_SESSION['usuario'];

    $pdo = Farmacia::conectar();


    // Crear un objeto Cliente con los datos recibidos
    $cliente = array(
        'nombre' => $nombre,
        'telefono' => $telefono,
        'fechaNac' => $fechaNac,
        'DNI' => $DNI,
        'gmail' => $emailUsuario
    );

    // Actualizar el cliente en la base de datos
    $actualizado = Cliente::updateCliente($pdo, $cliente);

    if ($actualizado) {
        // Si la actualización fue exitosa, redirigir al usuario a alguna página de confirmación o a la página de perfil actualizada
        header("Location: ../view/perfil_actualizado.php");
        exit();
    } else {
        // Si hubo un error en la actualización, mostrar un mensaje de error o redirigir a una página de error
        header("Location: ../view/error.php");
        exit();
    }
}
?>