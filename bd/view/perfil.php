<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bioSalud</title>
    <link rel="stylesheet" href="../CSS/formularioFlotante.css">
    <link rel="stylesheet" href="../CSS/formulario.css">

</head>

<body>
    <div class="signupFrm">
        <a href="../view/Tienda.php" class="backArrowLink">
            <img src="../IMAGEN/angulo-izquierdo.png" alt="Flecha hacia atrás">
        </a>
        <form action="../controller/EditarClienteController.php" method="POST" class="form">
            <?php
            session_start();
            require_once("../controller/verDatosClienteController.php");

            if (isset($_SESSION['usuario'])) {
                $emailUsuario = $_SESSION['usuario'];

                $datosUsuario = null;
                foreach ($datosCliente as $cliente) {
                    if ($cliente['gmail'] === $emailUsuario) {
                        $datosUsuario = $cliente;
                        break;
                    }
                }

                if ($datosUsuario) {
                    echo "<h2 id='titulo'>Mi cuenta</h2>";
                    echo '<label for="nombre">Nombre:</label>';
                    echo '<input type="text" name="nombre" value="' . $datosUsuario['nombre'] . '" required><hr>';
                    echo '<label for="telefono">Teléfono:</label>';
                    echo '<input type="text" name="telefono" value="' . $datosUsuario['telefono'] . '" required><hr>';
                    echo '<label for="fechaNac">Fecha Nacimiento:</label>';
                    echo '<input type="date" name="fechaNac" value="' . $datosUsuario['fechaNac'] . '" required><hr>';
                    echo '<label for="DNI">DNI:</label>';
                    echo '<input type="text" name="DNI" value="' . $datosUsuario['DNI'] . '" required><hr>';
                    echo '<button type="submit" name="editar">Modificar</button>';
                } else {
                    echo "No se encontraron datos del usuario.";
                }
            } else {
                exit();
            }
            ?>
        </form>
    </div>
</body>

</html>