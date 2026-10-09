<?php
require_once("../Clases PHP/Sistema.php");

$sistema = new Sistema();
$alumno = $sistema->obtenerPorDni($_POST["dni"]);

if ($alumno) {
    echo $alumno->getNombre() . " " . $alumno->getApellido();
} else {
    echo "No existe";
}