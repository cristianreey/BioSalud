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
                session_start(); // Inicia la sesión si no está iniciada
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
                        echo "<h2 id='titulo'>Datos actualizados correctamente</h2>";
                        echo '<p><b>Nombre:</b><br> ' . htmlspecialchars($datosUsuario['nombre']) . '</p><hr>';
                        echo '<p><b>Teléfono:</b><br> ' . htmlspecialchars($datosUsuario['telefono']) . '</p><hr>';
                        echo '<p><b>Fecha Nacimiento:</b><br> ' . htmlspecialchars($datosUsuario['fechaNac']) . '</p><hr>';
                        echo '<p><b>DNI:</b><br> ' . htmlspecialchars($datosUsuario['DNI']) . '</p>';
                    } else {
                        echo "No se encontraron datos del usuario.";
                    }
                } else {
                    exit();
                }
                ?>
            </div>
        </form>
    </div>
</body>

</html>