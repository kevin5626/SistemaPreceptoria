<?php
    require_once("alumno.php");

    class AlumnoDAL {
        private $usuario = 'root';
        private $contrasena = '1234';
        private $servidor = "localhost";
        private $basededatos = 'gestor_alumnos';
    
        public function insertAlumno($alumno) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("INSERT INTO alumnos (dni, nombre, apellido, Id_Curso) VALUES('%s', '%s', '%s', '%d');",
            $alumno -> getDni(), $alumno -> getNombre(), $alumno -> getApellido(), $alumno -> getIdCurso1()));

            mysqli_query($conexion, $consulta);
            mysqli_close($conexion);
        }

        public function getAlumnos(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM alumnos"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $alumno = new Alumno ($registro["dni"], $registro["nombre"], $registro["apellido"], $registro["Id_Curso"]);

                $registros[] = $alumno;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }

        public function obtenerPorDni($dni) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $dni = mysqli_real_escape_string($conexion, $dni);
            $consulta = sprintf("SELECT * FROM alumnos WHERE dni = '%s' LIMIT 1", $dni);
            $resultado = mysqli_query($conexion, $consulta);

            if (!$resultado || mysqli_num_rows($resultado) === 0) {
                mysqli_close($conexion);
                return null;
            }

            $registro = mysqli_fetch_assoc($resultado);
            $alumno = new Alumno((int)$registro["dni"], $registro["nombre"], $registro["apellido"], (int)$registro["Id_Curso"]);

            mysqli_close($conexion);
            return $alumno;
        }
    }
?>