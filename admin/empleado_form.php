<?php
session_start();
require_once "../php/db.php";

$isEdit = false;
$emp = ['id_empleado'=>'','nombre'=>'','puesto'=>'','area'=>'','fecha_antiguedad'=>''];

if (isset($_GET['id'])) {
  $isEdit = true;
  $id = $_GET['id'];
  $stmt = $conn->prepare("SELECT id_empleado,nombre,puesto,area,fecha_antiguedad FROM empleados WHERE id_empleado = ?");
  $stmt->bind_param("s",$id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows === 1) {
    $emp = $res->fetch_assoc();
  } else {
    $_SESSION['admin_error']="Empleado no encontrado";
    header("Location: empleados.php");
    exit();
  }
  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $isEdit ? "Editar Empleado":"Nuevo Empleado" ?></title>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/admin_styles.css">
</head>
<body>
  <div class="admin-container">
    <header class="admin-header">
      <div class="title-row">
        <h2><?= $isEdit ? "Editar Empleado":"Crear Empleado" ?></h2>
      </div>
    </header>

    <form action="empleado_save.php" method="post" novalidate>
      <input type="hidden" name="is_edit" value="<?= $isEdit?'1':'0' ?>">
      <?php if($isEdit): ?>
        <input type="hidden" name="original_id" value="<?= htmlspecialchars($emp['id_empleado']) ?>">
      <?php endif; ?>

      <div class="form-grid">
        <div class="form-group">
          <input type="text" id="id_empleado" name="id_empleado" required
                 value="<?= htmlspecialchars($emp['id_empleado']) ?>" <?= $isEdit?"readonly":"" ?> placeholder=" ">
          <label for="id_empleado">ID Empleado<?= $isEdit ? " (sólo lectura)":"" ?></label>
        </div>

        <div class="form-group">
          <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($emp['nombre']) ?>" placeholder=" ">
          <label for="nombre">Nombre</label>
        </div>

        <div class="form-group">
          <input type="text" id="puesto" name="puesto" value="<?= htmlspecialchars($emp['puesto']) ?>" placeholder=" ">
          <label for="puesto">Puesto</label>
        </div>

        <div class="form-group">
          <input type="text" id="area" name="area" value="<?= htmlspecialchars($emp['area']) ?>" placeholder=" ">
          <label for="area">Área</label>
        </div>

        <div class="form-group">
          <input type="date" id="fecha_antiguedad" name="fecha_antiguedad" value="<?= htmlspecialchars($emp['fecha_antiguedad']) ?>" placeholder=" ">
          <label for="fecha_antiguedad">Fecha de Antigüedad</label>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit?"Guardar cambios":"Crear" ?></button>
        <a href="empleados.php" class="btn ghost">Cancelar</a>
      </div>
    </form>

    <footer class="admin-footer">
      Panel de administración · <?= date('Y') ?>
    </footer>
  </div>
</body>
</html>
<?php $conn->close(); ?>
