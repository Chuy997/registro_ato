<?php
session_start();

$servername = "localhost";
$username   = "jmuro";
$password   = "Monday.03";
$dbname     = "empleados_db";

// Conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Sanitiza entrada básica
$id_empleado_raw = isset($_POST['id_empleado']) ? trim($_POST['id_empleado']) : '';
if ($id_empleado_raw === '') {
    $_SESSION['error'] = "Debes ingresar tu ID de empleado.";
    header("Location: ../index.php?error=1");
    exit();
}

// 1) Buscar empleado (Prepared Statement)
$stmt = $conn->prepare("SELECT nombre FROM empleados WHERE id_empleado = ?");
$stmt->bind_param("s", $id_empleado_raw);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows === 1) {
    $row             = $res->fetch_assoc();
    $nombre_empleado = $row['nombre'];

    // (Opcional) Regenera ID de sesión por seguridad tras login-like
    if (function_exists('session_regenerate_id')) {
        session_regenerate_id(true);
    }

    // 2) Insertar registro de entrada (Prepared)
    $stmtIns = $conn->prepare("INSERT INTO registros_entrada (empleado_id) VALUES (?)");
    $stmtIns->bind_param("s", $id_empleado_raw);

    if ($stmtIns->execute()) {
        // 3) Guardar datos en sesión para la página de bienvenida
        $_SESSION['id_empleado']     = $id_empleado_raw;  // <-- clave para mensajes especiales
        $_SESSION['nombre_empleado'] = $nombre_empleado;

        // Redirige con success
        header("Location: ../index.php?success=1");
        exit();
    } else {
        // Error al insertar registro
        $_SESSION['error'] = "No se pudo registrar tu entrada. Inténtalo de nuevo.";
        header("Location: ../index.php?error=1");
        exit();
    }
} else {
    // ID inválido
    $_SESSION['error'] = "ID no válido. Por favor, regístrate en la tabla de entrada de visitantes y avisa al departamento de pruebas para que te agreguen a la base de datos.";
    header("Location: ../index.php?error=1");
    exit();
}

$stmt->close();
$conn->close();
