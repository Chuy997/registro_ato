<?php 
session_start(); 

// Depuración temporal
if (isset($_SESSION['id_empleado'])) {
    echo "<!-- ID de Empleado en sesión: " . htmlspecialchars($_SESSION['id_empleado']) . " -->";
} else {
    echo "<!-- ID de Empleado no está definido en la sesión -->";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Entrada ATO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Ajustes mínimos por si falta algún estilo */
        .login-box{max-width:480px;margin:40px auto;padding:24px;background:#1114;border-radius:12px;color:#eee}
        .btn{background:#03e9f4;border:0;color:#000;font-weight:700}
        .form-group{position:relative;margin-bottom:1.25rem}
        .form-group input{width:100%;background:transparent;border:0;border-bottom:2px solid #777;color:#eee;padding:.75rem .5rem;outline:none}
        .form-group label{position:absolute;left:.5rem;top:.6rem;color:#aaa;pointer-events:none;transition:.2s}
        .form-group input:focus{border-color:#03e9f4}
        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label{
            top:-.8rem;font-size:.8rem;color:#03e9f4;background:#1114;padding:0 .25rem
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1 class="text-center mb-4">Registro de Entrada ATO</h1>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php 
            echo htmlspecialchars($_SESSION['error']); 
            unset($_SESSION['error']); // limpiar sólo el flash de error
            ?>
        </div>
        <?php endif; ?>

        <form action="php/registrar_entrada.php" method="post" autocomplete="off">
            <div class="form-group">
                <!-- placeholder en blanco para labels flotantes -->
                <input type="text" id="id_empleado" name="id_empleado" required placeholder=" ">
                <label for="id_empleado">ID de Empleado</label>
            </div>
            <button type="submit" class="btn btn-block">
                Registrar Entrada
            </button>
        </form>

        <div id="mensaje_resistencia" class="mt-4 text-center text-muted">
            Recuerda hacerte la prueba de resistencia antes de ingresar a ATO.
        </div>

        <?php if (isset($_GET['success']) && isset($_SESSION['nombre_empleado'])): ?>
        <div id="mensaje_bienvenida" class="mt-3 text-center font-weight-bold">
            ¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_empleado']); ?>!
        </div>

        <div id="mensaje_motivador" class="mt-2 text-center">
            <?php
            $mensajes_generales = [
               "¡Gracias por estar aquí y dar lo mejor de ti cada día!",
               "¡Tú haces la diferencia, sigue brillando con tu trabajo!",
               "¡Cada paso que das deja huella, sigue avanzando!",
               "¡Eres una pieza clave, tu esfuerzo es valioso y reconocido!",
               "¡Gracias por tu compromiso diario, tu trabajo sí importa!",
               "¡Recuerda que cada día es una nueva oportunidad para superarte!",
               "¡Tu actitud positiva es contagiosa, nunca cambies!",
               "¡Lo que haces con pasión, lo haces mejor!",
               "¡Hoy puede ser ese gran día, solo necesitas dar el primer paso!",
               "¡Sigue adelante, tu constancia te está llevando lejos!",
               "¡Lo estás haciendo muy bien, sigue en ese camino!",
               "¡Cada pequeño logro suma, nunca dejes de intentarlo!",
               "¡Tu esfuerzo construye el futuro que deseas!",
               "¡Nunca subestimes el poder de tu presencia y tu actitud!",
               "¡Con dedicación como la tuya, todo es posible!",
               "¡Gracias por sumar con tu talento y buena vibra!",
               "¡El éxito es tuyo cuando das un paso más que ayer!",
               "¡Tu energía y entrega inspiran a quienes te rodean!",
               "¡Cree en ti, porque tú tienes todo para lograrlo!",
               "¡Trabajar contigo es un privilegio, gracias por estar aquí!",
               "¡Hoy puede ser mejor que ayer si tú decides que lo sea!",
               "¡El mundo necesita personas como tú: con corazón, mente y acción!",
               "¡Tu presencia marca la diferencia, sigue adelante!",
               "¡El talento gana partidos, pero el trabajo en equipo gana campeonatos!",
               "¡Hoy tienes el poder de influir positivamente en tu entorno!",
               "¡No estás solo, somos un equipo y juntos logramos más!",
               "¡La disciplina que muestras es admirable!",
               "¡Cada día que vienes, traes valor a este lugar!",
               "¡Eres parte fundamental del equipo, nunca lo olvides!",
               "¡Sigue con esa actitud y el éxito será inevitable!"
            ];
            

            // Determina el ID para decidir mensajes
            $id_empleado = null;
            if (isset($_SESSION['id_empleado'])) {
                $id_empleado = (int) $_SESSION['id_empleado'];
            } elseif (isset($_GET['id_empleado'])) { // fallback opcional
                $id_empleado = (int) $_GET['id_empleado'];
            }

            $mensajes = ($id_empleado === 30) ? $mensajes_302484 : $mensajes_generales;
            echo $mensajes[array_rand($mensajes)];

            // Limpia SÓLO los flash usados. Mantengo id_empleado por si lo quieres reutilizar.
            unset($_SESSION['error'], $_SESSION['admin_error'], $_SESSION['admin_success'], $_SESSION['nombre_empleado']);
            ?>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const el = document.getElementById("id_empleado");
            if (el) el.focus();
        });
    </script>
</body>
</html>
