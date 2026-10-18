<?php
    require_once("tutor.php");
    require_once __DIR__ . '/../db_config.local.php';

    class TutorDAL {
        private $usuario = DB_USER;
        private $contrasena = DB_PASSWORD_OTROS;
        private $servidor = DB_SERVER;
        private $basededatos = DB_NAME;
    
        public function insertTutor($tutor) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $nombre = mysqli_real_escape_string($conexion, $tutor->getNombre());
            $apellido = mysqli_real_escape_string($conexion, $tutor->getApellido());
            $consulta = sprintf("SELECT Id_Tutor FROM tutores WHERE Nombre = '%s' AND Apellido = '%s' LIMIT 1", $nombre, $apellido);
            $resultado = mysqli_query($conexion, $consulta);

            if ($registro = mysqli_fetch_assoc($resultado)) {
                $tutor->setIdTutor((int)$registro['Id_Tutor']);
                mysqli_close($conexion);
                return;
            }

            $consulta = sprintf("INSERT INTO tutores (Nombre, Apellido) VALUES('%s', '%s');", $nombre, $apellido);

            mysqli_query($conexion, $consulta);

            $idTutor = mysqli_insert_id($conexion);
            $tutor -> setIdTutor($idTutor);
            
            mysqli_close($conexion);
        }

        public function getTutores(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM tutores"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $tutor = new Tutor ($registro["Id_Tutor"], $registro["nombre"], $registro["apellido"]);

                $registros[] = $tutor;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>
