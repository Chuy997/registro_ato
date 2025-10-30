<?php
session_start();
require_once "../php/db.php";

if (!isset($_GET['id'])) {
    $_SESSION['admin_error']="ID no especificado";
    header("Location: empleados.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM empleados WHERE id_empleado=?");
$stmt->bind_param("s",$id);
if($stmt->execute()){
  $_SESSION['admin_success']="Empleado eliminado.";
} else {
  $_SESSION['admin_error']="Error al eliminar: ".$conn->error;
}
$stmt->close();

header("Location: empleados.php");
exit();
