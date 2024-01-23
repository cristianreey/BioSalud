<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>BioSalud</title>
</head>

<body>

    <header>
        <nav class="section1">
            <div class="logo">
                <img src="../IMAGEN/HatchfulExport-All/logo_transparent.png" alt="Logo de Farmacia TuSalud" />
            </div>
            <div class="barra-busqueda">
                <input type="text" placeholder="Buscar productos..." />
            </div>
            <div class="usuario">
                <a href="#"><span class="material-icons">account_circle</span></a>
                <a href="#"><span class="material-icons">shopping_bag</span></a>
            </div>
        </nav>
    </header>

    <main class="contenedor">
        <?php
        include('..\controller\MainController.php');
        include('..\controller\VerProductoIdController.php');

        echo '<h2>CARRITO</h2>';
        echo '<div class="contenedorProductos">';

        // Iterar sobre los resultados obtenidos
        foreach ($datosProductoId as $producto) {
            echo '<div class="productos">';
            echo '<img class="w-50" src="' . $producto['url'] . '">';
            echo '<h3>' . $producto['nombre'] . '</h3>';
            echo '<p>Cantidad: ' . $producto['cantidad'] . '</p>';
            echo '<p>Precio: ' . $producto['precio'] . '€</p>';
            echo '</div>';
        }

        echo "<form action='../controller/EliminarCarritoController.php' method='POST' class='formulario'>\n";
        echo "<button type='submit'>Vaciar</button>";
        echo "</form>";
        echo '</div>';
        echo '</div>';
        ?>


    </main>

</body>

</html>