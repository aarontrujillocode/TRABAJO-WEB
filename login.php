<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Iniciar Sesión | Drive Moto</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="css/login.css">

</head>

<body>

<div class="login-container">

    <!-- PANEL IZQUIERDO -->

    <div class="left-panel">

        <div>

            <h1>DRIVE MOTO</h1>

            <p>
                Tu plataforma de transporte y delivery inteligente.
            </p>

            <img src="img/moto.png" class="moto-img">

        </div>

    </div>

    <!-- PANEL DERECHO -->

    <div class="right-panel">

        <div class="login-box">

            <h2>Bienvenido</h2>

            <p class="subtitle">
                Inicia sesión para continuar
            </p>

            <form>

                <div class="input-group-custom">

                    <i class="bi bi-envelope-fill"></i>

                    <input
                    type="email"
                    class="form-control"
                    placeholder="Correo electrónico">

                </div>

                <div class="input-group-custom">

                    <i class="bi bi-lock-fill"></i>

                    <input
                    type="password"
                    class="form-control"
                    placeholder="Contraseña">

                </div>

                <div class="options">

                    <div class="form-check">

                        <input
                        class="form-check-input"
                        type="checkbox">

                        <label class="form-check-label">
                            Recordarme
                        </label>

                    </div>

                    <a href="#">
                        ¿Olvidaste tu contraseña?
                    </a>

                </div>

                <button class="btn-login">

                    Iniciar Sesión

                </button>

                <div class="separator">

                    <span>o</span>

                </div>

                <button
                type="button"
                class="btn-google">

                    <i class="bi bi-google"></i>

                    Continuar con Google

                </button>

                <div class="register-link">

                    ¿No tienes cuenta?

                    <a href="register.html">

                        Regístrate

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>