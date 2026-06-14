<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Registro | Drive Moto</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="css/register.css">

</head>

<body>

<div class="register-container">

    <!-- PANEL IZQUIERDO -->

    <div class="left-panel">

        <div>

            <h1>DRIVE MOTO</h1>

            <p>
                Regístrate y forma parte de la comunidad de transporte más rápida.
            </p>

            <img src="img/moto.png" class="moto-img">

        </div>

    </div>

    <!-- PANEL DERECHO -->

    <div class="right-panel">

        <div class="form-box">

            <h2>Crear Cuenta</h2>

            <p class="subtitle">
                Completa tus datos para comenzar
            </p>

            <form>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Nombres</label>

                        <input type="text"
                        class="form-control"
                        placeholder="Nombres">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Apellidos</label>

                        <input type="text"
                        class="form-control"
                        placeholder="Apellidos">

                    </div>

                </div>

                <div class="mb-3">

                    <label>Correo Electrónico</label>

                    <input type="email"
                    class="form-control"
                    placeholder="correo@ejemplo.com">

                </div>

                <div class="mb-3">

                    <label>Teléfono</label>

                    <input type="text"
                    class="form-control"
                    placeholder="+51 999999999">

                </div>

                <div class="mb-3">

                    <label>Tipo de Usuario</label>

                    <select class="form-select">

                        <option>Cliente</option>

                        <option>Motorizado</option>

                    </select>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Contraseña</label>

                        <input type="password"
                        class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Confirmar</label>

                        <input type="password"
                        class="form-control">

                    </div>

                </div>

                <div class="form-check mb-4">

                    <input class="form-check-input"
                    type="checkbox">

                    <label class="form-check-label">

                        Acepto los términos y condiciones

                    </label>

                </div>

                <button class="btn-register">

                    Crear Cuenta

                </button>

                <div class="login-link">

                    ¿Ya tienes cuenta?

                    <a href="login.html">

                        Iniciar Sesión

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>