<?php
    require_once("Curso.php");
    require_once __DIR__ . '/../db_config.local.php';

    class CursoDAL {
        private $usuario = DB_USER;
        private $contrasena = DB_PASSWORD_OTROS;
        private $servidor = DB_SERVER;
        private $basededatos = DB_NAME;
    
        public function insertCurso($curso) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $comision = mysqli_real_escape_string($conexion, $curso->getComision());
            $especialidad = mysqli_real_escape_string($conexion, $curso->getEspecialidad());
            $turno = mysqli_real_escape_string($conexion, $curso->getTurno());
            $ciclo = mysqli_real_escape_string($conexion, $curso->getCiclo());
            $consulta = sprintf("SELECT Id_Curso FROM cursos WHERE `Año` = %d AND Division = %d AND `Comisión` = '%s' AND especialidad = '%s' AND Turno = '%s' AND ciclo = '%s' LIMIT 1",
                $curso->getAnio(), $curso->getDivision(), $comision, $especialidad, $turno, $ciclo);
            $resultado = mysqli_query($conexion, $consulta);

            if ($registro = mysqli_fetch_assoc($resultado)) {
                $curso->setIdCurso((int)$registro['Id_Curso']);
                mysqli_close($conexion);
                return;
            }

            $consulta = (sprintf("INSERT INTO cursos (`Año`, Division, `Comisión`, especialidad, Turno, ciclo) VALUES('%d', '%d', '%s', '%s', '%s', '%s');",
            $curso -> getAnio(), $curso -> getDivision(), $comision, $especialidad, $turno, $ciclo));

            mysqli_query($conexion, $consulta);

            $idCurso = mysqli_insert_id($conexion);
            $curso -> setIdCurso($idCurso);

            mysqli_close($conexion);
        }

        public function getCursos(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM cursos"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $curso = new Curso ($registro["Id_Curso"], $registro["Año"], $registro["Division"], $registro["Comisión"], $registro["especialidad"], $registro["Turno"], $registro["ciclo"]);

                $registros[] = $curso;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>
