<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Farmacia</title>
</head>

<body>
    <h1>Bienvenido a la Tienda de Farmacia</h1>

    <!-- Barra de búsqueda -->
    <form action="buscar.php" method="post">
        <label for="search">Buscar producto:</label>
        <input type="text" id="search" name="search" required>
        <button type="submit">Buscar</button>
    </form>

    <!-- Lista de productos -->
    <h2>Productos Disponibles</h2>
    <?php
    include('funciones.php');

    // Aquí deberías recuperar y mostrar la lista de productos desde tu base de datos
    $productos = obtenerProductosDesdeBaseDeDatos();

    for ($i = 0; $i < count($productos); $i++)
        foreach ($productos[$i] as $producto) {
            echo '<div>';
            echo '<h3>' . $producto['nombre'] . '</h3>';
            echo '<p>Precio: $' . $producto['precio'] . '</p>';
            echo '<form action="carrito.php" method="post">';
            echo '<input type="hidden" name="producto_id" value="' . $producto['id'] . '">';
            echo '<button type="submit">Agregar al carrito</button>';
            echo '</form>';
            echo '</div>';
        }
    ?>
</body>

</html>