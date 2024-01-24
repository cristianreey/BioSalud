<?php
namespace controller;

use bd\model\Carrito;
use bd\model\Producto;
use bd\model\Farmacia;

require_once("../model/conexion.php");
require_once("../model/producto.php");
require_once("../model/carrito.php");

// Comprobamos si la sesión ya está iniciada antes de intentar iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$pdo = Farmacia::conectar();

// Procesar datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['gmail'];
    $password = $_POST['contrasena'];
    $fechaNacimiento = $_POST['fechaNac'];
    $dni = $_POST['DNI'];
    $telefono = $_POST['telefono'];

    var_dump($nombre);
    // Validar los datos (realiza validaciones más robustas según tus necesidades)
    if (empty($nombre) || empty($email) || empty($password) || empty($fechaNacimiento) || empty($dni) || empty($telefono)) {
        echo "Por favor, complete todos los campos.";
    } else {
        // Hash de la contraseña (mejora la seguridad almacenando contraseñas de manera segura)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar datos en la base de datos (ajusta la consulta según tu esquema)
        $sql = "INSERT INTO clientes (nombre, gmail, contrasena, DNI, fechaNac, telefono) VALUES ('$nombre', '$email', '$hashedPassword', '$dni', '$fechaNacimiento', $telefono')";

        if ($pdo->query($sql) === TRUE) {
            echo "Registro exitoso";
        } else {
            echo "Error al registrar: " . $pdo->error;
        }
    }
}

// Cerrar la conexión a la base de datos
$pdo->close();
?>