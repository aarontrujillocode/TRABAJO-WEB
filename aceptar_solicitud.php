<?php

session_start();

require_once 'includes/conexion.php';

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])){

    $id_solicitud = $_GET['id'];

    $id_motorizado = $_SESSION['id_usuario'];

    $sql = "UPDATE solicitudes
            SET
            estado='aceptado',
            id_motorizado='$id_motorizado',
            fecha_aceptacion=NOW()
            WHERE id_solicitud='$id_solicitud'";

    mysqli_query($conn, $sql);

}

header("Location: dashboard-driver.php");
exit();

?>