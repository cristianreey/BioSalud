<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bioSalud</title>
    <link rel="stylesheet" href="../CSS/formularioFlotante.css">
    <script>
        function validarFormulario() {
            var contrasena = document.getElementsByName('contrasena')[0].value;
            var confirmarContrasena = document.getElementsByName('confirmarContrasena')[0].value;

            if (contrasena !== confirmarContrasena) {
                alert("Las contraseñas no coinciden");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="signupFrm">
        <form action="../controller/loginController.php" method="POST" class="form"
            onsubmit="return validarFormulario()">
            <a href="../view/login.html" class="backArrowLink">
                <img src="../IMAGEN/angulo-izquierdo.png" alt="Flecha hacia atrás">
            </a>
            <h1 class="title">Regístrate</h1>

            <div class="inputContainer">
                <input type="text" name="nombre" class="input" placeholder="a">
                <label for="" class="label">Nombre completo</label>
            </div>
            <div class="inputContainer">
                <input type="email" name="gmail" class="input" placeholder="a">
                <label for="" class="label">Email</label>
            </div>
            <div class="inputContainer">
                <input type="text" name="DNI" class="input" placeholder="a">
                <label for="" class="label">D.N.I</label>
            </div>
            <div class="inputContainer">
                <input type="number" name="telefono" class="input" placeholder="a">
                <label for="" class="label">Telefono</label>
            </div>
            <div class="inputContainer">
                <input type="date" name="fechaNac" class="input" placeholder="a">
                <label for="" class="label">Fecha de nacimiento</label>
            </div>
            <div class="inputContainer">
                <input type="password" name="contrasena" class="input" placeholder="a">
                <label for="" class="label">Contraseña</label>
            </div>
            <div class="inputContainer">
                <input type="password" name="confirmarContrasena" class="input" placeholder="a">
                <label for="" class="label">Confirmar contraseña</label>
            </div>

            <input type="submit" class="submitBtn" value="Entrar">
        </form>
    </div>
</body>

</html>