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
        <form class="form">
            <div>
                <?php
                // Iniciar sesión PHP
                session_start();
                // Requerir el controlador para ver los datos del cliente
                require_once("../controller/verDatosClienteController.php");

                // Verificar si hay una sesión de usuario activa
                if (isset($_SESSION['usuario'])) {
                    // Obtener el correo electrónico del usuario de la sesión
                    $emailUsuario = $_SESSION['usuario'];

                    // Inicializar una variable para almacenar los datos del usuario
                    $datosUsuario = null;

                    // Iterar sobre los datos de los clientes para encontrar el usuario por su correo electrónico
                    foreach ($datosCliente as $cliente) {
                        if ($cliente['gmail'] === $emailUsuario) {
                            // Asignar los datos del usuario encontrado a la variable $datosUsuario
                            $datosUsuario = $cliente;
                            break;
                        }
                    }

                    // Si se encontraron los datos del usuario
                    if ($datosUsuario) {
                        // Mostrar un mensaje de éxito
                        echo "<h2 id='titulo'>Datos actualizados correctamente</h2>";
                        // Mostrar los datos del usuario
                        echo '<p><b>Nombre:</b><br> ' . htmlspecialchars($datosUsuario['nombre']) . '</p><hr>';
                        echo '<p><b>Teléfono:</b><br> ' . htmlspecialchars($datosUsuario['telefono']) . '</p><hr>';
                        echo '<p><b>Fecha Nacimiento:</b><br> ' . htmlspecialchars($datosUsuario['fechaNac']) . '</p><hr>';
                        echo '<p><b>DNI:</b><br> ' . htmlspecialchars($datosUsuario['DNI']) . '</p>';
                    } else {
                        // Mostrar un mensaje si no se encontraron datos del usuario
                        echo "No se encontraron datos del usuario.";
                    }
                } else {
                    // Si no hay sesión activa, detener el script PHP
                    exit();
                }
                ?>
            </div>
        </form>
    </div>
</body>

</html>