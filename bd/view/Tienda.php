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
        <section class="section1">
            <div class="logo">
                <img src="IMAGEN/HatchfulExport-All/logo_transparent.png" alt="Logo de Farmacia TuSalud" />
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
        include('../controller/MainController.php');
        include('../controller/ProductoPorCategoriaController.php');

        $dni = 12345;
        $fechaActual = date("Y-m-d");

        if ($idCategoriaSeleccionada != 0) {
            echo '<h2>PRODUCTOS DISPONIBLES</h2>';
            echo '<hr>';
            echo '<div class="contenedorProductos">';

            // Aquí deberías recuperar y mostrar la lista de productos desde tu base de datos
        
            if ($datosProductoCategoria !== null) {
                foreach ($datosProducto as $producto) {
                    echo '<div class="productos">';
                    echo '<img class="w-50" src="' . $producto['url'] . '">';
                    echo '<h3>' . $producto['nombre'] . '</h3>';
                    echo '<p>Precio: ' . $producto['precio'] . '€</p>';
                    echo "<form action='../controller/InsertarCarritoController.php' method='POST' class='formulario'>\n";
                    echo '<input type="number" name="cantidad" id="cantidad" min=1 value="1">';
                    echo "<input type='hidden' name='fecha' value='$fechaActual'>";
                    echo "<input type='hidden' name='GUID' value='" . $producto['GUID'] . "'>";
                    echo "<input type='hidden' name='DNI' value='$dni'>";
                    echo "<button type='submit'>Insertar</button>";
                    echo "</form>";
                    echo '</div>';
                }

            } else {
                echo 'No se encontraron productos para la categoría seleccionada.';
            }
            echo '</div>';
        }
        if ($idCategoriaSeleccionada == 0) {
            echo '<div class="contenedor-carrusel">';
            echo '<div class="container d-flex align-items-center justify-content-center h-100">';
            echo '<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">';
            echo '<div class="carousel-inner">';
            echo '<div class="carousel-item active">';
            echo '<img src="IMAGEN/bienvenido.png" class=" h-100" alt="...">';
            echo '</div>';
            echo '<div class="carousel-item">';
            echo '<img src="IMAGEN/des.png..." class=" h-100" alt="...">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<h2>PRODUCTOS DESTACADOS</h2>';
            echo '<div class="productos-destacados">';
            echo '<div class="productos">';
            echo '<img class="w-50" alt=""  src="IMAGEN/aderma.jpg">';
            echo '<h3>Aderma Gel de Ducha, 500ml</h3>';
            echo '<p>Precio: 5€</p>';
            echo '</div>';
            echo '<div class="productos">';
            echo '<img class="w-50" alt=""  src="IMAGEN/atria.webp">';
            echo '<h3>Atria Crema de Noche Antiedad</h3>';
            echo '<p>Precio: 22€</p>';
            echo '</div>';
            echo '<div class="productos">';
            echo '<img class="w-50" alt=""  src="IMAGEN/novalac.webp">';
            echo '<h3>Novalac 2 Premium</h3>';
            echo '<p>Precio: 16€</p>';
            echo '</div>';
            echo '</div>';
        }
        ?>

    </main>

</body>

</html>