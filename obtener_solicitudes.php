<?php
// obtener_solicitudes.php
session_start();
require_once 'includes/conexion.php';

if(!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'motorizado'){
    echo json_encode([]);
    exit();
}

$sql = "SELECT id_solicitud, origen, destino, precio FROM solicitudes 
        WHERE estado='pendiente' 
        ORDER BY fecha DESC";

$resultado = mysqli_query($conn, $sql);
$solicitudes = [];

while($fila = mysqli_fetch_assoc($resultado)){
    $solicitudes[] = [
        'id_solicitud' => $fila['id_solicitud'],
        'origen' => htmlspecialchars($fila['origen']),
        'destino' => htmlspecialchars($fila['destino']),
        'precio' => number_format($fila['precio'], 2)
    ];
}

header('Content-Type: application/json');
echo json_encode($solicitudes);