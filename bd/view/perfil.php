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
        <form class="form">
            <a href="../view/Tienda.php" class="backArrowLink">
                <img src="../IMAGEN/angulo-izquierdo.png" alt="Flecha hacia atrás">
            </a>
            <?php
            // Iniciar sesión si aún no está iniciada
            session_start();

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
                    echo "<p><b>Nombre:</b><br> " . $datosUsuario['nombre'] . "</p><hr>";
                    echo "<p><b>Correo Electrónico:</b><br> " . $datosUsuario['gmail'] . "</p><hr>";
                    echo "<p><b>Teléfono:</b><br> " . $datosUsuario['telefono'] . "</p><hr>";
                    echo "<p><b>Fecha Nacimiento:</b><br> " . $datosUsuario['fechaNac'] . "</p><hr>";
                    echo "<p><b>DNI:</b><br> " . $datosUsuario['DNI'] . "</p><hr>";


                } else {
                    // Si no se encontraron los datos del usuario, muestra un mensaje de error
                    echo "No se encontraron datos del usuario.";
                }
            } else {
                // Si el usuario no está autenticado, redirigirlo al formulario de inicio de sesión
                header("Location: ../view/formulario_login.php");
                exit(); // Asegurarse de que el script se detenga después de la redirección
            }
            ?>



        </form>
    </div>
</body>

</html>