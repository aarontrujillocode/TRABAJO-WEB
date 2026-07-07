<?php
session_start();
require_once 'includes/conexion.php';

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

// Verificar que el rol sea motorizado
if($_SESSION['rol'] != 'motorizado'){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])){
    $id_solicitud = intval($_GET['id']);
    $id_motorizado = $_SESSION['id_usuario'];

    // Iniciar una transacción para asegurar consistencia en ambas tablas
    mysqli_begin_transaction($conn);

    try {
        // 1. Intentar actualizar la solicitud original a estado 'aceptado'
        $sql_update = "UPDATE solicitudes 
                       SET estado='aceptado', 
                           id_motorizado='$id_motorizado', 
                           fecha_aceptacion=NOW() 
                       WHERE id_solicitud='$id_solicitud' 
                         AND estado='pendiente'";
        
        mysqli_query($conn, $sql_update);

        // Si se afectó la fila, significa que ganamos la carrera y la solicitud era nuestra
        if(mysqli_affected_rows($conn) > 0){
            
            // 2. Obtener los datos necesarios de la solicitud para crear el viaje
            $sql_datos = "SELECT id_cliente, origen, destino, precio FROM solicitudes WHERE id_solicitud='$id_solicitud'";
            $res_datos = mysqli_query($conn, $sql_datos);
            $datos = mysqli_fetch_assoc($res_datos);

            if($datos) {
                $id_cliente = $datos['id_cliente'];
                $origen = mysqli_real_escape_string($conn, $datos['origen']);
                $destino = mysqli_real_escape_string($conn, $datos['destino']);
                $precio = $datos['precio'];

                // 3. Insertar el registro correspondiente en la tabla 'viajes'
                $sql_insert = "INSERT INTO viajes (id_cliente, id_motorizado, origen, destino, precio, estado) 
                               VALUES ('$id_cliente', '$id_motorizado', '$origen', '$destino', '$precio', 'aceptado')";
                
                mysqli_query($conn, $sql_insert);
                
                // Confirmar todos los cambios en la base de datos
                mysqli_commit($conn);
                $_SESSION['mensaje'] = "✅ Viaje aceptado correctamente.";
            } else {
                throw new Exception("No se encontraron los datos de la solicitud.");
            }

        } else {
            // Cancelar transacción si no se pudo actualizar (ya lo tomó otro)
            mysqli_rollback($conn);
            $_SESSION['mensaje'] = "❌ Otro motorizado aceptó este viaje.";
        }

    } catch (Exception $e) {
        // En caso de cualquier error imprevisto, revertir los cambios
        mysqli_rollback($conn);
        $_SESSION['mensaje'] = "❌ Error al procesar la solicitud del viaje.";
    }
}

header("Location: dashboard-driver.php");
exit();
?>