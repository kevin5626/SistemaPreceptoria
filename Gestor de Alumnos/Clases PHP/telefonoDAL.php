<?php
    require_once("telefono.php");
    require_once __DIR__ . '/../db_config.local.php';

    class TelefonoDAL {
        private $usuario = DB_USER;
        private $contrasena = DB_PASSWORD_OTROS;
        private $servidor = DB_SERVER;
        private $basededatos = DB_NAME;
    
        public function insertTelefono($telefono) {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $tipo = mysqli_real_escape_string($conexion, $telefono->getTipoTelefono());
            $consulta = sprintf("INSERT INTO telefonos (Tipo, CodigoArea, Numero, Id_Tutor) VALUES('%s', %d, %d, %d);",
                $tipo, $telefono->getCodigoArea(), $telefono->getNumero(), $telefono->getIdTutor1());

            mysqli_query($conexion, $consulta);

            $idTelefono = mysqli_insert_id($conexion);
            $telefono -> setIdTelefono($idTelefono);

            mysqli_close($conexion);
        }

        public function getTelefonos(): array {
            $conexion = mysqli_connect($this -> servidor, $this -> usuario, $this -> contrasena) or die ("Error al conectar: ");
            mysqli_set_charset($conexion, 'utf8');
            $baseDatos = mysqli_select_db($conexion, $this -> basededatos) or die ("Error seleccionar la BD: ");

            $consulta = (sprintf("SELECT * FROM telefonos"));
            $resultado = mysqli_query($conexion, $consulta);
            $registros = array();

            while($registro = mysqli_fetch_array($resultado)) {
                $telefono = new Telefono ($registro["Id_Telefono"], $registro["tipo_telefono"], $registro["codigo_area"], $registro["numero"], $registro["Id_Tutor"]);

                $registros[] = $telefono;
            } 
            
            mysqli_close($conexion);

            return $registros;
        }
    }
?>
