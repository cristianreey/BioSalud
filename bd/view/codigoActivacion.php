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
        <form action="../controller/comprobacionActivacionController.php" method="POST" class="form">
            <h1 class="title">¿Eres tú?</h1>
            <h4>Ingrese el código de activación enviado a su correo electrónico.</h4>

            <div class="inputContainer">
                <input type="text" name="codigoActivacion" class="input" placeholder="a">
                <label for="" class="label">Inserte el código</label>
            </div>

            <input type="submit" class="submitBtn" value="Entrar">
        </form>
    </div>
</body>

</html>