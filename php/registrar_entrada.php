<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "empleados_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_empleado = $_POST['id_empleado'];

// Obtener el nombre del empleado
$sql = "SELECT nombre FROM empleados WHERE id_empleado = '$id_empleado'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre_empleado = $row['nombre'];

    // Insertar el registro de entrada
    $sql = "INSERT INTO registros_entrada (empleado_id) VALUES ('$id_empleado')";

    if ($conn->query($sql) === TRUE) {
        // Guardar el nombre del empleado en la sesión
        $_SESSION['nombre_empleado'] = $nombre_empleado;
        header("Location: ../index.php?success=1");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Redirigir con un mensaje de error si el ID es inválido
    $_SESSION['error'] = "ID no válido. Por favor, regístrate en la tabla de entrada de visitantes y avisa al departamento de pruebas para que te agreguen a la base de datos.";
    header("Location: ../index.php?error=1");
    exit();
}

$conn->close();
?>
