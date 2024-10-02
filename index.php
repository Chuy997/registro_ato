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
</head>
<body>
    <div class="login-box">
        <h1>Registro de Entrada ATO</h1>
        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php 
            echo htmlspecialchars($_SESSION['error']); 
            unset($_SESSION['error']); // Limpiar el mensaje de error después de mostrarlo
            ?>
        </div>
        <?php endif; ?>

        <form action="php/registrar_entrada.php" method="post">
            <div class="form-group">
                <input type="text" id="id_empleado" name="id_empleado" required>
                <label for="id_empleado">ID de Empleado</label>
            </div>
            <button type="submit" class="btn">
                Registrar Entrada
            </button>
        </form>

        <div id="mensaje_resistencia" class="mt-4 text-center">
            <!-- Mensaje permanente de resistencia -->
            Recuerda hacerte la prueba de resistencia antes de ingresar a ATO.
        </div>

        <?php if (isset($_GET['success']) && isset($_SESSION['nombre_empleado'])): ?>
        <div id="mensaje_bienvenida" class="mt-2 text-center">
            <!-- Mensaje de bienvenida -->
            ¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_empleado']); ?>!
        </div>

        <div id="mensaje_motivador" class="mt-2 text-center">
            <!-- Mensaje motivacional -->
            <?php
            $mensajes_generales = [
                "¡El éxito es la suma de pequeños logros diarios, no subestimes lo que haces hoy!",
                "¡Eres increíble! No solo rompes barreras, ¡las haces polvo!",
                "¡Sigue así! ¡Estás construyendo tu propio camino al éxito!",
                "¡Tu esfuerzo vale la pena! ¡Cada paso te acerca más a tus sueños!",
                "¡Hoy es un gran día para alcanzar tus metas! ¡Como un amanecer lleno de posibilidades!",
                "¡Nunca te rindas! ¡Recuerda que las mejores victorias llegan después de los mayores retos!",
                "¡Cada día es una nueva oportunidad para mejorar! ¡Haz que cuente!",
                "¡Tu dedicación es inspiradora! ¡Continúa brillando con esa energía!",
                "¡El éxito es el resultado de pequeños esfuerzos repetidos día tras día, como gotas que llenan un vaso!",
                "¡Cada pequeño paso te acerca a la cima, sigue adelante!",
                "¡Tu esfuerzo no pasa desapercibido, estás construyendo un futuro brillante!",
                "¡Confía en ti mismo, porque el mundo necesita lo que solo tú puedes ofrecer!",
                "¡La perseverancia es la llave que abre las puertas del éxito!",
                "¡Tu trabajo duro está dando frutos, sigue cosechando grandes resultados!",
                "¡Eres una pieza clave en este proyecto, tu contribución es invaluable!",
                "¡El éxito es la suma de buenos hábitos mantenidos con disciplina!",
                "¡Cada día es una nueva oportunidad para avanzar, no la dejes pasar!",
                "¡Tu compromiso marca la diferencia, sigue dejando huella!",
                "¡El éxito no es una meta, es un viaje que disfrutas cada día!",
                "¡Sigue adelante, lo mejor está por venir y tú estás preparado!",
                "¡El límite lo pones tú, no te detengas hasta alcanzarlo!",
                "¡Cada esfuerzo cuenta, y cada uno te lleva más cerca de tus sueños!",
                "¡Estás haciendo un gran trabajo, sigue manteniendo ese nivel!",
                "¡Una actitud positiva trae resultados positivos, sigue cultivándola!",
                "¡No hay obstáculos, solo oportunidades disfrazadas de desafíos!",
                "¡Sigue adelante, tu esfuerzo es invaluable y está construyendo algo grande!",
                "¡El trabajo en equipo es la fórmula secreta del éxito!",
                "¡Nunca subestimes el poder de tu contribución, es el motor de nuestro progreso!",
                "¡Eres capaz de cosas increíbles, sigue sorprendiendo al mundo!",
                "¡Cada día es una nueva oportunidad para brillar, hazlo con todo tu corazón!",
                "¡El éxito es la combinación de preparación, trabajo duro y aprender de los errores!",
                "¡Trabaja duro y sé amable, la combinación perfecta para el éxito!",
                "¡Levántate y brilla, porque hoy tienes la oportunidad de ser grandioso!",
                "¡Recuerda que eres único, y esa es tu mayor fortaleza!",
                "¡No te preocupes por los fracasos, son solo peldaños hacia el éxito!",
                "¡Haz lo que amas y los resultados hablarán por sí solos!",
                "¡Hoy es el primer día del resto de tu vida, haz que cuente de verdad!",
                "¡El éxito es 1% inspiración y 99% acción, sigue adelante con determinación!"
                ];
            $mensajes_302484 = [
                "Oye, no te preocupes si hoy no das lo mejor de ti... todos estamos acostumbrados.",
                "Recuerda que sin tu aporte, este lugar sería exactamente igual.",
                "Si sigues así, pronto serás el rey del 'ya merito'.",
                "Tranquilo, nadie espera que rompas récords... ni siquiera los malos.",
                "Hoy no te esfuerces tanto, el mínimo esfuerzo ya es suficiente... como siempre.",
                "Lo bueno de tus errores es que nos mantienen entretenidos.",
                "Tu capacidad de procrastinar es realmente admirable... en otro contexto.",
                "Si algún día llegas a tiempo, te haremos un desfile... o al menos lo intentaremos.",
                "No te preocupes por hacerlo bien, siempre tenemos a alguien que lo arregle después.",
                "Tu habilidad para pasar desapercibido en las reuniones es legendaria.",
                "Sigue así y pronto serás la referencia de lo que no se debe hacer.",
                "¡Qué bueno que viniste hoy! ¡Ah, espera, es que era obligatorio!",
                "Tu eficiencia es inspiradora... para alguien con menos expectativas.",
                "Tranquilo, el que dijo que nadie es imprescindible claramente te conocía.",
                "Si el éxito se midiera en intentos fallidos, ya serías nuestro CEO."
            ];

            $id_empleado = $_SESSION['id_empleado'] ?? null;
            if ($id_empleado == 302484) {
                $mensajes = $mensajes_302484;
            } else {
                $mensajes = $mensajes_generales;
            }
            
            echo $mensajes[array_rand($mensajes)];
            ?>
        </div>
        <?php
        // Limpiar la sesión después de mostrar el mensaje
        session_unset();
        session_destroy();
        ?>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.com/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Enfocar el campo de entrada al cargar la página
            document.getElementById("id_empleado").focus();
        });
    </script>
</body>
</html>
