<?php
session_start();
include 'conexion.php';

// Validamos que el usuario haya presionado el botón de ingresar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email_usuario = $_POST['email'];
    $password_usuario = $_POST['password']; // Contraseña escrita en el formulario

    // 1. Preparamos la plantilla de la consulta con el marcador '?' para blindarlo
    $sql = "SELECT id_usuario, nombres, password, rol FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // 2. Vinculamos el correo de manera segura
        mysqli_stmt_bind_param($stmt, "s", $email_usuario);
        
        // 3. Ejecutamos
        mysqli_stmt_execute($stmt);
        
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($usuario = mysqli_fetch_assoc($resultado)) {
            
            // 4. Verificación de contraseña (asumiendo que usas password_verify para contraseñas cifradas)
            if (password_verify($password_usuario, $usuario['password'])) {
                
                // Guardamos los datos en la sesión
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombres'] = $usuario['nombres'];
                $_SESSION['rol'] = $usuario['rol'];
                
                // Redireccionamos según su rol (Driver o Cliente)
                if ($usuario['rol'] == 'driver') {
                    header("Location: dashboard-driver.php");
                } else {
                    header("Location: dashboard-user.php");
                }
                exit();
            } else {
                echo "<script>alert('Contraseña incorrecta');</script>";
            }
        } else {
            echo "<script>alert('El correo no está registrado');</script>";
        }
        
        mysqli_stmt_close($stmt);
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
            <div class="back-home">
    <a href="index.php">
        <i class="bi bi-arrow-left-circle-fill"></i>
        Volver al Inicio
    </a>
</div>

<h2>Bienvenido</h2>

<?php if(isset($_GET['registro']) && $_GET['registro'] == 'ok'): ?>
    <div class="alert alert-success">
        ✅ Usuario registrado correctamente. Ya puedes iniciar sesión.
    </div>
<?php endif; ?>

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