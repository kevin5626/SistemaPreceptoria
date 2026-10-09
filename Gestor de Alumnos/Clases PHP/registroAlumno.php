<?php
$dni_alumno = $_POST['dni_alumno'];
$nombre_alumno = $_POST['nombre_alumno'];
$apellido_alumno = $_POST['apellido_alumno'];

$anio = $_POST['anio'];
$division = $_POST['division'];
$comision = $_POST['comision'];
$especialidad = $_POST['especialidad'];
$turno = $_POST['turno'];
$ciclo = $_POST['ciclo'];

$nombre_tutor = $_POST['nombre_tutor'];
$apellido_tutor = $_POST['apellido_tutor'];

$tipo_telefono = $_POST['tipo_telefono'];
$codigo_area = $_POST['codigo_area'];
$numero = $_POST['numero'];

require_once("curso.php");
require_once("cursoDAL.php");

require_once("alumno.php");
require_once("alumnoDAL.php");

require_once("tutor.php");
require_once("tutorDAL.php");

require_once("telefono.php");
require_once("telefonoDAL.php");

require_once("alumnoYTutor.php");
require_once("alumnoYTutorDAL.php");

$dalCurso = new CursoDAL();
$dalAlumno = new AlumnoDal();
$dalTutor = new TutorDal();
$dalTelefono = new TelefonoDAL();
$dalAlumnoYTutor = new AlumnoYTutorDAL();

// Ingreso de Curso
$curso = new Curso(null, $anio, $division, $comision, $especialidad, $turno, $ciclo);
$dalCurso -> insertCurso($curso);

// $cursosArray = $dalCurso -> getCursos();
// echo "Array: " .count($cursosArray), "\n";

// foreach($cursosArray as $item) {
//     echo $item -> getIdCurso(). " ". $item -> getAnio(). " " .$item -> getDivision(). " ". $item -> getComision() . " ". $item -> getEspecialidad() . " ". $item -> getTurno(). " ". $item -> getCiclo() ."\n";
// }

// Ingreso de Alumno
$alumno = new Alumno($dni_alumno, $nombre_alumno, $apellido_alumno, $curso -> getIdCurso());
$dalAlumno -> insertAlumno($alumno);

// Ingreso de Tutor
$tutor = new Tutor(null, $nombre_tutor, $apellido_tutor);
$dalTutor -> insertTutor($tutor);

// Ingreso de Telefono
$telefono = new Telefono(null, $tipo_telefono, $codigo_area, $numero, $tutor -> getIdTutor());
$dalTelefono -> insertTelefono($telefono);

// Ingreso de Alumno y Tutor
$alumnoYTutor = new AlumnoYTutor($alumno -> getDni(), $tutor -> getIdTutor());
$dalAlumnoYTutor -> insertAlumnoYTutor($alumnoYTutor);
?>