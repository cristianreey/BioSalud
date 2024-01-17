<?php
// carrito.php
include('funciones.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $GUID = $_POST['GUID'];

    // Agregar el producto al carrito en la sesión
    $_SESSION['carrito'][] = obtenerProductoDesdeBaseDeDatosPorId($GUID);
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


        $productos = $_SESSION['carrito'];
        for ($i = 0; $i < count($productos); $i++) {
            var_dump($productos[$i]);
            echo '<img class="w-50" alt=""  src="' . $productos[$i]['url'] . '">';
            echo '<div>';
            echo '<h3>' . $productos[$i]['nombre'] . '</h3>';
            echo '<p>Precio: $' . $productos[$i]['precio'] . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>El carrito de compras está vacío.</p>';
    }
    ?>
</body>

</html>