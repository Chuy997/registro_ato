<?php
// db.php
$servername = "localhost";
$username = "jmuro";
$password = "Monday.03";
$dbname = "empleados_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
