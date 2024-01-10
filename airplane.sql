-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-01-2024 a las 05:47:17
-- Versión del servidor: 8.0.32
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `airplane`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `aerDisponibles` (IN `id_aerp` VARCHAR(6))   BEGIN
SELECT compañia_vuelo.ID FROM compañia_vuelo INNER JOIN aerop_comp ON id_comp = compañia_vuelo.ID WHERE id_aerop = id_aerp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `despegar` ()   BEGIN
    UPDATE vuelo SET estado = "EN VUELO" WHERE NOW() > CONCAT(fecha_salida, ' ', hora_salida) AND TIMESTAMPADD(HOUR, HOUR(tiempo), TIMESTAMPADD(MINUTE, MINUTE(tiempo), TIMESTAMP(fecha_salida, hora_salida))) > NOW() AND estado != "CANCELADO";
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateVuelos` ()   BEGIN
UPDATE vuelo SET estado = "FINALIZADO" WHERE TIMESTAMPADD(HOUR, HOUR(tiempo), TIMESTAMPADD(MINUTE, MINUTE(tiempo), TIMESTAMP(fecha_salida, hora_salida))) < NOW() AND estado != "CANCELADO";
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aeropuerto`
--

CREATE TABLE `aeropuerto` (
  `ID` varchar(6) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `id_lugar` varchar(6) NOT NULL,
  `capacidad_aviones` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `aeropuerto`
--

INSERT INTO `aeropuerto` (`ID`, `Nombre`, `id_lugar`, `capacidad_aviones`) VALUES
('21A15F', 'EjemploKoln', '123b34', 0),
('8AB002', 'AeroRamirilux', '7q8r9s', 0),
('A10001', 'Aeropuerto Internacional', '234512', 0),
('B20002', 'Aeropuerto Nacional', '24hj31', 0),
('C30003', 'Aeropuerto Celestial', 'a1342k', 0),
('D40004', 'Nube Esmeralda', 'j43256', 0),
('E42E56', 'EjemploKoln', '123b34', 0),
('E50005', 'Aeródromo Aurora', '234512', 0),
('FDB44B', 'FerLine', '24hj31', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avion`
--

CREATE TABLE `avion` (
  `ID` varchar(6) NOT NULL,
  `Capacidad` int NOT NULL,
  `id_comp_vuelo` varchar(6) NOT NULL,
  `id_aeropuerto` varchar(6) DEFAULT NULL,
  `disponible` int NOT NULL DEFAULT '1',
  `SN` varchar(25) NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `totalCap` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `avion`
--

INSERT INTO `avion` (`ID`, `Capacidad`, `id_comp_vuelo`, `id_aeropuerto`, `disponible`, `SN`, `estado`, `totalCap`) VALUES
('2936F8', 76, '124356', NULL, 1, '65435457', 1, 85),
('3915AC', 45, '124356', NULL, 1, '4235656', 0, 45),
('5186A0', 77, '124356', NULL, 1, '345783245', 1, 77),
('784BBD', 0, '5BD7D2', NULL, 1, '632456134', 1, 100),
('7C90FD', -112, '124356', NULL, 1, '7657643557', 1, 100),
('99E55E', -40, '124356', NULL, 1, '7654456', 1, 60),
('B3802C', 55, '124356', NULL, 1, '35234', 0, 55),
('EA7338', 54, '124356', NULL, 1, '4235427', 1, 54);

--
-- Disparadores `avion`
--
DELIMITER $$
CREATE TRIGGER `addAvion` AFTER INSERT ON `avion` FOR EACH ROW BEGIN
    UPDATE compañia_vuelo
    SET aviones = aviones + 1
    WHERE ID = NEW.id_comp_vuelo;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `dropAvion` AFTER UPDATE ON `avion` FOR EACH ROW BEGIN
	UPDATE compañia_vuelo
    SET aviones = (SELECT COUNT(ID) FROM avion WHERE estado = 1 AND id_comp_vuelo = OLD.id_comp_vuelo)
    WHERE ID = OLD.id_comp_vuelo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compañia_vuelo`
--

CREATE TABLE `compañia_vuelo` (
  `ID` varchar(6) NOT NULL,
  `Nombre` varchar(99) NOT NULL,
  `aviones` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `compañia_vuelo`
--

INSERT INTO `compañia_vuelo` (`ID`, `Nombre`, `aviones`) VALUES
('124356', 'Celeste Air', 5),
('5BD7D2', 'Mexiquito', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

CREATE TABLE `forma_pago` (
  `ID` int NOT NULL,
  `Forma` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

CREATE TABLE `lugar` (
  `ID` varchar(6) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `lugar`
--

INSERT INTO `lugar` (`ID`, `ciudad`, `pais`) VALUES
('123b34', 'Koln', 'Alemania'),
('1a2b3c', 'Nueva York', 'Estados Unidos'),
('1b2c3d', 'Ciudad del Cabo', 'Sudáfrica'),
('1c2d3e', 'CDMX', 'México'),
('1j2k3l', 'Tokio', 'Japón'),
('1k2l3m', 'Seúl', 'Corea del Sur'),
('1s2t3u', 'Río de Janeiro', 'Brasil'),
('1t2u3v', 'Bangkok', 'Tailandia'),
('234512', 'Guadalajara', 'México'),
('24hj31', 'Paris', 'Francia'),
('4d5e6f', 'Londres', 'Reino Unido'),
('4e5f6g', 'Toronto', 'Canadá'),
('4f5g6h', 'Auckland', 'Nueva Zelanda'),
('4m5n6o', 'Sídney', 'Australia'),
('4n5o6p', 'Buenos Aires', 'Argentina'),
('4v5w6x', 'Moscú', 'Rusia'),
('4w5x6y', 'Dubái', 'Emiratos Árabes Unidos'),
('7p8q9r', 'Roma', 'Italia'),
('7q8r9s', 'Ámsterdam', 'Países Bajos'),
('7y8z9a', 'Pekín', 'China'),
('7z8a9b', 'Estocolmo', 'Suecia'),
('a1342k', 'Madrid', 'España'),
('j43256', 'Berlin', 'Alemania');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `ID` varchar(6) NOT NULL,
  `id_vuelo` varchar(6) NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` varchar(6) NOT NULL,
  `id_forma_pago` int DEFAULT NULL,
  `precio` double NOT NULL,
  `cantidadA` int NOT NULL,
  `cantidadM` int NOT NULL,
  `cantidadN` int NOT NULL,
  `pasajeros` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`ID`, `id_vuelo`, `fecha`, `id_usuario`, `id_forma_pago`, `precio`, `cantidadA`, `cantidadM`, `cantidadN`, `pasajeros`) VALUES
('0B8CDB', '5C529B', '2023-12-04', '213454', NULL, 15000, 2, 0, 0, 200),
('2138DB', 'ACBA63', '2023-12-04', '213454', NULL, 6500, 1, 0, 0, 100),
('300229', 'ACBA63', '2023-12-04', '213454', NULL, 13000, 2, 0, 0, 200),
('5C904C', 'A82F91', '2023-12-04', '213454', NULL, 3000, 1, 0, 0, 100),
('7EA21F', 'ACBA63', '2023-12-04', '213454', NULL, 6500, 1, 0, 0, 100),
('BF0DA0', 'EEC1C5', '2023-12-04', '213454', NULL, 44500, 2, 1, 2, 212);

--
-- Disparadores `reserva`
--
DELIMITER $$
CREATE TRIGGER `addPasajero` AFTER INSERT ON `reserva` FOR EACH ROW BEGIN
    UPDATE avion
    SET capacidad = capacidad - NEW.pasajeros
    WHERE ID = (SELECT id_avion FROM vuelo WHERE ID = NEW.id_vuelo);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `dropPasajero` AFTER UPDATE ON `reserva` FOR EACH ROW BEGIN
	UPDATE avion
    SET capacidad = capacidad + OLD.pasajeros
    WHERE ID = (SELECT id_avion FROM vuelo WHERE ID = OLD.id_vuelo);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID` varchar(6) NOT NULL,
  `nombre` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `apellidos` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombreUsuario` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tipo` varchar(15) NOT NULL DEFAULT 'USUARIO',
  `id_aeropuerto` varchar(6) DEFAULT NULL,
  `id_compañia` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID`, `nombre`, `apellidos`, `pass`, `telefono`, `nombreUsuario`, `tipo`, `id_aeropuerto`, `id_compañia`) VALUES
('213454', 'Jonathan', 'Tavares Ascencio', '12345678', '3481380455', 'Jony372', 'Administrador', 'D40004', '124356'),
('47F6EE', 'Ejemplo', 'Ejemplo', '1234', '3481234567', 'Ejemplo2', 'Aeropuerto', 'E42E56', NULL),
('627B99', 'Fernanda', 'Cruz', '1234', '3481231231', 'Fer :)', 'Aeropuerto', 'FDB44B', NULL),
('71A2E4', 'Mario', 'Tavares Ascencio', '1234', '3481234567', 'MarioTA', 'Usuario', NULL, NULL),
('98328F', 'Ejemplo', 'Ejemplo', '1234', '3481231231', 'Ejemplo', 'Usuario', NULL, NULL),
('9FE25E', 'Christian', 'Torres', '1234', '3481231231', 'Chris', 'Usuario', NULL, NULL),
('B822CF', 'Ramiro', 'Arias', '1234', '3481231231', 'Ramirilux', 'Aeropuerto', '8AB002', NULL),
('F770B2', 'Luis Diego', 'Gamiño', '1234', '3481231231', 'LuisDi', 'Aerolinea', NULL, '5BD7D2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelo`
--

CREATE TABLE `vuelo` (
  `ID` varchar(6) NOT NULL,
  `id_avion` varchar(6) NOT NULL,
  `id_compania` varchar(6) NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `tiempo` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_aeropuerto_destino` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_aeropuerto` varchar(6) NOT NULL,
  `precioA` double NOT NULL,
  `precioM` double NOT NULL,
  `precioN` double NOT NULL,
  `estado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'EN ESPERA',
  `personas` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `vuelo`
--

INSERT INTO `vuelo` (`ID`, `id_avion`, `id_compania`, `fecha_salida`, `hora_salida`, `tiempo`, `id_aeropuerto_destino`, `id_aeropuerto`, `precioA`, `precioM`, `precioN`, `estado`, `personas`) VALUES
('0255FA', '5186A0', '124356', '2023-11-28', '05:30:00', '07:42:00', 'A10001', '8AB002', 500, 300, 100, 'FINALIZADO', 0),
('3FCACD', '99E55E', '124356', '2023-12-07', '22:10:00', '01:00', '8AB002', 'D40004', 8000, 7350, 6800, 'CANCELADO', 0),
('56A4EC', '7C90FD', '124356', '2023-12-20', '19:04:00', '10:30:00', 'A10001', 'D40004', 10200, 8800, 8000, 'EN ESPERA', 0),
('5C529B', '5186A0', '124356', '2023-12-25', '12:52:00', '04:00:00', 'B20002', 'D40004', 7500, 3200, 2800, 'EN ESPERA', 0),
('6AF308', '784BBD', '5BD7D2', '2023-12-07', '09:37:00', '07:00:00', 'D40004', '8AB002', 7500, 6000, 5200, 'CANCELADO', 0),
('6E2AB0', '5186A0', '124356', '2023-11-28', '00:35:00', '06:30:00', 'A10001', '8AB002', 500, 300, 150, 'CANCELADO', 0),
('7B1A88', '3915AC', '124356', '2023-12-15', '16:05:00', '08:30:00', 'E50005', 'D40004', 2500, 2200, 1800, 'CANCELADO', 0),
('A82F91', '784BBD', '5BD7D2', '2023-12-14', '18:27:00', '00:30:00', 'D40004', 'E42E56', 3000, 2800, 2350, 'EN ESPERA', 0),
('ACBA63', '99E55E', '124356', '2023-12-25', '05:55:00', '03:50:00', 'B20002', 'D40004', 6500, 4000, 3200, 'EN ESPERA', 0),
('E51E81', '99E55E', '124356', '2023-11-29', '07:15:00', '08:00:00', 'C30003', 'D40004', 700, 500, 200, 'FINALIZADO', 0),
('EEC1C5', '7C90FD', '124356', '2023-12-06', '07:20:00', '08:00:00', 'E50005', 'D40004', 10200, 8500, 7800, 'EN ESPERA', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aeropuerto`
--
ALTER TABLE `aeropuerto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_lugar` (`id_lugar`);

--
-- Indices de la tabla `avion`
--
ALTER TABLE `avion`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `SN` (`SN`),
  ADD KEY `id_comp_vuelo` (`id_comp_vuelo`),
  ADD KEY `id_aeropuerto` (`id_aeropuerto`);

--
-- Indices de la tabla `compañia_vuelo`
--
ALTER TABLE `compañia_vuelo`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `lugar`
--
ALTER TABLE `lugar`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ciudad_unico` (`ciudad`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_vuelo` (`id_vuelo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_forma_pago` (`id_forma_pago`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unico` (`nombreUsuario`),
  ADD UNIQUE KEY `nombreUsuario` (`nombreUsuario`),
  ADD KEY `id_aeropuerto` (`id_aeropuerto`),
  ADD KEY `id_compañia` (`id_compañia`);

--
-- Indices de la tabla `vuelo`
--
ALTER TABLE `vuelo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_avion` (`id_avion`),
  ADD KEY `id_compania` (`id_compania`),
  ADD KEY `id_aeropuerto` (`id_aeropuerto`),
  ADD KEY `id_aeropuerto_destino` (`id_aeropuerto_destino`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aeropuerto`
--
ALTER TABLE `aeropuerto`
  ADD CONSTRAINT `aeropuerto_ibfk_1` FOREIGN KEY (`id_lugar`) REFERENCES `lugar` (`ID`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `avion`
--
ALTER TABLE `avion`
  ADD CONSTRAINT `avion_ibfk_1` FOREIGN KEY (`id_comp_vuelo`) REFERENCES `compañia_vuelo` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `avion_ibfk_2` FOREIGN KEY (`id_aeropuerto`) REFERENCES `aeropuerto` (`ID`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`id_vuelo`) REFERENCES `vuelo` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reserva_ibfk_3` FOREIGN KEY (`id_forma_pago`) REFERENCES `forma_pago` (`ID`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_aeropuerto`) REFERENCES `aeropuerto` (`ID`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_compañia`) REFERENCES `compañia_vuelo` (`ID`);

--
-- Filtros para la tabla `vuelo`
--
ALTER TABLE `vuelo`
  ADD CONSTRAINT `vuelo_ibfk_1` FOREIGN KEY (`id_avion`) REFERENCES `avion` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vuelo_ibfk_2` FOREIGN KEY (`id_compania`) REFERENCES `compañia_vuelo` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vuelo_ibfk_3` FOREIGN KEY (`id_aeropuerto`) REFERENCES `aeropuerto` (`ID`),
  ADD CONSTRAINT `vuelo_ibfk_4` FOREIGN KEY (`id_aeropuerto_destino`) REFERENCES `aeropuerto` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
