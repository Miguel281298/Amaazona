<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Amaazona</title>
  <link rel="stylesheet" href="css/login.css" />
  <link
    href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="fonts/icomoon/style.css" />
</head>

<body>
  <div class="container" id="container">
    <div class="form-container sign-up-container">
      <form action="registro.php" method="POST">
        <img src="img/logo.png" width="115" />
        <h1>Regístrate</h1>
        <input type="text" name="nombre" placeholder="Nombre" required />
        <input type="text" name="apellido" placeholder="Apellido" required />
        <input type="email" name="correo" placeholder="Correo" required />
        <input
          type="password"
          name="password"
          placeholder="Contraseña"
          required />
        <button type="submit">Registrame</button>
      </form>
    </div>
    <div class="form-container sign-in-container">
      <form action="login.php" method="POST">
        <img src="img/logo.png" width="115" />
        <h1 style="margin: 1rem 0">Iniciar sesión</h1>
        <input type="email" name="correo" placeholder="Correo" required />
        <input
          type="password"
          name="password"
          placeholder="Contraseña"
          required />
        <a href="#">¿Olvidaste tu contraseña?</a>
        <button type="submit">Entrar</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Bienvenido de vuelta</h1>
          <p>
            ¿Qué compraremos hoy? INGRESA tus datos de inicio de sesión para
            continuar.
          </p>
          <button class="ghost" id="signIn">Iniciar sesión</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>¿No tienes cuenta?</h1>
          <p>
            Ingresa tus datos de identificación para ser parte de
            <b>AMAAZONA</b>.
          </p>
          <button class="ghost" id="signUp">Registrate</button>
        </div>
      </div>
    </div>
  </div>
  <script src="js/login.js"></script>
</body>

</html>