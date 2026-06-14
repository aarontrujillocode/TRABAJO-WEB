<?php

session_start();

require_once 'includes/conexion.php';

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios
            WHERE correo='$correo'";

    $resultado = mysqli_query($conn,$sql);

    if(mysqli_num_rows($resultado) == 1){

        $usuario = mysqli_fetch_assoc($resultado);

        if(password_verify(
            $password,
            $usuario['password']
        )){

            $_SESSION['id_usuario'] =
            $usuario['id_usuario'];

            $_SESSION['nombre'] =
            $usuario['nombres'];

            $_SESSION['rol'] =
            $usuario['rol'];

            if($usuario['rol']=="cliente"){

                header(
                    "Location: dashboard-user.php"
                );

            }elseif($usuario['rol']=="motorizado"){

                header(
                    "Location: dashboard-driver.php"
                );

            }else{

                header(
                    "Location: dashboard-admin.php"
                );

            }

            exit();

        }else{

            $error = "Contraseña incorrecta";

        }

    }else{

        $error = "Usuario no encontrado";

    }

}
?>

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

<?php if(!empty($error)): ?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<p class="subtitle">
    Inicia sesión para continuar
</p>
            <form method="POST">

                <div class="input-group-custom">

                    <i class="bi bi-envelope-fill"></i>
<input
type="email"
name="correo"
class="form-control"
placeholder="Correo electrónico"
required>

                </div>

                <div class="input-group-custom">

                    <i class="bi bi-lock-fill"></i>

<input
type="password"
name="password"
class="form-control"
placeholder="Contraseña"
required>

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

<button
type="submit"
class="btn-login">
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

                    <a href="register.php">

                        Regístrate

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>