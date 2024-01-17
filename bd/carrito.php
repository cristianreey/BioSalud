<?php
// carrito.php
include('funciones.php');

session_start();

// Agregar producto al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $GUID = $_POST['GUID'];
    $_SESSION['carrito'][] = obtenerProductoDesdeBaseDeDatosPorId($GUID);
}

// Eliminar producto del carrito
if (isset($_GET['action']) && $_GET['action'] == 'eliminar_producto' && isset($_GET['index'])) {
    $index = $_GET['index'];
    if (isset($_SESSION['carrito'][$index])) {
        unset($_SESSION['carrito'][$index]);
    }
    // Puedes realizar redirección o mostrar un mensaje de éxito aquí
}

// Vaciar el carrito
if (isset($_GET['action']) && $_GET['action'] == 'vaciar_carrito') {
    unset($_SESSION['carrito']);
    // Puedes realizar redirección o mostrar un mensaje de éxito aquí
}

// Actualizar el carrito (puedes implementar lógica adicional aquí)
if (isset($_GET['action']) && $_GET['action'] == 'actualizar_carrito') {
    // Lógica de actualización del carrito (si es necesario)
    // ...
}
?>


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

    <main>
        <h1>Carrito de Compras</h1>

        <?php
        // Mostrar los productos en el carrito
        if (!empty($_SESSION['carrito'])) {
            $productos = $_SESSION['carrito'];
            for ($i = 0; $i < count($productos); $i++) {
                echo '<div>';
                echo '<img class="w-25" alt=""  src="' . $productos[$i]['url'] . '">';
                echo '<div>';
                echo '<h3>' . $productos[$i]['nombre'] . '</h3>';
                echo '<p>Precio: $' . $productos[$i]['precio'] . '</p>';
                echo '</div>';

                // Botón de eliminar producto
                echo '<a href="?action=eliminar_producto&index=' . $i . '"><button>Eliminar</button></a>';

                echo '</div>';
            }

            // Botón de actualizar carrito
            echo '<a href="?action=actualizar_carrito"><button>Actualizar Carrito</button></a>';

            // Botón de vaciar carrito
            echo '<a href="?action=vaciar_carrito"><button>Vaciar Carrito</button></a>';
        } else {
            echo '<p>El carrito de compras está vacío.</p>';
        }
        ?>
    </main>
</body>

</html>