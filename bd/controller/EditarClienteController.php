<?php
session_start();

use bd\model\Cliente;
use bd\model\Farmacia;

require_once("../model/conexion.php");
require_once("../model/cliente.php");

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

        header("Location: ../view/perfil_actualizado.php");
        exit();
    } else {
        header("Location: ../view/error.php");
        exit();
    }
}
?>