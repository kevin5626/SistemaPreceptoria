<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

require_once __DIR__ . '/curso.php';
require_once __DIR__ . '/cursoDAL.php';
require_once __DIR__ . '/alumno.php';
require_once __DIR__ . '/alumnoDAL.php';
require_once __DIR__ . '/tutor.php';
require_once __DIR__ . '/tutorDAL.php';
require_once __DIR__ . '/telefono.php';
require_once __DIR__ . '/telefonoDAL.php';

$curso = new Curso(null, (int)$_POST['anio'], (int)$_POST['division'], $_POST['comision'], $_POST['especialidad'], $_POST['turno'], $_POST['ciclo']);
(new CursoDAL())->insertCurso($curso);

$tutor = new Tutor(null, $_POST['nombre_tutor'], $_POST['apellido_tutor']);
(new TutorDAL())->insertTutor($tutor);

$alumno = new Alumno((int)$_POST['dni_alumno'], $_POST['nombre_alumno'], $_POST['apellido_alumno'], $curso->getIdCurso());
(new AlumnoDAL())->insertAlumno($alumno, $tutor->getIdTutor());

$telefono = new Telefono(null, $_POST['tipo_telefono'], (int)$_POST['codigo_area'], (int)$_POST['numero'], $tutor->getIdTutor());
(new TelefonoDAL())->insertTelefono($telefono);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Datos cargados</title></head>
<body>
    <h2>Los datos se cargaron correctamente</h2>
    <a href="index.html">Cargar otro alumno</a>
    <a href="../Pagina Web/VerDatosAlumnos.php">Ver alumnos</a>
</body>
</html>
