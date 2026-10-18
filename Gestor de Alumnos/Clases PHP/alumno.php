<?php
    class Alumno {
        private ?int $dni;
        private string $nombre;
        private string $apellido;
        private int $id_curso;
        private string $nombre_tutor;
        private string $apellido_tutor;
        private ?int $id_alumno;
        private ?int $curso_anio;
        private ?int $curso_division;
        private string $curso_turno;
        private string $curso_ciclo;
        private string $curso_especialidad;
        private string $tipo_telefono_tutor;
        private ?int $codigo_area_tutor;
        private ?int $numero_tutor;

        function __construct(?int $dni, string $nombre, string $apellido, int $id_curso, string $nombre_tutor = '', string $apellido_tutor = '', ?int $id_alumno = null, ?int $curso_anio = null, ?int $curso_division = null, string $curso_turno = '', string $curso_ciclo = '', string $curso_especialidad = '', string $tipo_telefono_tutor = '', ?int $codigo_area_tutor = null, ?int $numero_tutor = null) {
            $this -> dni = $dni;
            $this -> nombre = $nombre;
            $this -> apellido = $apellido;
            $this -> id_curso = $id_curso;
            $this -> nombre_tutor = $nombre_tutor;
            $this -> apellido_tutor = $apellido_tutor;
            $this -> id_alumno = $id_alumno;
            $this -> curso_anio = $curso_anio;
            $this -> curso_division = $curso_division;
            $this -> curso_turno = $curso_turno;
            $this -> curso_ciclo = $curso_ciclo;
            $this -> curso_especialidad = $curso_especialidad;
            $this -> tipo_telefono_tutor = $tipo_telefono_tutor;
            $this -> codigo_area_tutor = $codigo_area_tutor;
            $this -> numero_tutor = $numero_tutor;
        }
            
        public function getDni(): ?int {
            return $this -> dni;
        }

        public function getNombre(): string {
            return $this -> nombre;
        }
    
        public function getApellido(): string {
            return $this -> apellido;
        }
    
        public function getIdCurso1(): int {
            return $this -> id_curso;
        }

        public function getNombreTutor(): string {
            return $this -> nombre_tutor;
        }

        public function getApellidoTutor(): string {
            return $this -> apellido_tutor;
        }

        public function getIdAlumno(): ?int {
            return $this -> id_alumno;
        }

        public function getCursoAnio(): ?int {
            return $this -> curso_anio;
        }

        public function getCursoDivision(): ?int {
            return $this -> curso_division;
        }

        public function getCursoTurno(): string {
            return $this -> curso_turno;
        }

        public function getCursoCiclo(): string {
            return $this -> curso_ciclo;
        }

        public function getCursoEspecialidad(): string {
            return $this -> curso_especialidad;
        }

        public function getTipoTelefonoTutor(): string {
            return $this -> tipo_telefono_tutor;
        }

        public function getCodigoAreaTutor(): ?int {
            return $this -> codigo_area_tutor;
        }

        public function getNumeroTutor(): ?int {
            return $this -> numero_tutor;
        }

        public function setDni(int $dni): void {
            $this -> dni = $dni;
        }
        
        public function setNombre(string $nombre): void {
            $this -> nombre = $nombre;
        }

        public function setApellido(string $apellido): void {
            $this -> apellido = $apellido;
        }

        public function setIdCurso1(string $id_curso): void {
            $this -> id_curso = $id_curso;
        }
    }
?>
