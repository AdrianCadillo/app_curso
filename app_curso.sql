-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2025 a las 05:16:09
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
-- Base de datos: `app_curso`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_gestion` (`opc` CHAR(15), `nombrecat` VARCHAR(70))   begin
declare respuesta varchar(90) default '';
case opc
when 'categorias' then
select *from categorias;
when 'productos' then
select *from productos as p inner join categorias as c on
p.id_categoria = c.id_categoria;
when 'i-c' then
if exists(select *from categorias where nombre_categoria=nombrecat) then
 set respuesta = 'LA CATEGORIA QUE DESEAS REGISTRAR YA EXISTE!!!';
 else
 insert into categorias(nombre_categoria) values(nombrecat);
 set respuesta = concat('LA CATEGORIA ',nombrecat,' A SIDO REGISTRADO CORRECTAMENTE!!');
end if;
end case;
select respuesta;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_productos` (`nameprof` VARCHAR(70))   begin
declare respuesta varchar(80) default ''; 
 if exists((select *from profesiones where nombre_profesion=nameprof)) then
   set respuesta = "La profesion que deseas registrar ya existe";
   else
    insert into profesiones(nombre_profesion) values(nameprof);
    set respuesta ="Profesion registrado correctamente!!";
 end if;
 select respuesta;
end$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `crudProfesiones` (`opc` INT, `nameprof` VARCHAR(70), `id` INT) RETURNS VARCHAR(80) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin
declare response varchar(70) default '';
case opc
when 1 then # insertar
if exists(select *from profesiones where nombre_profesion=nameprof) then
set response = 'LA PROFESION QUE DESEAS REGISTRAR YA EXISTE';
else
insert into profesiones(nombre_profesion) values(nameprof);
set response = 'LA PROFESION QUE HA SIDO REGISTRADO!!';
end if;

when 2 then # actualizar
update profesiones set nombre_profesion = nameprof where id_profesion=id;
set response = 'LA PROFESION QUE HA MODIFICADO!!';
end case;
return response;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `saludar` (`humano` VARCHAR(60)) RETURNS VARCHAR(90) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin
declare respuesta varchar(90) default '';

set respuesta = concat('Hola ',humano,'. como estas?');

return respuesta;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `deleted_at`) VALUES
(2, 'Marketing', NULL),
(6, 'Tecnología', '2025-04-10 21:04:23'),
(7, 'Educacion', NULL),
(8, 'Desarrollo web', NULL),
(9, 'Categoría de prueba', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id_docente` int(11) NOT NULL,
  `apellidos` varchar(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nombres` varchar(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `profesion_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `precio` float NOT NULL,
  `stock` smallint(6) NOT NULL,
  `imagen` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `descripcion`, `precio`, `stock`, `imagen`, `deleted_at`, `id_categoria`) VALUES
(6, 'Desarollo de aplicaciones web con laravel y SQL SERVER', 'descripcion de prueba', 120, 1, '20250418034910292968184.png', NULL, 8),
(7, 'producto de prueba1', NULL, 12, 11, NULL, '2025-04-17 21:18:12', 8),
(9, 'prouducto nuevo 1', NULL, 9.8, 17, '20250418034949705921657.png', '2025-04-17 21:23:34', 2),
(10, 'Inka kola de 3 litros', NULL, 12, 23, '202504180305111082317894.png', NULL, 2),
(11, 'Programación desde cero PHP', NULL, 160, 34, '202504180307371272826296.png', NULL, 8);

--
-- Disparadores `productos`
--
DELIMITER $$
CREATE TRIGGER `insertar_producto` BEFORE INSERT ON `productos` FOR EACH ROW begin 
 if exists(select *from productos where nombre_producto=new.nombre_producto) then
  signal sqlstate '45000'
  set message_text = "error, ya existe el producto que deseas registrar.";
 end if;
 end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesiones`
--

CREATE TABLE `profesiones` (
  `id_profesion` int(11) NOT NULL,
  `nombre_profesion` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesiones`
--

INSERT INTO `profesiones` (`id_profesion`, `nombre_profesion`, `deleted_at`) VALUES
(1, 'Ing.Agronomo', NULL),
(2, 'Ing.Industrial', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(90) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password_` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email_verified` datetime DEFAULT NULL,
  `token` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `tiempo_expired` int(11) DEFAULT NULL,
  `code_verification` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `reset_password` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `rol` set('a','u') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `foto` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `estado` enum('a','i') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `username`, `email`, `password_`, `email_verified`, `token`, `tiempo_expired`, `code_verification`, `reset_password`, `rol`, `foto`, `estado`) VALUES
(3, 'Fiorella Ivana', 'Admin@gmail.com', '$2y$10$1CemEiTz3JNly43zFmXuw.RImC1vnCIeluAD76.c9WpUwEi7O7pb2', NULL, NULL, NULL, NULL, NULL, 'a', NULL, 'a'),
(5, 'Admin', 'admin3@gmail.com', '$2y$10$iauvOCWWadn599TkNvWTZu9ebX3DuHLRN2InmcVR3.1b0LYcERiB6', NULL, NULL, NULL, NULL, NULL, 'a', '202505020334511690034363.png', 'a'),
(6, 'Jorge Pedro', 'pedro2000@gmai.com', '$2y$10$EH1RPiBodB0lz.6XugenRuZhVfZjjOJCShTmW6tWlXEtp3BWpmrlG', '2025-04-28 21:05:24', NULL, NULL, NULL, NULL, 'u', '202505020335441860796436.png', 'a');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id_docente`),
  ADD KEY `profesion_id` (`profesion_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_PRODUCTOS_CATEGORIAS_idx` (`id_categoria`);

--
-- Indices de la tabla `profesiones`
--
ALTER TABLE `profesiones`
  ADD PRIMARY KEY (`id_profesion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `profesiones`
--
ALTER TABLE `profesiones`
  MODIFY `id_profesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docentes_ibfk_1` FOREIGN KEY (`profesion_id`) REFERENCES `profesiones` (`id_profesion`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_PRODUCTOS_CATEGORIAS` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
