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
        <?php
        require_once("../controller/verDatosClienteController.php");
        require_once("../controller/loginController.php");

        // Verificar si el usuario está autenticado
        if ($_SESSION['usuario'] == $datosCliente['gmail']) {
            echo "<h2 id='titulo'>Mi cuenta</h2>";
            echo "<p>Nombre: " . $datosCliente['nombre'] . "</p>";
            echo "<p>Correo Electrónico: " . $datosCliente['email'] . "</p>";
        }


        ?>
    </div>
</body>

</html>