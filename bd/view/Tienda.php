<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
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
        include('../controller/MainController.php');

        $dni = 12345;
        $fechaActual = date("Y-m-d");

        echo '<h2>PRODUCTOS DISPONIBLES</h2>';
        echo '<div class="contenedorProductos">';

        foreach ($datosProducto as $producto) {
            echo '<div class="productos">';
            echo '<img class="w-50" src="' . $producto['url'] . '">';
            echo '<h3>' . $producto['nombre'] . '</h3>';
            echo '<p>Precio: ' . $producto['precio'] . '€</p>';
            echo "<form action='../controller/InsertarCarritoController.php' method='POST' class='formulario'>\n";
            echo '<select name="cantidad" id="cantidad">';
            for ($j = 1; $j <= 20; $j++) {
                echo "<option value=\"$j\">$j</option>";
            }
            echo '</select>';
            echo "<input type='hidden' name='fecha' value='$fechaActual'>";
            echo "<input type='hidden' name='GUID' value='" . $producto['GUID'] . "'>";
            echo "<input type='hidden' name='DNI' value='$dni'>";
            echo "<button type='submit'>Insertar</button>";
            echo "</form>";
            echo '</div>';
        }
        echo '</div>';
        ?>

    </main>

</body>

</html>