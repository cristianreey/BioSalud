<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>BioSalud</title>

    <link rel="stylesheet" href="../CSS/style.css" />

    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">



    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />

</head>

<body>

    <header>
        <section class="section1">
            <div class="logo">
                <img src="../IMAGEN/HatchfulExport-All/logo_transparent.png" alt="Logo de Farmacia TuSalud" />
            </div>
            <div class="barra-busqueda">
                <input type="text" placeholder="Buscar productos..." />
            </div>
            <div class="usuario">
                <a href="#"><span class="material-icons">account_circle</span></a>
                <a href="carrito.html"><span class="material-icons">shopping_bag</span></a>
            </div>
        </section>
        <section class="section2">
            <?php
            $categorias = array(
                0 => "INICIO",
                1 => "BEBÉ Y MAMÁ",
                2 => "HINGIENE BUCAL",
                3 => "SALUD SEXUAL",
                4 => "DERMOCOSMÉTICA"
            );

            // Asegurar que $idCategoriaSeleccionada esté definida antes de usarla
            $idCategoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : 0;

            foreach ($categorias as $id => $nombreCategoria) {
                $enlace = "Tienda.php?categoria=$id";
                $clase = ($id == $idCategoriaSeleccionada) ? 'categoria-actual' : '';
                echo "<a href=\"$enlace\" class=\"$clase\"><span>$nombreCategoria</span></a>";
            }

            ?>

        </section>
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