<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="signupFrm">
        <a href="../view/Tienda.php" class="backArrowLink">
            <img src="../IMAGEN/angulo-izquierdo.png" alt="Flecha hacia atrás">
        </a>
        <form action="../view/VerProducto.php" method="POST" class="form">
            <?php
            use bd\model\Cliente;

            require_once("../controller/EditarClienteController.php");

            // Verificar si el formulario ha sido enviado
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Recuperar datos del formulario
                $clienteToUpdate = array(
                    'nombre' => $_POST['nombre'],
                    'DNI' => $_POST['DNI'],
                    'gmail' => $_POST['gmail'],
                    'fechaNac' => $_POST['fechaNac'],
                    'telefono' => $_POST['telefono']
                );

                // Llamar a la función para actualizar el cliente
                $filas_afectadas = EditarClien::updateCliente($pdo, $clienteToUpdate);

                // Verificar si se actualizaron filas
                if ($filas_afectadas > 0) {
                    echo "¡Datos actualizados con éxito!";
                } else {
                    echo "¡Error al actualizar los datos!";
                }
            }


            foreach ($datosCliente as $cliente) {
                echo "<input type='hidden' name='accion' value='Modificar'>";
                echo "<input type='hidden' name='nombre' value='" . $cliente['nombre'] . "'>";
                echo "<input type='hidden' name='gmail' value='" . $cliente['gmail'] . "'>";
                echo "<input type='hidden' name='DNI' value='" . $cliente['DNI'] . "'>";
                echo "<input type='hidden' name='telefono' value='" . $cliente['telefono'] . "'>";
                echo "<input type='hidden' name='fechaNac' value='" . $cliente['fechaNac'] . "'>";
                echo "<button type='submit'>Modificar</button>";
            }
            ?>
        </form>
    </div>
</body>

</html>