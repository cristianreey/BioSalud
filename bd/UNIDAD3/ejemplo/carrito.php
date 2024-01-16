<?php
// carrito.php
include('funciones.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'];

    // Agregar el producto al carrito en la sesión
    $_SESSION['carrito'][] = obtenerProductoDesdeBaseDeDatosPorId($producto_id);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
</head>

<body>
    <h1>Carrito de Compras</h1>

    <?php
    // Mostrar los productos en el carrito
    if (!empty($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $producto) {
            echo '<div>';
            echo '<h3>' . $producto['nombre'] . '</h3>';
            echo '<p>Precio: $' . $producto['precio'] . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>El carrito de compras está vacío.</p>';
    }
    ?>
</body>

</html>