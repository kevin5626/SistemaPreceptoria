<?php
    require_once("alumno.php");
    require_once __DIR__ . '/../db_config.local.php';

    class AlumnoDAL {
        private $usuario = DB_USER;
        private $contrasena = DB_PASSWORD_ALUMNO;
        private $servidor = DB_SERVER;
        private $basededatos = DB_NAME;
    
        public function insertAlumno($alumno, $idTutor) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $dni = mysqli_real_escape_string($conexion, (string)$alumno->getDni());
            $nombre = mysqli_real_escape_string($conexion, $alumno->getNombre());
            $apellido = mysqli_real_escape_string($conexion, $alumno->getApellido());
            $consulta = sprintf("INSERT INTO estudiantes (DNI, Nombre, Apellido, Id_Curso, Id_Tutor) VALUES('%s', '%s', '%s', %d, %d);",
                $dni, $nombre, $apellido, $alumno->getIdCurso1(), (int)$idTutor);

            mysqli_query($conexion, $consulta);
            mysqli_close($conexion);
        }

        public function getAlumnos(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = "SELECT DNI AS dni, Nombre AS nombre, Apellido AS apellido, Id_Curso FROM estudiantes";
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $alumno = new Alumno ($registro["dni"], $registro["nombre"], $registro["apellido"], $registro["Id_Curso"]);

                $registros[] = $alumno;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }

        public function buscarAlumnos($curso, $division, $dni, $nombre, $apellido, $nombreTutor, $apellidoTutor): array {
            $conexion = mysqli_connect($this->servidor, $this->usuario, $this->contrasena) or die("Error al conectar");
            mysqli_set_charset($conexion, 'utf8');
            mysqli_select_db($conexion, $this->basededatos) or die("Error al seleccionar la base de datos");

            $consulta = "SELECT DISTINCT e.Id_Estudiante, e.DNI AS dni, e.Nombre AS nombre, e.Apellido AS apellido, e.Id_Curso, c.`Año` AS curso_anio, c.Division AS curso_division, c.Turno AS curso_turno, c.ciclo AS curso_ciclo, c.especialidad AS curso_especialidad, t.Nombre AS tutor_nombre, t.Apellido AS tutor_apellido, tel.Tipo AS telefono_tipo, tel.CodigoArea AS telefono_codigo_area, tel.Numero AS telefono_numero FROM estudiantes e LEFT JOIN tutores t ON e.Id_Tutor = t.Id_Tutor LEFT JOIN telefonos tel ON t.Id_Tutor = tel.Id_Tutor LEFT JOIN cursos c ON e.Id_Curso = c.Id_Curso";
            $condiciones = array();

            if ($curso !== '') {
                $condiciones[] = "c.`Año` = " . (int)$curso;
            }
            if ($division !== '') {
                $condiciones[] = "c.Division = " . (int)$division;
            }
            if ($dni !== '') {
                $dni = mysqli_real_escape_string($conexion, $dni);
                $condiciones[] = "e.DNI = '$dni'";
            }
            if ($nombre !== '') {
                $nombre = mysqli_real_escape_string($conexion, $nombre);
                $condiciones[] = "e.Nombre LIKE '%$nombre%'";
            }
            if ($apellido !== '') {
                $apellido = mysqli_real_escape_string($conexion, $apellido);
                $condiciones[] = "e.Apellido LIKE '%$apellido%'";
            }
            if ($nombreTutor !== '') {
                $nombreTutor = mysqli_real_escape_string($conexion, $nombreTutor);
                $condiciones[] = "t.Nombre LIKE '%$nombreTutor%'";
            }
            if ($apellidoTutor !== '') {
                $apellidoTutor = mysqli_real_escape_string($conexion, $apellidoTutor);
                $condiciones[] = "t.Apellido LIKE '%$apellidoTutor%'";
            }
            if (count($condiciones) > 0) {
                $consulta .= " WHERE " . implode(" AND ", $condiciones);
            }

            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();
            while ($registro = mysqli_fetch_assoc($resultado)) {
                $registros[] = new Alumno($registro['dni'], $registro['nombre'], $registro['apellido'], $registro['Id_Curso'], $registro['tutor_nombre'] ?? '', $registro['tutor_apellido'] ?? '', (int)$registro['Id_Estudiante'], $registro['curso_anio'] === null ? null : (int)$registro['curso_anio'], $registro['curso_division'] === null ? null : (int)$registro['curso_division'], $registro['curso_turno'] ?? '', $registro['curso_ciclo'] ?? '', $registro['curso_especialidad'] ?? '', $registro['telefono_tipo'] ?? '', $registro['telefono_codigo_area'] === null ? null : (int)$registro['telefono_codigo_area'], $registro['telefono_numero'] === null ? null : (int)$registro['telefono_numero']);
            }
            mysqli_close($conexion);
            return $registros;
        }

        public function eliminarAlumno(int $idAlumno): void {
            $conexion = mysqli_connect($this->servidor, $this->usuario, $this->contrasena) or die("Error al conectar");
            mysqli_set_charset($conexion, 'utf8');
            mysqli_select_db($conexion, $this->basededatos) or die("Error al seleccionar la base de datos");
            $idAlumno = (int)$idAlumno;
            mysqli_query($conexion, "DELETE FROM estudianteTutor WHERE Id_Estudiante = $idAlumno");
            mysqli_query($conexion, "DELETE FROM estudiantes WHERE Id_Estudiante = $idAlumno");
            mysqli_close($conexion);
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
