<?php
session_start();
require_once "../php/db.php";

$empleados = [];
$stmt = $conn->prepare("SELECT id_empleado, nombre, puesto, area, fecha_antiguedad FROM empleados ORDER BY nombre");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $empleados[] = $row;
}
$stmt->close();
$totalEmpleados = count($empleados);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Administrar Empleados</title>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/admin_styles.css">
</head>
<body>
  <div class="admin-container">
    <header class="admin-header">
      <div class="title-row">
        <h1>Empleados</h1>
        <span class="pill"><?= $totalEmpleados ?> registrados</span>
      </div>

      <?php if (!empty($_SESSION['admin_error'])): ?>
        <div class="alert"><?= htmlspecialchars($_SESSION['admin_error']); unset($_SESSION['admin_error']); ?></div>
      <?php endif; ?>
      <?php if (!empty($_SESSION['admin_success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['admin_success']); unset($_SESSION['admin_success']); ?></div>
      <?php endif; ?>
    </header>

    <div class="actions-bar">
      <div class="actions-left">
        <a href="empleado_form.php" class="btn btn-primary">
          <span class="btn-icon" aria-hidden="true">＋</span> Agregar nuevo
        </a>
      </div>
      <div class="actions-right">
        <label class="search">
          <input id="tableSearch" type="search" placeholder="Buscar por nombre, puesto o área…" aria-label="Buscar">
          <svg class="search-ico" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
            <path d="M15.5 14h-.79l-.28-.27a6 6 0 1 0-.71.71l.27.28v.79l5 4.99L20.49 19zm-6 0A4.5 4.5 0 1 1 14 9.5 4.5 4.5 0 0 1 9.5 14z"/>
          </svg>
        </label>
      </div>
    </div>

    <div class="table-wrapper">
      <table class="table-empleados" id="empleadosTable">
        <thead>
          <tr>
            <th style="min-width:120px">ID</th>
            <th style="min-width:180px">Nombre</th>
            <th style="min-width:160px">Puesto</th>
            <th style="min-width:140px">Área</th>
            <th style="min-width:150px">Antigüedad</th>
            <th style="min-width:160px">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php if (empty($empleados)): ?>
          <tr><td colspan="6" class="empty">No hay empleados registrados.</td></tr>
        <?php else: ?>
          <?php foreach ($empleados as $emp): ?>
            <tr>
              <td data-label="ID"><?= htmlspecialchars($emp['id_empleado']) ?></td>
              <td data-label="Nombre"><?= htmlspecialchars($emp['nombre']) ?></td>
              <td data-label="Puesto"><?= htmlspecialchars($emp['puesto']) ?></td>
              <td data-label="Área"><span class="badge"><?= htmlspecialchars($emp['area']) ?></span></td>
              <td data-label="Antigüedad">
                <?= htmlspecialchars($emp['fecha_antiguedad']) ?>
              </td>
              <td data-label="Acciones">
                <div class="row-actions">
                  <a href="empleado_form.php?id=<?= urlencode($emp['id_empleado']) ?>" class="btn small">Editar</a>
                  <a href="empleado_delete.php?id=<?= urlencode($emp['id_empleado']) ?>" class="btn small danger"
                     onclick="return confirm('¿Eliminar a <?= htmlspecialchars($emp['nombre']) ?>?');">Borrar</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>

    <footer class="admin-footer">
      Panel de administración · <?= date('Y') ?>
    </footer>
  </div>

  <script>
    // Filtro rápido por texto (nombre/puesto/área)
    (function () {
      const input = document.getElementById('tableSearch');
      const table = document.getElementById('empleadosTable');
      if (!input || !table) return;

      input.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        const rows = table.tBodies[0].rows;
        for (let i = 0; i < rows.length; i++) {
          const cells = rows[i].cells;
          if (!cells || cells.length === 1) continue; // fila "empty"
          const nombre = (cells[1].innerText || '').toLowerCase();
          const puesto = (cells[2].innerText || '').toLowerCase();
          const area   = (cells[3].innerText || '').toLowerCase();
          const match = !q || nombre.includes(q) || puesto.includes(q) || area.includes(q);
          rows[i].style.display = match ? '' : 'none';
        }
      });
    })();
  </script>
</body>
</html>
<?php $conn->close(); ?>
