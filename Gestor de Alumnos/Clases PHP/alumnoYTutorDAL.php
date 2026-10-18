<?php
    require_once("alumnoYTutor.php");
    require_once __DIR__ . '/../db_config.local.php';

    class AlumnoYTutorDAL {
        private $usuario = DB_USER;
        private $contrasena = DB_PASSWORD_OTROS;
        private $servidor = DB_SERVER;
        private $basededatos = DB_NAME;
    
        public function insertAlumnoYTutor($alumnoYTutor) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("INSERT INTO alumnosYTutores (dni, Id_Tutor) VALUES('%s', '%s');",
            $alumnoYTutor -> getDni(), $alumnoYTutor -> getIdTutor()));

            mysqli_query($conexion, $consulta);
            mysqli_close($conexion);
        }

        public function getAlumnosYTutores(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM alumnosYTutores"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $alumnoYTutor = new AlumnoYTutor ($registro["dni"], $registro["Id_Tutor"]);

                $registros[] = $alumnoYTutor;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>
