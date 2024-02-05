<?php
// Comprobar si la sesión está activa
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 300)) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Actualizar el tiempo de actividad de la sesión
$_SESSION['last_activity'] = time();
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>BioSalud</title>

    <link rel="stylesheet" href="../CSS/style.css" />

    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">



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
                <?php
                if (!isset($_SESSION['usuario'])) {
                    // Código para mostrar el icono de inicio de sesión
                    echo "<a href='login.php'><span class='material-icons'>account_circle</span></a>";
                } else {
                    // Código para mostrar la primera letra del nombre del usuario y el enlace de cierre de sesión
                    $nombreUsuario = $_SESSION['usuario'];
                    $primeraLetra = strtoupper(substr($nombreUsuario, 0, 1));
                    echo "<a class='material-icons perfil' href='perfil.php'>$primeraLetra</a>";
                    echo "<a href='../controller/logoutController.php'><span class='material-icons'>exit_to_app</span></a>";
                }
                ?>
                <a href="CarritoTienda.php"><span class="material-icons">shopping_bag</span></a>
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

            $idCategoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : 0;

            foreach ($categorias as $id => $nombreCategoria) {
                $enlace = "../view/Tienda.php?categoria=$id";
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

        // Inicializar el total del carrito
        $totalCarrito = 0;

        foreach ($datosProductoId as $producto) {
            // Sumar el precio del producto actual al total del carrito
            $totalCarrito += $producto['precio'];

            echo '<div class="productos">';
            echo '<img class="w-50" src="' . $producto['url'] . '">';
            echo '<h3>' . $producto['nombre'] . '</h3>';
            echo '<p>Cantidad: ' . $producto['cantidad'] . '</p>';
            echo '<p>Precio: ' . $producto['precio'] . '€</p>';

            // Botón para borrar el producto del carrito
            echo "<form action='../controller/EliminarDatosController.php' method='POST' class='formulario'>\n";
            echo "<input type='hidden' name='producto_id' value='" . $producto['GUID'] . "'>";
            echo "<button type='submit'>Eliminar del Carrito</button>";
            echo "</form>";
            echo '</div>';
        }
        echo '</div>';

        echo '<hr>';

        echo '<div class="contenedor-botones">';
        // Imprimir el total del carrito
        echo "<p><b>Total del Carrito:</b> $totalCarrito €</p>";
        // Formulario para eliminar el carrito completo
        echo "<form action='../controller/EliminarCarritoController.php' method='POST' class='formulario'>\n";
        echo "<div class='botones-carrito'><button type='submit'>Vaciar Carrito</button><div>";
        echo "</form>";
        echo '</div>';
        ?>


    </main>
</body>

</html>