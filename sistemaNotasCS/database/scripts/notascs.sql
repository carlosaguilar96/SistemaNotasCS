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
  `nombre` int NOT NULL,
  `estadoFinalizacion` int NOT NULL
);




/*-- --------------------------------------------------------

--
-- Table structure for table `mes`
--

CREATE TABLE `mes` (
  `idMes` int(10) NOT NULL,
  `mes` int(11) NOT NULL,
  `idPeriodo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notas`
--

CREATE TABLE `notas` (
  `idNotas` int(10) NOT NULL,
  `actividad1` decimal(10,1) NOT NULL,
  `actividad2` decimal(10,1) NOT NULL,
  `actividad3` decimal(10,1) NOT NULL,
  `actividad4` decimal(10,1) NOT NULL,
  `actividad5` decimal(10,1) NOT NULL,
  `laboratorio` decimal(10,1) NOT NULL,
  `pruebaObjetiva` decimal(10,1) NOT NULL,
  `promedioMensual` decimal(10,1) NOT NULL,
  `promedioAnual` decimal(10,1) NOT NULL,
  `notaExtraoridinaria` decimal(10,1) NOT NULL,
  `idMes` int(10) NOT NULL,
  `idMateria` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `periodo`
--

CREATE TABLE `periodo` (
  `idPeriodo` int(10) NOT NULL,
  `periodo` int(2) NOT NULL,
  `idCiclo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profesor`
--



-- --------------------------------------------------------

--
-- Table structure for table `seccion`
--

CREATE TABLE `seccion` (
  `idSeccion` varchar(6) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Indexes for dumped tables
--

--
-- Indexes for table `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`DUI`);

--
-- Indexes for table `añoacademico`
--
ALTER TABLE `añoacademico`
  ADD PRIMARY KEY (`idAño`);

--
-- Indexes for table `ciclo`
--
ALTER TABLE `ciclo`
  ADD PRIMARY KEY (`idCiclo`);

--
-- Indexes for table `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`NIE`),
  ADD KEY `fk_estudiante_seccion` (`idSeccion`);

--
-- Indexes for table `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`idMateria`),
  ADD KEY `fk_materia_seccion` (`idSeccion`);

--
-- Indexes for table `mes`
--
ALTER TABLE `mes`
  ADD PRIMARY KEY (`idMes`),
  ADD KEY `fk_mes_periodo` (`idPeriodo`);

--
-- Indexes for table `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`idNotas`),
  ADD KEY `fk_notas_mes` (`idMes`),
  ADD KEY `fk_notas_materia` (`idMateria`);

--
-- Indexes for table `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`idPeriodo`),
  ADD KEY `fk_periodo_ciclo` (`idCiclo`);

--
-- Indexes for table `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`DUI`),
  ADD KEY `fk_profesor_seccion` (`idSeccion`);

--
-- Indexes for table `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`idSeccion`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudiante_seccion` FOREIGN KEY (`idSeccion`) REFERENCES `seccion` (`idSeccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `fk_materia_seccion` FOREIGN KEY (`idSeccion`) REFERENCES `seccion` (`idSeccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mes`
--
ALTER TABLE `mes`
  ADD CONSTRAINT `fk_mes_periodo` FOREIGN KEY (`idPeriodo`) REFERENCES `periodo` (`idPeriodo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `fk_notas_materia` FOREIGN KEY (`idMateria`) REFERENCES `materia` (`idMateria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notas_mes` FOREIGN KEY (`idMes`) REFERENCES `mes` (`idMes`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `periodo`
--
ALTER TABLE `periodo`
  ADD CONSTRAINT `fk_periodo_ciclo` FOREIGN KEY (`idCiclo`) REFERENCES `ciclo` (`idCiclo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `fk_profesor_seccion` FOREIGN KEY (`idSeccion`) REFERENCES `seccion` (`idSeccion`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;*/
