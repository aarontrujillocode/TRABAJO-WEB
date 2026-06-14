<?php

// =======================================
// CONEXIÓN A LA BASE DE DATOS DRIVE MOTO
// =======================================

// Datos de conexión
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "drive_moto";

// Crear conexión
$conn = mysqli_connect(
    $host,
    $usuario,
    $password,
    $base_datos
);

// Verificar conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Configurar caracteres UTF-8
mysqli_set_charset($conn, "utf8");

?>  