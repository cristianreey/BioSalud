<?php
// buscar.php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $termino_busqueda = $_POST['search'];
    // Realizar la búsqueda en la base de datos y obtener resultados
    $resultados = realizarBusquedaEnBaseDeDatos($termino_busqueda);
} else {
    // Si se accede directamente a esta página sin una búsqueda, redirigir a la página principal
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
</head>
<body>
    <h1>Resultados de Búsqueda</h1>

    <?php
    if (!empty($resultados)) {
        foreach ($resultados as $resultado) {
            echo '<div>';
            echo '<h3>' . $resultado['nombre'] . '</h3>';
            echo '<p>Precio: $' . $resultado['precio'] . '</p>';
            echo '<form action="carrito.php" method="post">';
            echo '<input type="hidden" name="producto_id" value="' . $resultado['id'] . '">';
            echo '<button type="submit">Agregar al carrito</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron resultados.</p>';
    }
    ?>
</body>
</html>
