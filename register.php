<?php

require_once 'includes/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $rol = $_POST['rol'];
    $password = $_POST['password'];
    $confirmar = $_POST['confirmar_password'];

    if ($password != $confirmar) {

        $mensaje = "Las contraseñas no coinciden";

    } else {

        $verificar = mysqli_query(
            $conn,
            "SELECT id_usuario FROM usuarios WHERE correo='$correo'"
        );

        if (mysqli_num_rows($verificar) > 0) {

            $mensaje = "El correo ya está registrado";

        } else {

            $passwordHash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $sql = "INSERT INTO usuarios
            (
                nombres,
                apellidos,
                correo,
                telefono,
                password,
                rol
            )
            VALUES
            (
                '$nombres',
                '$apellidos',
                '$correo',
                '$telefono',
                '$passwordHash',
                '$rol'
            )";

if (mysqli_query($conn, $sql)) {

    header("Location: login.php?registro=ok");
    exit();

            } else {

                $mensaje = "Error al registrar usuario";

            }
        }
    }
}
?>

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

    <?php if(!empty($mensaje)): ?>
        <div class="alert alert-warning">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <p class="subtitle">
        Completa tus datos para comenzar
    </p>

        <form method="POST">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Nombres</label>

                        <input type="text" name="nombres" placeholder="Nombres" class="form-control" required>



                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Apellidos</label>

<input type="text" name="apellidos" placeholder="Apellidos" class="form-control" required>


                    </div>

                </div>

                <div class="mb-3">

                    <label>Correo Electrónico</label>

<input type="email" name="correo" class="form-control" required>

                </div>

                <div class="mb-3">

                    <label>Teléfono</label>

<input type="text" name="telefono" class="form-control" required>


                </div>

                <div class="mb-3">

                    <label>Tipo de Usuario</label>
<select name="rol" class="form-select" required>
    <option value="cliente">Cliente</option>
    <option value="motorizado">Motorizado</option>
</select>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Contraseña</label>

<input type="password" name="password" class="form-control" required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Confirmar</label>

<input type="password" name="confirmar_password" class="form-control" required>

                    </div>

                </div>

                <div class="form-check mb-4">

                    <input class="form-check-input"
                    type="checkbox">

                    <label class="form-check-label">

                        Acepto los términos y condiciones

                    </label>

                </div>

         <button type="submit" class="btn-register">

                    Crear Cuenta

                </button>

                <div class="login-link">

                    ¿Ya tienes cuenta?

                    <a href="login.php">

                        Iniciar Sesión

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>