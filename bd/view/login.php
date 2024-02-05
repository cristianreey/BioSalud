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
    <form action="../controller/loginController.php" method="POST" class="form">
      <a href="../view/Tienda.php" class="backArrowLink">
        <img src="../IMAGEN/angulo-izquierdo.png" alt="Flecha hacia atrás">
      </a>
      <h1 class="title">Iniciar de sesión</h1>

      <div class="inputContainer">
        <input type="text" name="email" class="input" placeholder="a">
        <label for="" class="label">Email</label>
      </div>

      <div class="inputContainer">
        <input type="password" name="contrasena" class="input" placeholder="a">
        <label for="" class="label">Contraseña</label>
      </div>
      <a href="../view/registro.php" class="enlace">¿No tienes cuenta? Regístrate aquí</a>
      <input type="submit" class="submitBtn" value="Entrar">
    </form>
  </div>
</body>
</html>