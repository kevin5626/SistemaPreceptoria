<?php
require_once __DIR__ . "/../Clases PHP/alumnoDAL.php";

$anio = trim($_GET['anio'] ?? '');
$division = trim($_GET['division'] ?? '');
$dni = trim($_GET['dni'] ?? '');
$nombre = trim($_GET['nombre'] ?? '');
$apellido = trim($_GET['apellido'] ?? '');
$nombreTutor = trim($_GET['nombre_tutor'] ?? '');
$apellidoTutor = trim($_GET['apellido_tutor'] ?? '');

$dal = new AlumnoDAL();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
    $dal->eliminarAlumno((int)$_POST['eliminar_id']);
    header('Location: VerDatosAlumnos.php');
    exit;
}
$alumnos = $dal->buscarAlumnos($anio, $division, $dni, $nombre, $apellido, $nombreTutor, $apellidoTutor);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar alumnos</title>
</head>
<body>
    <h2>Consultar alumnos</h2>
    <form method="get">
        <label>Año del curso: <input type="number" name="anio" value="<?php echo htmlspecialchars($anio, ENT_QUOTES, 'UTF-8'); ?>"></label>
        <label>División: <input type="number" name="division" value="<?php echo htmlspecialchars($division, ENT_QUOTES, 'UTF-8'); ?>"></label>
        <label>DNI: <input type="text" name="dni" value="<?php echo htmlspecialchars($dni, ENT_QUOTES, 'UTF-8'); ?>"></label>
        <label>Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>"></label>
        <label>Apellido: <input type="text" name="apellido" value="<?php echo htmlspecialchars($apellido, ENT_QUOTES, 'UTF-8'); ?>"></label>
        <label>Nombre del tutor: <input type="text" name="nombre_tutor" value="<?php echo htmlspecialchars($nombreTutor, ENT_QUOTES, 'UTF-8'); ?>"></label>
        <label>Apellido del tutor: <input type="text" name="apellido_tutor" value="<?php echo htmlspecialchars($apellidoTutor, ENT_QUOTES, 'UTF-8'); ?>"></label>
        <button type="submit">Buscar</button>
        <a href="VerDatosAlumnos.php">Mostrar todos</a>
    </form>

    <table border="1">
        <tr><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Año</th><th>División</th><th>Turno</th><th>Ciclo</th><th>Especialidad</th><th>Nombre del tutor</th><th>Apellido del tutor</th><th>Tipo de teléfono</th><th>Código de área</th><th>Número del tutor</th><th>Acción</th></tr>
        <?php foreach ($alumnos as $item): ?>
        <tr>
            <td><?php echo ($item->getNombre()); ?></td>
            <td><?php echo ($item->getApellido()); ?></td>
            <td><?php echo ((string)($item->getDni() ?? '')); ?></td>
            <td><?php echo htmlspecialchars((string)($item->getCursoAnio() ?? '')); ?></td>
            <td><?php echo htmlspecialchars((string)($item->getCursoDivision() ?? '')); ?></td>
            <td><?php echo htmlspecialchars($item->getCursoTurno(), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($item->getCursoCiclo(), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($item->getCursoEspecialidad(), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo ($item->getNombreTutor()); ?></td>
            <td><?php echo ($item->getApellidoTutor()); ?></td>
            <td><?php echo htmlspecialchars($item->getTipoTelefonoTutor(), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string)($item->getCodigoAreaTutor() ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string)($item->getNumeroTutor() ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
                <form method="post" onsubmit="return confirm('¿Eliminar este alumno de la base de datos?');">
                    <input type="hidden" name="eliminar_id" value="<?php echo (int)$item->getIdAlumno(); ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
