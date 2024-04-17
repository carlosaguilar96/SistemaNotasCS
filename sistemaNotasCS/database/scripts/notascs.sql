CREATE DATABASE `notascs`
USE `notascs`;

CREATE TABLE `estudiante` (
  `NIE` int PRIMARY KEY NOT NULL,
  `carnet` varchar(10) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `sexo` int NOT NULL,
  `correo` varchar(250) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `estadoeliminacion` int NOT NULL,
  `estadoFinalizacion` int NOT NULL
);

CREATE TABLE `profesor` (
  `DUI` varchar(10) PRIMARY KEY NOT NULL,
  `carnet` varchar(100) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(125) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `estadoeliminacion` int NOT NULL
);

CREATE TABLE `etapa` (
  `idEtapa` int PRIMARY KEY AUTO_INCREMENT,
  `nombreEtapa` varchar(125) NOT NULL
);

INSERT INTO `etapa` (`nombreEtapa`) VALUES
('Tercer Ciclo'),
('Bachillerato General');

CREATE TABLE `grado` (
  `idGrado` int PRIMARY KEY AUTO_INCREMENT,
  `nombreGrado` varchar(125) NOT NULL,
  `idEtapa` int NOT NULL,
  FOREIGN KEY(`idEtapa`) REFERENCES `etapa`(`idEtapa`)
);

INSERT INTO `grado` (`nombreGrado`, `idEtapa`) VALUES
('Séptimo Grado',1),
('Octavo Grado',1),
('Noveno Grado',1),
('Primer Año',2),
('Segundo Año',2);

CREATE TABLE `detallegradoestudiante` (
  `idDetalle` int PRIMARY KEY AUTO_INCREMENT,
  `idGrado` int NOT NULL,
  `idEstudiante` int NOT NULL,
  `estadoFinalizacion` int NOT NULL,
  FOREIGN KEY(`idGrado`) REFERENCES `grado`(`idGrado`),
  FOREIGN KEY(`idEstudiante`) REFERENCES `estudiante`(`NIE`)
);

CREATE TABLE `usuarios` (
  `idUsuario` int PRIMARY KEY AUTO_INCREMENT,
  `usuario` varchar(250) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `contraseña` text NOT NULL,
  `nivel` int NOT NULL
);

CREATE TABLE `materia` (
  `idMateria` int PRIMARY KEY AUTO_INCREMENT,
  `nombreMateria` varchar(100) NOT NULL,
  `estadoeliminacion` int NOT NULL
)

INSERT INTO `materia` (`nombreMateria`) VALUES
('Lenguaje y Literatura'),
('Matemática'),
('Ciencia, Salud y Medio Ambiente'),
('Estudios Sociales y Cívica'),
('Inglés'),
('Informática'),
('Educación Física'),
('Educación en Valores'),
('Ciencias Físicas'),
('Ciencias Biológicas'),
('Orientación para la Vida'),
('Seminario'),
('Emprendedurismo'),
('Laboratorio de Creatividad'),
('Dibujo Técnico'),
('Proyecto de Graduación'),
('Mercadeo'),
('Matemática Pre Universitaria');

CREATE TABLE `detalleprofesormateria` (
  `idDetalle` int PRIMARY KEY AUTO_INCREMENT,
  `idProfesor` varchar(10) NOT NULL,
  `idMateria` int NOT NULL,
  FOREIGN KEY(`idProfesor`) REFERENCES `profesor`(`DUI`),
  FOREIGN KEY(`idMateria`) REFERENCES `materia`(`idMateria`)
);

CREATE TABLE `administrador` (
  `DUI` varchar(10) PRIMARY KEY NOT NULL,
  `carnet` varchar(100) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(125) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `estadoeliminacion` int NOT NULL
);

CREATE TABLE `detallegradomateria` (
  `idDetalle` int PRIMARY KEY AUTO_INCREMENT,
  `idGrado` int NOT NULL,
  `idMateria` int NOT NULL,
  FOREIGN KEY(`idGrado`) REFERENCES `grado`(`idGrado`),
  FOREIGN KEY(`idMateria`) REFERENCES `materia`(`idMateria`)
);

