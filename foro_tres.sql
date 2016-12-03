-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-12-2015 a las 23:53:25
-- Versión del servidor: 5.5.42
-- Versión de PHP: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `foro_tres`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ACTIVIDADES`
--

CREATE TABLE `ACTIVIDADES` (
  `id` int(11) NOT NULL,
  `n_comentario` int(11) NOT NULL,
  `n_tema` int(11) NOT NULL,
  `mensajes_enviados` int(11) NOT NULL,
  `mensajes_recibidos` int(11) NOT NULL,
  `mensajes_noleidos` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CATEGORIAS`
--

CREATE TABLE `CATEGORIAS` (
  `id` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `CATEGORIAS`
--

INSERT INTO `CATEGORIAS` (`id`, `titulo`, `descripcion`, `tipo`) VALUES
(2, 'Categoria 1', 'Esta es la categoria 1', 0),
(4, 'Categoria Privada', 'Esta es una categoria privada', 1),
(5, 'Categoria Cuatro', 'Esta es la categoria numero cuatro', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMENTARIOS`
--

CREATE TABLE `COMENTARIOS` (
  `id` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_modificacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `contenido` text NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `COMENTARIOS`
--

INSERT INTO `COMENTARIOS` (`id`, `fecha_creacion`, `fecha_modificacion`, `contenido`, `usuario_id`, `tema_id`) VALUES
(2, '2015-12-15 08:36:58', '2015-12-15 08:36:58', 'Este es el comentario con id 2', 1, 2),
(3, '2015-12-15 09:36:54', '2015-12-22 02:25:37', 'Este es un comentario no se que numero es.', 1, 3),
(4, '2015-12-15 10:11:50', '2015-12-22 02:25:15', 'Este sera el ultimo comentario', 1, 3),
(5, '2015-12-15 10:38:51', '2015-12-15 10:38:51', 'Este sera el ultima en la categoria 3', 1, 3),
(11, '2015-12-17 06:16:39', '2015-12-17 06:16:39', 'ok, muchas gracias.\nSaludos.', 1, 31),
(12, '2015-12-17 06:22:23', '2015-12-17 06:22:23', 'Este tambien es un comentario con saltos de línea.\nAhora ya estoy en la segunda línea,\ny en la tercera ahora.\nSaludos.', 42, 31),
(13, '2015-12-17 06:31:00', '2015-12-17 06:31:00', 'probando respuesta\n', 71, 2),
(14, '2015-12-17 14:36:44', '2015-12-17 14:36:44', 'prueba comentario', 1, 31),
(15, '2015-12-17 23:55:26', '2015-12-17 23:55:26', 'comentario con salto\nde linea', 1, 2),
(17, '2015-12-21 02:12:55', '2015-12-22 02:52:26', 'Este es un nuevo comentario para prueba', 71, 3),
(19, '2015-12-21 21:32:16', '2015-12-21 21:32:16', 'Gracias,\nSaludos.', 1, 3);

--
-- Disparadores `COMENTARIOS`
--
DELIMITER $$
CREATE TRIGGER `Trigger_fcreacion` BEFORE INSERT ON `comentarios`
 FOR EACH ROW BEGIN SET NEW.fecha_creacion=IF(ISNULL(NEW.fecha_creacion) OR NEW.fecha_creacion='0000-00-00 00:00:00', CURRENT_TIMESTAMP, IF(NEW.fecha_creacion<CURRENT_TIMESTAMP, NEW.fecha_creacion, CURRENT_TIMESTAMP));SET NEW.fecha_modificacion=NEW.fecha_creacion; END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_fmodificacion` BEFORE UPDATE ON `comentarios`
 FOR EACH ROW SET NEW.fecha_modificacion=IF(NEW.fecha_modificacion<OLD.fecha_modificacion, OLD.fecha_modificacion, CURRENT_TIMESTAMP)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `MENSAJES`
--

CREATE TABLE `MENSAJES` (
  `id` int(11) NOT NULL,
  `asunto` varchar(45) NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` tinyint(1) NOT NULL,
  `contenido` text NOT NULL,
  `id_envia` int(11) NOT NULL,
  `id_recibe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TEMAS`
--

CREATE TABLE `TEMAS` (
  `id` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `contenido` text NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `TEMAS`
--

INSERT INTO `TEMAS` (`id`, `titulo`, `contenido`, `tipo`, `fecha`, `usuario_id`, `categoria_id`) VALUES
(2, 'Tema 1', 'Este es el contenido del tema 1', 0, '2015-12-15 08:36:33', 1, 2),
(3, 'Tema numero 2', 'Este es el contenido del tema numero 2', 0, '2015-12-15 09:34:31', 1, 2),
(20, 'Segundo tema nuevo', 'ajajjjjaj', 1, '2015-12-16 09:24:44', 71, 2),
(21, 'Titulo del tema nuevoaa', 'Huahauahuahuahuau', 1, '2015-12-16 09:28:41', 71, 2),
(23, 'Titulo del tema nuevo y publico', 'Este es el contenido del nuevo tema publico creado desde el formulario', 1, '2015-12-16 09:42:51', 71, 2),
(24, 'Titulo del tema nuevo y publico ahora si', 'Este es el contenido del tema nuevo y publico creado desde el formulario', 1, '2015-12-16 09:44:51', 71, 2),
(25, 'Tema nuevo publico', 'Este tema es nueov y publico creado del foruulario', 0, '2015-12-16 09:47:23', 71, 2),
(28, 'o', 'j', 1, '2015-12-16 11:13:21', 71, 4),
(29, 'Probando nuevo tema', 'este es el contenido de la prueba del nuevo tema', 0, '2015-12-17 05:40:52', 71, 2),
(30, 'titulo de un tema nuevo', 'este es el contenido de un nuevo tema creado', 0, '2015-12-17 05:41:49', 71, 5),
(31, 'tema con saltos de linea', 'aqui va un salto de linea\nesta es la segunda fila,\ntercera\ncuarta', 0, '2015-12-17 05:51:02', 71, 2),
(32, 'Prueba de teme en Jertrón', 'esto es solo una prueba de tema en la categoria privada,\nSaludos.', 1, '2015-12-18 08:38:30', 71, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TIPOS_CATEGORIAS`
--

CREATE TABLE `TIPOS_CATEGORIAS` (
  `id` tinyint(1) NOT NULL,
  `nombre` varchar(16) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `TIPOS_CATEGORIAS`
--

INSERT INTO `TIPOS_CATEGORIAS` (`id`, `nombre`) VALUES
(0, 'Público'),
(1, 'Privado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TIPOS_TEMAS`
--

CREATE TABLE `TIPOS_TEMAS` (
  `id` tinyint(1) NOT NULL,
  `nombre` varchar(16) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `TIPOS_TEMAS`
--

INSERT INTO `TIPOS_TEMAS` (`id`, `nombre`) VALUES
(0, 'Público'),
(1, 'Privado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TIPOS_URUARIOS`
--

CREATE TABLE `TIPOS_URUARIOS` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `TIPOS_URUARIOS`
--

INSERT INTO `TIPOS_URUARIOS` (`id`, `nombre`) VALUES
(0, 'Administrador'),
(1, 'Moderador'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIOS`
--

CREATE TABLE `USUARIOS` (
  `id` int(11) NOT NULL,
  `nickname` varchar(16) NOT NULL,
  `nombre` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `sexo` char(1) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `url_avatar` text,
  `tipo_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `USUARIOS`
--

INSERT INTO `USUARIOS` (`id`, `nickname`, `nombre`, `password`, `sexo`, `fecha_nacimiento`, `fecha_registro`, `url_avatar`, `tipo_id`) VALUES
(1, 'Nacho', 'Nacho', '123456', '1', '1995-01-26', '2015-12-11 23:21:55', '', 0),
(39, 'RodrigoNach', 's', 'as', '0', '0000-00-00', '2015-12-14 11:49:40', '', 2),
(41, 'RodrigoNach1', 's', 'as', '0', '0000-00-00', '2015-12-14 11:50:23', '', 2),
(42, 'RodrigoNach11', 's', 'as', '0', '0000-00-00', '2015-12-14 11:50:47', '', 2),
(43, '', '', '', '0', '0000-00-00', '2015-12-14 11:52:57', '', 2),
(46, 'jkjkjkjkjkjkjkj', 'kkkkkkkkkkkkkkk', 'ooooooooooooooo', '0', '0000-00-00', '2015-12-14 20:00:36', '', 2),
(52, 'asasdasd', 'asdas', '', '0', '0000-00-00', '2015-12-14 20:09:26', '', 2),
(56, 'asdsfsafasf', 'asfasfsfasfa', 'aasdf', '0', '0000-00-00', '2015-12-14 20:29:38', '', 2),
(59, 'matias', 'Matias', '123456', '0', '0000-00-00', '2015-12-14 20:37:31', '', 2),
(60, 'Hiahaia', 'ajshj', '', '0', '2015-12-02', '2015-12-15 04:49:42', '', 2),
(61, 'lkjlkdd', 'kjkljlk', '', '0', '2015-12-15', '2015-12-15 05:58:31', '', 2),
(62, 'qqqweq', 'aassa', '', '0', '2015-12-06', '2015-12-15 06:01:40', '', 2),
(65, 'qqqweqw', 'aassa', '', '0', '2015-12-06', '2015-12-15 06:02:07', '', 2),
(67, '112223', 'qwqw', '', '0', '2015-12-01', '2015-12-15 06:02:25', '', 2),
(68, 'qweqew', 'qwqw', '', '0', '2015-12-08', '2015-12-15 06:03:31', '', 2),
(69, 'asaaaa', 's', '', '0', '2015-12-09', '2015-12-15 06:12:40', '', 2),
(70, 'aaaaddd', 'as', 'as', '0', '2015-12-15', '2015-12-15 06:14:16', '', 2),
(71, 'matiaslagos', 'Matias Lagos Pe', '123', '0', '2015-12-04', '2015-12-16 00:40:39', 'https://cdn1.iconfinder.com/data/icons/user-pictures/100/male3-512.png', 2),
(72, 'undefined', 'undefined', 'undefined', 'u', '0000-00-00', '2015-12-17 22:11:02', 'undefined', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ACTIVIDADES`
--
ALTER TABLE `ACTIVIDADES`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `usuario_id_actividad_idx` (`usuario_id`);

--
-- Indices de la tabla `CATEGORIAS`
--
ALTER TABLE `CATEGORIAS`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_tipos_categorias` (`tipo`);

--
-- Indices de la tabla `COMENTARIOS`
--
ALTER TABLE `COMENTARIOS`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `usuario_id_idx` (`usuario_id`),
  ADD KEY `tema_id_idx` (`tema_id`);

--
-- Indices de la tabla `MENSAJES`
--
ALTER TABLE `MENSAJES`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `id_envia_idx` (`id_envia`),
  ADD KEY `id_recibe_idx` (`id_recibe`);

--
-- Indices de la tabla `TEMAS`
--
ALTER TABLE `TEMAS`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `usuario_id_idx` (`usuario_id`),
  ADD KEY `categoria_id_idx` (`categoria_id`),
  ADD KEY `fk_tipos_temas` (`tipo`);

--
-- Indices de la tabla `TIPOS_CATEGORIAS`
--
ALTER TABLE `TIPOS_CATEGORIAS`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `TIPOS_TEMAS`
--
ALTER TABLE `TIPOS_TEMAS`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `TIPOS_URUARIOS`
--
ALTER TABLE `TIPOS_URUARIOS`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `USUARIOS`
--
ALTER TABLE `USUARIOS`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nickname`),
  ADD KEY `tipo_id_usuarios_idx` (`tipo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `CATEGORIAS`
--
ALTER TABLE `CATEGORIAS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `COMENTARIOS`
--
ALTER TABLE `COMENTARIOS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `MENSAJES`
--
ALTER TABLE `MENSAJES`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `TEMAS`
--
ALTER TABLE `TEMAS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT de la tabla `USUARIOS`
--
ALTER TABLE `USUARIOS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `COMENTARIOS`
--
ALTER TABLE `COMENTARIOS`
  ADD CONSTRAINT `tema_id_comentarios` FOREIGN KEY (`tema_id`) REFERENCES `TEMAS` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_id_comentarios` FOREIGN KEY (`usuario_id`) REFERENCES `USUARIOS` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `MENSAJES`
--
ALTER TABLE `MENSAJES`
  ADD CONSTRAINT `id_envia` FOREIGN KEY (`id_envia`) REFERENCES `USUARIOS` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_recibe` FOREIGN KEY (`id_recibe`) REFERENCES `USUARIOS` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `TEMAS`
--
ALTER TABLE `TEMAS`
  ADD CONSTRAINT `categoria_id_temas` FOREIGN KEY (`categoria_id`) REFERENCES `CATEGORIAS` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tipos_temas` FOREIGN KEY (`tipo`) REFERENCES `TIPOS_TEMAS` (`id`),
  ADD CONSTRAINT `usuario_id_temas` FOREIGN KEY (`usuario_id`) REFERENCES `USUARIOS` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `USUARIOS`
--
ALTER TABLE `USUARIOS`
  ADD CONSTRAINT `tipo_id_usuarios` FOREIGN KEY (`tipo_id`) REFERENCES `TIPOS_URUARIOS` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
