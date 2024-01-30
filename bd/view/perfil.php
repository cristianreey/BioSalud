<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bioSalud</title>
    <link rel="stylesheet" href="../CSS/formularioFlotante.css">
</head>

<body>
    <div class="signupFrm">
        <a href="../view/Tienda.php" class="backArrowLink">
            <img src="../IMAGEN/angulo-izquierdo.png" alt="Flecha hacia atrás">
        </a>
        <form action="../controller/EditarClienteCpntroller.php" class="form">
            <?php

            require_once("../controller/verDatosClienteController.php");

            // Verificar si el usuario está autenticado
            if (isset($_SESSION['usuario'])) {
                // Obtener el correo electrónico del usuario actual
                $emailUsuario = $_SESSION['usuario'];

                // Buscar los datos del usuario actual en $datosCliente
                $datosUsuario = null;
                foreach ($datosCliente as $cliente) {
                    if ($cliente['gmail'] === $emailUsuario) {
                        $datosUsuario = $cliente;
                        break;
                    }
                }

                // Verificar si se encontraron los datos del usuario
                if ($datosUsuario) {
                    // Mostrar los datos del usuario
                    echo "<h2 id='titulo'>Mi cuenta</h2>";
                    echo '<form action="../controller/EditarClienteCpntroller.php" method="POST">';
                    echo '<label for="nombre">Nombre:</label>';
                    echo '<input type="text" name="nombre" value="' . $datosUsuario['nombre'] . '" required><hr>';
                    echo '<label for="telefono">Teléfono:</label>';
                    echo '<input type="text" name="telefono" value="' . $datosUsuario['telefono'] . '" required><hr>';
                    echo '<label for="fechaNac">Fecha Nacimiento:</label>';
                    echo '<input type="date" name="fechaNac" value="' . $datosUsuario['fechaNac'] . '" required><hr>';
                    echo '<label for="DNI">DNI:</label>';
                    echo '<input type="text" name="DNI" value="' . $datosUsuario['DNI'] . '" required><hr>';
                    echo '<button type="submit" name="editar">Modificar</button>';
                    echo '</form>';
                } else {
                    // Si no se encontraron los datos del usuario, muestra un mensaje de error
                    echo "No se encontraron datos del usuario.";
                }
            } else {
                // Si el usuario no está autenticado, redirigirlo al formulario de inicio de sesión
                header("Location: ../view/modificar.php");
                exit(); // Asegurarse de que el script se detenga después de la redirección
            }
            ?>
        </form>
    </div>
</body>

</html>