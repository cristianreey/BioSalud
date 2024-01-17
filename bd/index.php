<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Farmacia TuSalud</title>
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
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
            <a href="#">BEBÉ Y MAMÁ</a>
            <a href="#">HINGIENE BUCAL</a>
            <a href="#">SALUD SEXUAL</a>
            <a href="#">DERMOCOSMÉTICA</a>
            <a href="#">ALIMENTACIÓN</a>
            <a href="#">MEDICINA NATURAL</a>
            <a href="#">ÓPTICA</a>
            <a href="#">BOTIQUÍN</a>
            <a href="#">ORTOPEDIA</a>
            <a href="#">MASCOTAS</a>
        </section>
    </header>
    <main class="contenedor">
        <!-- Lista de productos -->
        <h2>Productos Disponibles</h2>
        <div class="contenedorProductos">
            <?php
            include('funciones.php');

            // Aquí deberías recuperar y mostrar la lista de productos desde tu base de datos
            $productos = obtenerProductosDesdeBaseDeDatos();

            for ($i = 0; $i < count($productos); $i++)
                foreach ($productos[$i] as $producto) {
                    echo '<div class="productos">';
                    echo '<img class="w-50" alt=""  src="' . $producto['url'] . '">';
                    echo '<h3>' . $producto['nombre'] . '</h3>';
                    echo '<p>Precio: $' . $producto['precio'] . '</p>';
                    echo '<form action="carrito.php" method="post">';
                    echo '<input type="hidden" name="GUID" value="' . $producto['GUID'] . '">';
                    echo '<button type="submit">Agregar al carrito</button>';
                    echo '</form>';
                    echo '</div>';
                }
            ?>
        </div>
    </main>
</body>

</html>