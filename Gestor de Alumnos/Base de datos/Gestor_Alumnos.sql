DROP DATABASE IF EXISTS gestor_alumnos;
CREATE DATABASE gestor_alumnos;
USE gestor_alumnos;

CREATE TABLE tutores(
  Id_Tutor INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(25) NULL,
  Apellido VARCHAR(25) NULL,
  PRIMARY KEY (Id_Tutor)
);

CREATE TABLE cursos(
  Id_Curso INT NOT NULL AUTO_INCREMENT,
  Año INT NULL,
  Division INT NULL,
  Comisión VARCHAR(10),
  especialidad VARCHAR(30),
  ciclo VARCHAR(20),
  PRIMARY KEY (Id_Curso)
);

CREATE TABLE estudiantes(
  Id_Estudiante INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(25) NULL,
  Apellido VARCHAR(25) NULL,
  Id_Curso INT NULL, 
  Id_Tutor INT NOT NULL,
  PRIMARY KEY (Id_Estudiante),
  CONSTRAINT fk_estudiante_tutor
  FOREIGN KEY (Id_Tutor) REFERENCES tutores (Id_Tutor),
  CONSTRAINT fk_estudiante_curso
  FOREIGN KEY (Id_Curso) REFERENCES cursos (Id_Curso) 
);
 
CREATE TABLE telefonos(
  Id_Telefono INT NOT NULL AUTO_INCREMENT,
  CodigoArea INT NULL,
  Tipo VARCHAR(20) NULL,
  Numero INT NULL,
  Id_Tutor INT NULL,
  PRIMARY KEY (Id_Telefono),
  CONSTRAINT fk_telefono_tutor
  FOREIGN KEY (Id_Tutor) REFERENCES tutores (Id_Tutor) 
);
  
CREATE TABLE estudianteTutor(
  Id_Estudiante INT NOT NULL,
  Id_Tutor INT NOT NULL,
  CONSTRAINT fk_estudiantetutor_tutor
  FOREIGN KEY (Id_Tutor) REFERENCES tutores (Id_Tutor),
  CONSTRAINT fk_estudiantetutor_estudiante
  FOREIGN KEY (Id_Estudiante) REFERENCES estudiantes (Id_Estudiante)
);
  
INSERT INTO cursos (Año, Division, Comisión, especialidad, ciclo)
VALUES (5, 2, '522', 'programacion', 'superior');
  
INSERT INTO tutores (Id_Tutor, Nombre, Apellido)
VALUES (1, 'juan', 'rios');
  
INSERT INTO estudiantes (Nombre, Apellido, Id_curso, Id_Tutor)
VALUES ('facundo', 'rios', 1 , 1);
  
INSERT INTO telefonos (Id_Telefono, CodigoArea, Tipo, Numero)
VALUES (1, 11, 'celular', 34593475);

SELECT * FROM tutores;
SELECT * FROM telefonos;
SELECT * FROM estudiantes;  
SELECT * FROM cursos;