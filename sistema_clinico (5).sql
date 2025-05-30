-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2025 a las 16:53:30
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_clinico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `idarea` int(11) NOT NULL,
  `area` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`idarea`, `area`) VALUES
(1, 'fisica'),
(2, 'psicologica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialistas`
--

CREATE TABLE `especialistas` (
  `idespecialista` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idarea` int(11) NOT NULL,
  `idsubarea` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialistas`
--

INSERT INTO `especialistas` (`idespecialista`, `idusuario`, `idarea`, `idsubarea`) VALUES
(1, 4, 1, NULL),
(12, 19, 2, 11),
(13, 22, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idestado` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`idestado`, `estado`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `idhorario` int(11) NOT NULL,
  `idespecialista` int(11) NOT NULL,
  `dia_semana` varchar(20) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idrol`, `rol`) VALUES
(1, 'SuperUsuario'),
(2, 'C.General'),
(3, 'Especialista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subareas`
--

CREATE TABLE `subareas` (
  `idsubarea` int(11) NOT NULL,
  `subarea` varchar(50) NOT NULL,
  `idarea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subareas`
--

INSERT INTO `subareas` (`idsubarea`, `subarea`, `idarea`) VALUES
(1, 'conductual', 2),
(11, 'Lenguaje', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `idestado` int(11) DEFAULT NULL,
  `idrol` int(11) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombres`, `apellidos`, `dni`, `telefono`, `correo`, `idestado`, `idrol`, `usuario`, `password`) VALUES
(1, 'Miguel Angel', 'Cáceres Cubas ', '73256481', '922157739', 'contacto@corazonguerrero.org.pe', 1, 1, 'gftunquet14', '$2y$10$N8cWJdoccVWLJNfyuc98AuMXpG/yMi/eVFwgIeWebSuf3kd0Cqhk.'),
(3, 'Vanessa', '22', '12345678', '922157739', 'contacto@corazonguerrero.org.pe2', 1, 2, 'vanessa', '$2y$10$z5Wg/.HcCgoKdQEsBqkwOeNDdWPHXHU1Ya9Mrg4Q5yuvZbYSie9py'),
(4, 'Andy', 'orellana', '12121212', '123456789', 'andy@gmail.com', 1, 3, 'andy', '$2y$10$z5Wg/.HcCgoKdQEsBqkwOeNDdWPHXHU1Ya9Mrg4Q5yuvZbYSie9py'),
(5, 'Diana', 'castro', '71524351', '955768525', 'di@gmail.com', 1, 3, 'luciani175', '$2y$10$SZtJZ1tI4/AKBGixY3q78.nU0fclk3Cskz9A4PbrMuiSgIOo181p6'),
(6, 'Karol', 'mendez', '73685739', '955768524', 'jes@gmail.com', 1, 3, 'luciani604', '$2y$10$Y6o0d.4sqQpqfQnx7gc77.ayBQUL8HtcSWPUUu3lgrOXEYqeV2JX6'),
(7, 'valeria', 'nuñez', '82937145', '955768524', 'vale@gmail.com', 2, 3, 'valeria204', '$2y$10$.7Zui7Nsxy5aj/LUCnVpR.Uw.MzCtRXwwokwxlaZCAuhQRS9GoiLu'),
(8, 'jose', 'jimenez', '74123654', '955768525', 'luciani@gmail.com', 2, 3, 'jose223', '$2y$10$O6rYD2Npjo2YRAqp8L6hGuv6wJfS7PnuEnYayB784vMJW1UCikvwq'),
(9, 'gustavo', 'tunque', '75684642', '942565804', 'gustavo@gmail.com', 2, 3, 'gustavo745', '$2y$10$mCiiPRFG//WtO3s/XngVDOBIRUX/kJUYSnUe1tPYN.nHV3.dhBZsy'),
(11, 'LUCIANI', 'JIMENEZ FERNANDEZ', '73685732', '955768525', 'jime@gmail.com', 2, 3, 'luciani570', '$2y$10$KCYjFkeGgkt4pKdl69I3oeyN6wavsoWOuJELFVG2.wC4a2aZx9NcG'),
(12, 'katy', 'jjji', '12345614', '955768525', 'juliogerar2022@gmail.com', 2, 3, 'katy238', '$2y$10$XozM9KV/NjwkaUCEQAL7Bur7Vmo0mDGyryaGOzU1DivT1kigaYLxW'),
(13, 'Rossy', 'peralta', '73685731', '955768527', 'rosy29102003@gmail.com', 1, 3, 'rossy675', '$2y$10$onP.NyQ.3ltpuCJhQ84.Nux7ki1ZVBv.4P296l.jMIoRvK1ZSJZ9u'),
(14, 'maria', 'fernandez', '78542100', '957568525', 'mar102003@gmail.com', 2, 3, 'maria306', '$2y$10$mXxrRO1N8hCzIw6at/9qm.hU4zLk43mezXDhcA./KEWjfKIFJhgO6'),
(15, 'ander', 'medina', '12345611', '955768525', '9102003@gmail.com', 1, 3, 'ander818', '$2y$10$dBqIkTJ8zf2K9xO03UdRpejxrHS5lc7Jzec2nwR2pMV9pTjXkw7na'),
(19, 'lucaini', 'jimenez', '73685741', '955768525', 'luciani29102003@gmail.com', 1, 3, 'lucaini122', '$2y$10$mfipvQ4C2sIwkrGNxS9FO.vN3CUL6zPRtrE3e8QA7jhwa1gzEX1He'),
(22, 'LUCIANI JESUS', 'JIMENEZ', '12345664', '955768525', 'lu2003@gmail.com', 2, 3, 'luciani254', '$2y$10$FAxDS0miQl.1GHXvhE5HKOtc8T2VIbTXRUTvq1NZdpSxLDzFOmZNG');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`idarea`);

--
-- Indices de la tabla `especialistas`
--
ALTER TABLE `especialistas`
  ADD PRIMARY KEY (`idespecialista`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idarea` (`idarea`),
  ADD KEY `idsubarea` (`idsubarea`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`idestado`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`idhorario`),
  ADD KEY `idx_idespecialista` (`idespecialista`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `subareas`
--
ALTER TABLE `subareas`
  ADD PRIMARY KEY (`idsubarea`),
  ADD KEY `fk_area` (`idarea`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `idestado` (`idestado`),
  ADD KEY `idrol` (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `idarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `especialistas`
--
ALTER TABLE `especialistas`
  MODIFY `idespecialista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `idestado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `idhorario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `subareas`
--
ALTER TABLE `subareas`
  MODIFY `idsubarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `especialistas`
--
ALTER TABLE `especialistas`
  ADD CONSTRAINT `especialistas_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`),
  ADD CONSTRAINT `especialistas_ibfk_2` FOREIGN KEY (`idarea`) REFERENCES `areas` (`idarea`),
  ADD CONSTRAINT `especialistas_ibfk_3` FOREIGN KEY (`idsubarea`) REFERENCES `subareas` (`idsubarea`);

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horarios_especialista` FOREIGN KEY (`idespecialista`) REFERENCES `especialistas` (`idespecialista`) ON DELETE CASCADE;

--
-- Filtros para la tabla `subareas`
--
ALTER TABLE `subareas`
  ADD CONSTRAINT `fk_area` FOREIGN KEY (`idarea`) REFERENCES `areas` (`idarea`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idestado`) REFERENCES `estados` (`idestado`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`idrol`) REFERENCES `roles` (`idrol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
