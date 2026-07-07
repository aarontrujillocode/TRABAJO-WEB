<?php
// cambiar_estado_viaje.php
session_start();
require_once 'includes/conexion.php';

if(!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'motorizado'){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id']) && isset($_GET['nuevo_estado'])){
    $id_viaje = intval($_GET['id']);
    $nuevo_estado = mysqli_real_escape_string($conn, $_GET['nuevo_estado']);
    $id_motorizado = $_SESSION['id_usuario'];

    // Iniciar transacción para asegurar consistencia
    mysqli_begin_transaction($conn);

    try {
        // 1. Validar que el viaje pertenezca a este motorizado y obtener el id_cliente/origen/destino si es necesario
        $sql_check = "SELECT id_cliente, origen, destino FROM viajes WHERE id_viaje = '$id_viaje' AND id_motorizado = '$id_motorizado'";
        $res_check = mysqli_query($conn, $sql_check);
        $viaje_data = mysqli_fetch_assoc($res_check);

        if($viaje_data) {
            $id_cliente = $viaje_data['id_cliente'];
            $origen = mysqli_real_escape_string($conn, $viaje_data['origen']);
            $destino = mysqli_real_escape_string($conn, $viaje_data['destino']);

            // 2. Actualizar el estado en la tabla 'viajes'
            $sql_update_viaje = "UPDATE viajes SET estado = '$nuevo_estado' WHERE id_viaje = '$id_viaje'";
            mysqli_query($conn, $sql_update_viaje);

            // 3. Sincronizar el estado en la tabla 'solicitudes' vinculada
            // Buscamos la solicitud equivalente usando el cliente, origen y destino que están pendientes/aceptados
            $sql_update_solicitud = "UPDATE solicitudes 
                                     SET estado = '$nuevo_estado' 
                                     WHERE id_cliente = '$id_cliente' 
                                       AND origen = '$origen' 
                                       AND destino = '$destino' 
                                       AND estado IN ('aceptado', 'en_curso')";
            mysqli_query($conn, $sql_update_solicitud);

            // 4. Gestionar el estado del motorizado en la tabla 'motorizados'
            if($nuevo_estado == 'en_curso') {
                // Si inició viaje, el motorizado pasa a estar ocupado
                $sql_status = "UPDATE motorizados SET estado = 'ocupado' WHERE id_usuario = '$id_motorizado'";
                mysqli_query($conn, $sql_status);
                $_SESSION['mensaje'] = "🚀 Viaje iniciado. ¡Conduce con cuidado!";
            } 
            elseif($nuevo_estado == 'finalizado') {
                // Si finalizó, vuelve a estar disponible para recibir pedidos
                $sql_status = "UPDATE motorizados SET estado = 'disponible' WHERE id_usuario = '$id_motorizado'";
                mysqli_query($conn, $sql_status);
                $_SESSION['mensaje'] = "✅ Viaje completado con éxito.";
            }

            mysqli_commit($conn);
        } else {
            mysqli_rollback($conn);
            $_SESSION['mensaje'] = "❌ Error: El viaje no coincide con tus registros.";
        }

    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['mensaje'] = "❌ Ocurrió un error al actualizar el estado del viaje.";
    }
}

header("Location: dashboard-driver.php");
exit();
?>