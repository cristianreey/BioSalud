<?php
require_once("../controller/verDatosClienteController.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    // Recoge los datos del formulario de edición
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $fechaNac = $_POST['fechaNac'];
    $DNI = $_POST['DNI'];

    // Actualiza los datos en la base de datos
    require_once("../model/conexion.php");

    // Usa consultas preparadas para prevenir inyecciones SQL
    $consulta = $conexion->prepare("UPDATE clientes SET nombre=?, telefono=?, fechaNac=?, DNI=? WHERE gmail=?");

    // Vincula los parámetros
    $consulta->bind_param("sssss", $nombre, $telefono, $fechaNac, $DNI, $_SESSION['usuario']);

    // Ejecuta la consulta
    $consulta->execute();

    // Verifica si la actualización fue exitosa
    if ($consulta->affected_rows > 0) {
        // Actualización exitosa
        $consulta->close();
        $conexion->close();

        // Redirige a la página de perfil después de la edición
        header("Location: ../view/Tienda.php");
        exit();
    } else {
        // Error en la actualización
        $error_message = "Error al actualizar los datos. Por favor, intenta nuevamente.";
    }

    // Cierra la conexión
    $consulta->close();
    $conexion->close();
} else {
    // Manejar otras situaciones o redirigir si es necesario
}
?>