INSERT INTO `detallegradomateria` (`idGrado`,`idMateria`) VALUES
('1','1'),
('1','2'),
('1','3'),
('1','4'),
('1','5'),
('1','6'),
('1','7'),
('1','8'),
('2','1'),
('2','2'),
('2','3'),
('2','4'),
('2','5'),
('2','6'),
('2','7'),
('2','8'),
('3','1'),
('3','2'),
('3','3'),
('3','4'),
('3','5'),
('3','6'),
('3','7'),
('3','8'),
('4','1'),
('4','2'),
('4','9'),
('4','10'),
('4','4'),
('4','5'),
('4','6'),
('4','11'),
('4','12'),
('4','13'),
('4','14'),
('4','7'),
('4','15'),
('4','8'),
('5','1'),
('5','2'),
('5','9'),
('5','10'),
('5','4'),
('5','5'),
('5','6'),
('5','11'),
('5','16'),
('5','14'),
('5','17'),
('5','7'),
('5','15'),
('5','18');

CREATE TABLE `añoEscolar` (
  `idAño` int PRIMARY KEY AUTO_INCREMENT,
  `nombreAño` int NOT NULL,
  `estadoFinalizacion` int NOT NULL
);

CREATE TABLE `periodos` (
  `idPeriodo` int PRIMARY KEY AUTO_INCREMENT,
  `nombrePeriodo` varchar(100) NOT NULL,
  `estado` int NOT NULL
);

INSERT INTO `periodos` (`nombrePeriodo`,`estado`) VALUES
('Periodo I',0),
('Periodo II',0),
('Periodo III',0),
('Periodo IV',0);

CREATE TABLE `secciones` (
  `idSeccion` int PRIMARY KEY AUTO_INCREMENT,
  `nombreSeccion` varchar(100) NOT NULL,
  `encargado` varchar(10) NOT NULL,
  `idGrado` int NOT NULL,
  `idAño` int NOT NULL,
  `estadoeliminacion` int NOT NULL,
  FOREIGN KEY(`encargado`) REFERENCES `profesor`(`DUI`),
  FOREIGN KEY(`idGrado`) REFERENCES `grado`(`idGrado`),
  FOREIGN KEY(`idAño`) REFERENCES `añoEscolar`(`idAño`)
);

CREATE TABLE `detalleSeccionMateriaProfesor` (
  `idDetalle` int PRIMARY KEY AUTO_INCREMENT,
  `idProfesor` varchar(100) NOT NULL,
  `idSeccion` int NOT NULL,
  `idMateria` int NOT NULL,
  FOREIGN KEY(`idProfesor`) REFERENCES `profesor`(`DUI`),
  FOREIGN KEY(`idSeccion`) REFERENCES `secciones`(`idSeccion`),
  FOREIGN KEY(`idMateria`) REFERENCES `materia`(`idMateria`)
);

CREATE TABLE `detalleSeccionEstudiante` (
  `idDetalle` int PRIMARY KEY AUTO_INCREMENT,
  `idEstudiante` int NOT NULL,
  `idSeccion` int NOT NULL,
  FOREIGN KEY(`idEstudiante`) REFERENCES `estudiante`(`NIE`),
  FOREIGN KEY(`idSeccion`) REFERENCES `secciones`(`idSeccion`)
);

CREATE TABLE `detalleSeccionMateria` (
  `idDetalle` int PRIMARY KEY AUTO_INCREMENT,
  `idSeccion` int NOT NULL,
  `idMateria` int NOT NULL,
  `idProfesor` varchar(100),
  FOREIGN KEY(`idSeccion`) REFERENCES `secciones`(`idSeccion`),
  FOREIGN KEY(`idMateria`) REFERENCES `materia`(`idMateria`),
  FOREIGN KEY(`idProfesor`) REFERENCES `profesor`(`DUI`)
);

CREATE TABLE `Evaluacion` (
  `idEvaluacion` int PRIMARY KEY AUTO_INCREMENT,
  `nombreEvaluacion` varchar(100) NOT NULL,
  `idDetalle` int NOT NULL,
  `porcentaje` int NOT NULL,
  FOREIGN KEY(`idDetalle`) REFERENCES `detalleSeccionMateria`(`idDetalle`)
);

CREATE TABLE `Nota` (
  `idNota` int PRIMARY KEY AUTO_INCREMENT,
  `idEstudiante` int NOT NULL,
  `idEvaluacion` int NOT NULL,
  `nota` float NOT NULL,
  FOREIGN KEY(`idEstudiante`) REFERENCES `estudiante`(`NIE`),
  FOREIGN KEY(`idEvaluacion`) REFERENCES `Evaluacion`(`idEvaluacion`)
);