<?php
require_once("alumnoDAL.php");

class Sistema {
    public function obtenerPorDni($dni) {
        $dalAlumno = new AlumnoDAL();
        return $dalAlumno->obtenerPorDni($dni);
    }

    public function obtenerPorNombreYApellido() {
        
    }

    public function obtenerPorCurso() {

    }   

    public function obtenerPorTutor() {

    }
}
?>