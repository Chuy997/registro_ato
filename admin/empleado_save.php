<?php
session_start();
require_once "../php/db.php";

$isEdit = !empty($_POST['is_edit']) && $_POST['is_edit']==='1';

$id_empleado = trim($_POST['id_empleado']);
$nombre = trim($_POST['nombre']);
$puesto = trim($_POST['puesto']);
$area = trim($_POST['area']);
$fecha = trim($_POST['fecha_antiguedad']) ?: null;

if ($isEdit) {
    $orig = $_POST['original_id'];
    $stmt = $conn->prepare("UPDATE empleados SET nombre=?, puesto=?, area=?, fecha_antiguedad=? WHERE id_empleado=?");
    $stmt->bind_param("sssss",$nombre,$puesto,$area,$fecha,$orig);
    if($stmt->execute()){
      $_SESSION['admin_success']="Empleado actualizado con éxito.";
    } else {
      $_SESSION['admin_error']="Error al actualizar: ".$conn->error;
    }
    $stmt->close();
} else {
    $stmt = $conn->prepare("INSERT INTO empleados (id_empleado,nombre,puesto,area,fecha_antiguedad) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss",$id_empleado,$nombre,$puesto,$area,$fecha);
    if($stmt->execute()){
      $_SESSION['admin_success']="Empleado creado correctamente.";
    } else {
      $_SESSION['admin_error']="Error al crear: ".$conn->error;
    }
    $stmt->close();
}

header("Location: empleados.php");
exit();
