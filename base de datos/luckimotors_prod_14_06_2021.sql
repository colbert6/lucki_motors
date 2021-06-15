-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2021 a las 00:56:00
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `luckimotors`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `idarea` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `colaborador_idcolaborador` int(11) DEFAULT NULL COMMENT 'responsable del area',
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`idarea`, `nombre`, `colaborador_idcolaborador`, `estado`) VALUES
(1, 'ALMACÉN', 1, 'Activo'),
(2, 'ENSAMBLAJE', 1, 'Activo'),
(3, 'PINTURA', 1, 'Activo'),
(4, 'SERVICIO TÉCNICO', 1, 'Activo'),
(5, 'SOLDADURA', 1, 'Activo'),
(6, 'TAPIZ', 1, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colaborador`
--

CREATE TABLE `colaborador` (
  `idcolaborador` int(11) NOT NULL,
  `perfil` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `contacto` varchar(20) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `colaborador`
--

INSERT INTO `colaborador` (`idcolaborador`, `perfil`, `nombre`, `usuario`, `clave`, `dni`, `contacto`, `correo`, `fecha_nacimiento`, `estado`) VALUES
(1, 1, 'Administrador', 'luckimotors', 'sistemas123', '12345678', '9875324554', 'materialesalmacentarapoto@gmail.com', '1994-08-15', 'Activo');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `creditos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `creditos` (
`idingreso` int(11)
,`pedido` varchar(7)
,`estado` enum('Cancelado','Debe')
,`razon_social` varchar(200)
,`fecha_compra` date
,`fecha_recepcion` date
,`descripcion` varchar(200)
,`nrocomprobante` varchar(50)
,`total` decimal(18,2)
,`observacion` varchar(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL,
  `codigo_producto` varchar(20) DEFAULT NULL,
  `descripcion_producto` varchar(200) DEFAULT NULL,
  `producto_idproducto` int(11) DEFAULT NULL,
  `descripcion_area` varchar(50) DEFAULT NULL,
  `cantidad` decimal(18,2) DEFAULT NULL,
  `medida` varchar(20) DEFAULT NULL,
  `precio_unitario` decimal(18,2) DEFAULT NULL,
  `descuento_porcentanje` decimal(10,2) DEFAULT NULL,
  `descuento_monto` decimal(18,2) DEFAULT NULL,
  `igv_monto` decimal(18,2) DEFAULT NULL,
  `subtotal` decimal(18,2) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `ingreso_idingreso` int(11) DEFAULT NULL,
  `tipo_gasto` enum('directo','indirecto','servicio') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_ingreso`
--

INSERT INTO `detalle_ingreso` (`iddetalle_ingreso`, `codigo_producto`, `descripcion_producto`, `producto_idproducto`, `descripcion_area`, `cantidad`, `medida`, `precio_unitario`, `descuento_porcentanje`, `descuento_monto`, `igv_monto`, `subtotal`, `estado`, `ingreso_idingreso`, `tipo_gasto`) VALUES
(1, '032', 'DOBLE FAZ HONDA AÑIL', 12, ' TAPIZ ', '50.00', 'MTS', '12.00', '0.00', '0.00', '0.00', '600.00', 'Activo', 1, 'directo'),
(2, '0', 'BISAGRA 2\" x 3/8\" (2 ALAS)', 0, ' SOLDADURA ', '2.00', 'UND', '0.80', '0.00', '0.00', '0.00', '1.60', 'Activo', 2, 'indirecto'),
(3, '0', 'BISAGRA 2\" x 1/2\" (2 ALAS)', 0, ' SOLDADURA ', '3.00', 'UND', '1.60', '0.00', '0.00', '0.00', '4.80', 'Activo', 2, 'indirecto'),
(4, '0', 'RECONSTRUCCIÓN DE GUÍA DE BOTELLA HIDRÁULICA', 0, ' SOLDADURA ', '1.00', 'UND', '220.00', '0.00', '0.00', '0.00', '220.00', 'Activo', 3, 'indirecto'),
(5, '136', 'THINNER', 63, ' PINTURA ', '12.00', 'GL', '18.00', '0.00', '0.00', '0.00', '216.00', 'Activo', 4, 'directo'),
(6, '0', 'PINTURA GLOSS BLANCO KORAL', 0, ' PINTURA ', '1.00', 'GL', '18.00', '0.00', '0.00', '0.00', '18.00', 'Activo', 4, 'indirecto'),
(7, '132', 'GUARDAFANGO AZUL', 59, ' ENSAMBLAJE ', '20.00', 'UND', '20.00', '0.00', '0.00', '0.00', '400.00', 'Activo', 5, 'directo'),
(8, '073', 'MEZCLA MIG 80/20', 38, ' SOLDADURA ', '3.00', 'BL', '280.00', '0.00', '0.00', '0.00', '840.00', 'Activo', 6, 'directo'),
(9, '289', 'CATALINA 45T', 94, ' ENSAMBLAJE ', '40.00', 'UND', '7.70', '0.00', '0.00', '0.00', '308.00', 'Activo', 7, 'directo'),
(10, '0', 'FILTRO 2097 P100 NIV. MOLESTOS DE VAPORES ORG/OZONO-3M', 0, ' SOLDADURA ', '38.00', 'UND', '2.00', '0.00', '0.00', '0.00', '76.00', 'Activo', 8, 'indirecto'),
(11, '0', 'MAMELUCO IMPERMEABLE', 0, ' PINTURA ', '2.00', 'UND', '17.90', '0.00', '0.00', '0.00', '35.80', 'Activo', 9, 'indirecto'),
(12, '253', 'GUANTES NITRON (ACIDO)', 95, ' PINTURA ', '4.00', 'PR', '9.90', '0.00', '0.00', '0.00', '39.60', 'Activo', 9, 'directo'),
(13, '0', 'GUANTE INGENIERO', 0, ' SOLDADURA ', '1.00', 'PR', '9.90', '0.00', '0.00', '0.00', '9.90', 'Activo', 9, 'indirecto'),
(14, '0', 'GUANTE DE HILO CON PUNTOS', 0, ' SOLDADURA ', '6.00', 'PR', '2.50', '0.00', '0.00', '0.00', '15.00', 'Activo', 9, 'indirecto'),
(15, '0', 'BIO BOLSA GRANDE', 0, ' ALMACÉN ', '1.00', 'UND', '0.30', '0.00', '0.00', '0.00', '0.30', 'Activo', 9, 'indirecto'),
(16, '019', 'CARRETE COMPLETO', 4, ' ENSAMBLAJE ', '50.00', 'UND', '25.42', '0.00', '0.00', '228.81', '1271.19', 'Activo', 10, 'directo'),
(17, '113', 'RODAJE 6302', 54, ' ENSAMBLAJE ', '100.00', 'UND', '1.86', '0.00', '0.00', '33.56', '186.44', 'Activo', 10, 'directo'),
(18, '028', 'COLETA CG', 9, ' ENSAMBLAJE ', '100.00', 'UND', '0.59', '0.00', '0.00', '10.68', '59.32', 'Activo', 10, 'directo'),
(19, '029', 'FARO DIRECCIONAL GL', 10, ' ENSAMBLAJE ', '100.00', 'UND', '2.75', '0.00', '0.00', '49.58', '275.42', 'Activo', 10, 'directo'),
(20, '110', 'RESORTE INTERNO DE BARRA', 51, ' ENSAMBLAJE ', '50.00', 'PR', '10.47', '0.00', '0.00', '94.19', '523.31', 'Activo', 10, 'directo'),
(21, '047', 'FOCO DIRECCIONAL', 20, ' ENSAMBLAJE ', '300.00', 'UND', '0.32', '0.00', '0.00', '17.39', '96.61', 'Activo', 10, 'directo'),
(22, '048', 'FOCO DE PELIGRO', 21, ' ENSAMBLAJE ', '250.00', 'UND', '0.42', '0.00', '0.00', '19.07', '105.93', 'Activo', 10, 'directo'),
(23, '162', 'TUERCA CIEGA DE AMORTIGUADOR', 77, ' ENSAMBLAJE ', '1000.00', 'UND', '0.33', '0.00', '0.00', '59.49', '330.51', 'Activo', 10, 'directo'),
(24, '193', 'PINTURA SPRAY NEGRO', 96, ' PINTURA ', '72.00', 'UND', '3.25', '0.00', '0.00', '42.10', '233.90', 'Activo', 11, 'directo'),
(25, '137', 'TIRAFON 1/4 x 1Y1/2', 64, ' TAPIZ ', '2600.00', 'UND', '0.07', '0.00', '0.00', '33.71', '187.29', 'Activo', 11, 'directo'),
(26, '084', 'PERNO M-6x30 (FARO DIRECCIONAL)', 45, ' ENSAMBLAJE ', '1000.00', 'UND', '0.07', '0.00', '0.00', '11.90', '66.10', 'Activo', 11, 'directo'),
(27, '085', 'PERNO M-6x20 (VARILLA DE FRENO)', 46, ' ENSAMBLAJE ', '2000.00', 'UND', '0.06', '0.00', '0.00', '19.83', '110.17', 'Activo', 11, 'directo'),
(28, '182', 'TUERCAS 10MM', 88, ' ENSAMBLAJE ', '3000.00', 'UND', '0.02', '0.00', '0.00', '10.98', '61.02', 'Activo', 11, 'directo'),
(29, '164', 'DOBLE FAZ HONDA NEGRO', 78, ' TAPIZ ', '72.00', 'MTS', '12.00', '0.00', '0.00', '0.00', '864.00', 'Activo', 12, 'directo'),
(30, '072', 'MARROQUI', 37, ' TAPIZ ', '50.00', 'MTS', '14.00', '0.00', '0.00', '0.00', '700.00', 'Activo', 12, 'directo'),
(31, '132', 'GUARDAFANGO AZUL', 59, ' ENSAMBLAJE ', '22.00', 'UND', '20.00', '0.00', '0.00', '0.00', '440.00', 'Activo', 13, 'directo'),
(32, '133', 'GUARDAFANGO ROJO', 60, ' ENSAMBLAJE ', '24.00', 'UND', '20.00', '0.00', '0.00', '0.00', '480.00', 'Activo', 13, 'directo'),
(33, '084', 'PERNO M-6x30 (FARO DIRECCIONAL)', 45, ' SOLDADURA ', '100.00', 'UND', '0.07', '0.00', '0.00', '0.00', '7.00', 'Activo', 14, 'directo'),
(34, '008', 'CABLE AUTOMOTRIZ', 2, ' ENSAMBLAJE ', '10.00', 'RLL', '35.00', '0.00', '0.00', '0.00', '350.00', 'Activo', 14, 'directo'),
(35, '019', 'CARRETE COMPLETO', 4, ' ENSAMBLAJE ', '10.50', 'UND', '25.42', '0.00', '0.00', '0.00', '0.00', 'Activo', 15, 'directo'),
(36, '183', 'ACONDICIONADOR', 89, ' PINTURA ', '5.90', 'GL', '34.00', '0.00', '0.00', '0.00', '0.00', 'Activo', 16, 'directo'),
(37, '183', 'ACONDICIONADOR', 89, ' PINTURA ', '2.90', 'GL', '0.00', '0.00', '0.00', '0.00', '0.00', 'Activo', 17, 'directo'),
(38, '021', 'CATALINA 37T', 5, ' ENSAMBLAJE ', '9.50', 'UND', '5.70', '0.00', '0.00', '0.00', '0.00', 'Activo', 18, 'directo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_salida`
--

CREATE TABLE `detalle_salida` (
  `iddetalle_salida` int(11) NOT NULL,
  `codigo_producto` varchar(20) DEFAULT NULL,
  `descripcion_producto` varchar(200) DEFAULT NULL,
  `producto_idproducto` int(11) DEFAULT NULL,
  `descripcion_area` varchar(50) DEFAULT NULL,
  `cantidad` decimal(18,2) DEFAULT NULL,
  `medida` varchar(20) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `salida_idsalida` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_salida`
--

INSERT INTO `detalle_salida` (`iddetalle_salida`, `codigo_producto`, `descripcion_producto`, `producto_idproducto`, `descripcion_area`, `cantidad`, `medida`, `estado`, `salida_idsalida`) VALUES
(1, '080', 'PERNO CABEZA COCHE 1/4 x 1', 41, ' ALMACÉN ', '10.00', 'UND', 'Activo', 1),
(2, '082', 'PERNO 8x20 (CARROCERÍA)', 43, ' SOLDADURA ', '10.00', 'UND', 'Activo', 2),
(3, '019', 'CARRETE COMPLETO', 4, ' ENSAMBLAJE ', '10.50', 'UND', 'Activo', 3),
(4, '019', 'CARRETE COMPLETO', 4, ' ENSAMBLAJE ', '10.20', 'UND', 'Activo', 4),
(5, '183', 'ACONDICIONADOR', 89, ' PINTURA ', '4.20', 'GL', 'Activo', 5),
(6, '183', 'ACONDICIONADOR', 89, ' PINTURA ', '1.20', 'GL', 'Activo', 6),
(7, '183', 'ACONDICIONADOR', 89, ' PINTURA ', '0.20', 'GL', 'Activo', 7),
(8, '021', 'CATALINA 37T', 5, ' ENSAMBLAJE ', '2.50', 'UND', 'Activo', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL,
  `tienda_idtienda` int(11) DEFAULT NULL,
  `proveedor_idproveedor` int(11) DEFAULT NULL,
  `colaborador_recepcion` int(11) DEFAULT NULL,
  `colaborador_registro` int(11) DEFAULT NULL,
  `idperiodo_pago` int(11) DEFAULT NULL,
  `tipo_comprobante_idtipo_comprobante` int(11) DEFAULT NULL,
  `nrocomprobante` varchar(50) DEFAULT NULL,
  `guia_remision_remitente` varchar(60) DEFAULT '0',
  `guia_remision_transportista` varchar(60) DEFAULT '0',
  `fecha_compra` date DEFAULT NULL,
  `fecha_recepcion` date DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `total` decimal(18,2) DEFAULT NULL,
  `igv` decimal(18,2) DEFAULT NULL,
  `descuento` decimal(18,2) DEFAULT NULL,
  `subtotal` decimal(18,2) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `estado` enum('Vigente','Anulado') DEFAULT 'Vigente',
  `estado_pago` enum('Cancelado','Debe') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`idingreso`, `tienda_idtienda`, `proveedor_idproveedor`, `colaborador_recepcion`, `colaborador_registro`, `idperiodo_pago`, `tipo_comprobante_idtipo_comprobante`, `nrocomprobante`, `guia_remision_remitente`, `guia_remision_transportista`, `fecha_compra`, `fecha_recepcion`, `fecha_pago`, `observacion`, `total`, `igv`, `descuento`, `subtotal`, `fecha_creacion`, `estado`, `estado_pago`) VALUES
(1, 1, 1, 1, 1, 2, 2, 'F001-00001907', '-', '-', '2020-01-02', '2020-01-02', '0000-00-00', '', '600.00', '0.00', '0.00', '600.00', '2020-01-10 09:30:43', 'Vigente', 'Debe'),
(2, 1, 2, 1, 1, 1, 2, 'F011-0053875', '-', '-', '2020-01-03', '2020-01-03', '2020-01-10', 'COMPRA SR. RUBEN', '6.40', '0.00', '0.00', '6.40', '2020-01-10 09:36:34', 'Vigente', 'Cancelado'),
(3, 1, 3, 1, 1, 1, 2, 'E001-505', '-', '-', '2020-01-03', '2020-01-03', '2020-01-10', 'COMPRA SR. RUBEN', '220.00', '0.00', '0.00', '220.00', '2020-01-10 09:40:20', 'Vigente', 'Cancelado'),
(4, 1, 4, 1, 1, 2, 2, 'F001-0002350', '-', '-', '2020-01-03', '2020-01-03', '2020-01-04', '', '234.00', '0.00', '0.00', '234.00', '2020-01-10 09:46:10', 'Vigente', 'Cancelado'),
(5, 1, 5, 1, 1, 2, 2, 'F010-00007894', '-', '-', '2020-01-04', '2020-01-04', '0000-00-00', '', '400.00', '0.00', '0.00', '400.00', '2020-01-10 09:50:00', 'Vigente', 'Debe'),
(6, 1, 6, 1, 1, 2, 2, 'F001-00000551', '-', '-', '2020-01-06', '2020-01-06', '0000-00-00', '', '840.00', '0.00', '0.00', '840.00', '2020-01-10 09:59:56', 'Vigente', 'Debe'),
(7, 1, 7, 1, 1, 1, 2, 'F004-00050380', '-', '-', '2020-01-06', '2020-01-06', '2020-01-10', '', '308.00', '0.00', '0.00', '308.00', '2020-01-10 10:14:55', 'Vigente', 'Cancelado'),
(8, 1, 8, 1, 1, 1, 2, 'F001-00003015', '-', '-', '2020-01-07', '2020-01-07', '2020-01-10', 'COMPRA SR. RUBEN', '76.00', '0.00', '0.00', '76.00', '2020-01-10 10:18:46', 'Vigente', 'Cancelado'),
(9, 1, 9, 1, 1, 1, 2, 'FA04-00116208', '-', '-', '2020-01-07', '2020-01-07', '2020-01-10', 'COMPRA SR. RUBEN', '100.60', '0.00', '0.00', '100.60', '2020-01-10 10:28:40', 'Vigente', 'Cancelado'),
(10, 1, 10, 1, 1, 2, 2, '002-0000192', '0002-0000194', '0002-104716', '2020-01-03', '2020-01-08', '0000-00-00', '', '3361.50', '512.77', '0.00', '2848.73', '2020-01-10 11:03:21', 'Vigente', 'Debe'),
(11, 1, 10, 1, 1, 2, 2, '002-0000193', '000-0000195', '000-104716', '2020-01-03', '2020-01-08', '0000-00-00', '', '777.00', '118.52', '0.00', '658.48', '2020-01-10 11:10:23', 'Vigente', 'Debe'),
(12, 1, 1, 1, 1, 2, 2, 'F001-00001935', '-', '-', '2020-01-08', '2020-01-08', '0000-00-00', '', '1564.00', '0.00', '1564.00', '1564.00', '2020-01-10 14:00:53', 'Vigente', 'Debe'),
(13, 1, 5, 1, 1, 2, 2, 'F010-00007932', '-', '-', '2020-01-08', '2020-01-08', '2020-07-09', '', '1840.00', '0.00', '0.00', '920.00', '2020-01-10 14:02:54', 'Vigente', 'Cancelado'),
(14, 1, 4, 1, 1, 2, 2, '01225', '0212', '0144', '2020-07-31', '2020-07-31', '0000-00-00', '', '357.00', '0.00', '0.00', '357.00', '2020-07-31 12:35:13', 'Vigente', 'Debe'),
(15, 1, 10, 1, 1, 1, 2, '0', '0', '0', '2021-05-31', '2021-05-31', '2021-05-31', '', '0.00', '0.00', '0.00', '0.00', '2021-05-31 21:19:21', 'Vigente', 'Cancelado'),
(16, 1, 10, 1, 1, 1, 2, '0', '0', '0', '2021-05-31', '2021-05-31', '2021-05-31', '', '0.00', '0.00', '0.00', '0.00', '2021-05-31 21:22:44', 'Vigente', 'Cancelado'),
(17, 1, 10, 1, 1, 1, 2, '0', '0', '0', '2021-05-31', '2021-05-31', '2021-05-31', '', '0.00', '0.00', '0.00', '0.00', '2021-05-31 21:33:37', 'Vigente', 'Cancelado'),
(18, 1, 10, 1, 1, 1, 2, '0', '0', '0', '2021-05-31', '2021-05-31', '2021-05-31', '', '0.00', '0.00', '0.00', '0.00', '2021-05-31 21:34:05', 'Vigente', 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `idkardex` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `producto_idproducto` int(11) DEFAULT NULL,
  `tienda_idtienda` int(11) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `idpresentacion` int(11) DEFAULT NULL,
  `cantidaxpresentacion` int(255) DEFAULT NULL,
  `precioxpresentacion` decimal(18,2) DEFAULT NULL,
  `cantidad` int(255) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `tipo_movimiento` enum('entrada','salida') DEFAULT 'salida',
  `motivo` varchar(20) DEFAULT NULL,
  `codmotivo` int(11) DEFAULT NULL,
  `stock_actual` int(11) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_movimiento`
--

CREATE TABLE `motivo_movimiento` (
  `idmotivo` int(11) NOT NULL,
  `tipo` enum('Ingreso','Salida') DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `motivo_movimiento`
--

INSERT INTO `motivo_movimiento` (`idmotivo`, `tipo`, `descripcion`, `estado`) VALUES
(1, 'Ingreso', 'Compra', 'Activo'),
(2, 'Salida', 'Fallido', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_pago`
--

CREATE TABLE `periodo_pago` (
  `idperiodo_pago` int(11) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `abreviatura` varchar(10) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `periodo_pago`
--

INSERT INTO `periodo_pago` (`idperiodo_pago`, `descripcion`, `abreviatura`, `estado`) VALUES
(1, 'CONTADO', 'cont.', 'Activo'),
(2, 'CRÉDITO', 'cred.', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `idpresentacion` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `abreviatura` varchar(50) NOT NULL,
  `codsunat` varchar(50) NOT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`idpresentacion`, `nombre`, `descripcion`, `abreviatura`, `codsunat`, `estado`) VALUES
(1, 'KILOGRAMOS', '', 'KG', '01', 'Activo'),
(2, 'PARES', '', 'PR', '44', 'Activo'),
(3, 'PAQUETES', '', 'PK', '43', 'Activo'),
(4, 'BOLSAS', '', 'BG', '04', 'Activo'),
(5, 'ROLLOS\r\n', '', 'RLL', '05', 'Activo'),
(6, 'BALONES', '', 'BL', '06', 'Activo'),
(7, 'UNIDADES\r\n', '', 'UND', '07', 'Activo'),
(8, 'LITROS\r\n', '', 'LT', '08', 'Activo'),
(9, 'GALONES\r\n', '', 'GL', '09', 'Activo'),
(10, 'BARRILES\r\n', '', 'BR', '10', 'Activo'),
(11, 'LATAS\r\n', '', 'LAT', '11', 'Activo'),
(12, 'CAJAS\r\n', '', 'CJA', '12', 'Activo'),
(13, 'MILLARES\r\n', '', 'MIL', '13', 'Activo'),
(14, 'METROS CÚBICOS\r\n', '', 'MC3', '14', 'Activo'),
(15, 'METROS\r\n', '', 'MTS', '15', 'Activo'),
(16, 'OTROS (ESPECIFICAR)\r\n', '', ' ', '99', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `tipo` enum('producto','servicio') DEFAULT 'producto',
  `codproducto` varchar(50) DEFAULT NULL,
  `codbarras` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `presentacion_minima` int(11) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `proveedor_idproveedor` int(11) DEFAULT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `und_ingresadas` decimal(18,2) DEFAULT '0.00',
  `und_salidas` int(11) DEFAULT '0',
  `area_idarea` int(11) DEFAULT NULL,
  `control_stock` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `tipo`, `codproducto`, `codbarras`, `nombre`, `descripcion`, `presentacion_minima`, `estado`, `proveedor_idproveedor`, `precio_venta`, `precio_unitario`, `und_ingresadas`, `und_salidas`, `area_idarea`, `control_stock`) VALUES
(1, 'producto', '006', NULL, 'BOCINA DE TRAPECIO', NULL, 7, 'Activo', NULL, '1.50', '0.82', '0.00', 0, 5, 280),
(2, 'producto', '008', NULL, 'CABLE AUTOMOTRIZ', NULL, 5, 'Activo', NULL, '40.00', '35.00', '10.00', 0, 2, 2),
(3, 'producto', '012', NULL, 'CADENA 150 L', NULL, 7, 'Activo', NULL, '17.00', '13.35', '0.00', 0, 2, 10),
(4, 'producto', '019', NULL, 'CARRETE COMPLETO', NULL, 7, 'Activo', NULL, '38.50', '0.00', '128.50', 21, 2, 60),
(5, 'producto', '021', NULL, 'CATALINA 37T', NULL, 7, 'Activo', NULL, '7.00', '0.00', '9.50', 3, 2, 15),
(6, 'producto', '022', NULL, 'CATALINA 42T', NULL, 7, 'Activo', NULL, '10.00', '7.40', '0.00', 0, 2, 15),
(7, 'producto', '023', NULL, 'CATALINA 49T', NULL, 7, 'Activo', NULL, '18.00', '12.00', '0.00', 0, 2, 20),
(8, 'producto', '027', NULL, 'CINTA AISLANTE', NULL, 7, 'Activo', NULL, '2.50', '1.90', '0.00', 0, 2, 30),
(9, 'producto', '028', NULL, 'COLETA CG', NULL, 7, 'Activo', NULL, '2.00', '0.59', '272.00', 0, 2, 120),
(10, 'producto', '029', NULL, 'FARO DIRECCIONAL GL', NULL, 7, 'Activo', NULL, '5.00', '2.75', '245.00', 0, 2, 120),
(11, 'producto', '030', NULL, 'DISCO DE CORTE N° 14', NULL, 7, 'Activo', NULL, '20.00', '16.00', '0.00', 0, 5, 10),
(12, 'producto', '032', NULL, 'DOBLE FAZ HONDA AÑIL', NULL, 15, 'Activo', NULL, '15.00', '12.00', '50.00', 0, 6, 70),
(13, 'producto', '033', NULL, 'DOBLE FAZ HONDA ROJO PERÚ', NULL, 15, 'Activo', NULL, '15.00', '11.00', '0.00', 0, 6, 70),
(14, 'producto', '038', NULL, 'ESPUMA 1/2', NULL, 7, 'Activo', NULL, '17.00', '13.00', '0.00', 0, 6, 15),
(15, 'producto', '039', NULL, 'ESPUMA ZEBRA 200', NULL, 7, 'Activo', NULL, '100.00', '84.00', '0.00', 0, 6, 25),
(16, 'producto', '040', NULL, 'ESPUMA ZEBRA 400', NULL, 7, 'Activo', NULL, '104.00', '120.00', '0.00', 0, 6, 25),
(17, 'producto', '042', NULL, 'FARO POSTERIOR C/PORTA PLACA', NULL, 7, 'Activo', NULL, '10.00', '6.15', '0.00', 0, 2, 120),
(18, 'producto', '045', NULL, 'FIERRO LISO 1/2', NULL, 7, 'Activo', NULL, '18.00', '13.00', '0.00', 0, 5, 50),
(19, 'producto', '046', NULL, 'FIERRO LISO 3/8', NULL, 7, 'Activo', NULL, '13.00', '8.00', '0.00', 0, 5, 50),
(20, 'producto', '047', NULL, 'FOCO DIRECCIONAL', NULL, 7, 'Activo', NULL, '0.70', '0.32', '493.00', 0, 2, 120),
(21, 'producto', '048', NULL, 'FOCO DE PELIGRO', NULL, 7, 'Activo', NULL, '0.60', '0.42', '369.00', 0, 2, 120),
(22, 'producto', '051', NULL, 'HUACHA DE AMORTIGUADOR PEQUEÑA', NULL, 7, 'Activo', NULL, '0.30', '0.08', '0.00', 0, 2, 250),
(23, 'producto', '052', NULL, 'GRAPAS TRITON 80-10', NULL, 12, 'Activo', NULL, '18.00', '12.00', '0.00', 0, 6, 5),
(24, 'producto', '053', NULL, 'GRASA', NULL, 7, 'Activo', NULL, '15.00', '10.00', '0.00', 0, 2, 15),
(25, 'producto', '054', NULL, 'GUANTES PARA SOLDAR', NULL, 2, 'Activo', NULL, '25.00', '18.00', '0.00', 0, 5, 6),
(26, 'producto', '055', NULL, 'HUACHA DE AMORTIGUADOR GRANDE', NULL, 7, 'Activo', NULL, '0.50', '0.20', '0.00', 0, 2, 250),
(27, 'producto', '056', NULL, 'HILO AZUL', NULL, 7, 'Activo', NULL, '10.00', '7.00', '0.00', 0, 6, 10),
(28, 'producto', '057', NULL, 'HILO NEGRO', NULL, 7, 'Activo', NULL, '10.00', '7.00', '0.00', 0, 6, 10),
(29, 'producto', '058', NULL, 'HILO ROJO', NULL, 7, 'Activo', NULL, '10.00', '7.00', '0.00', 0, 6, 10),
(30, 'producto', '060', NULL, 'HUACHA DE TRAPECIO', NULL, 7, 'Activo', NULL, '0.30', '0.10', '0.00', 0, 2, 50),
(31, 'producto', '063', NULL, 'LIJA AL AGUA N° 220', NULL, 7, 'Activo', NULL, '2.00', '1.00', '0.00', 0, 3, 10),
(32, 'producto', '064', NULL, 'LIJA PARA FIERRO N° 80', NULL, 7, 'Activo', NULL, '3.00', '1.50', '0.00', 0, 3, 10),
(33, 'producto', '066', NULL, 'LINO PESADO AZULINO', NULL, 15, 'Activo', NULL, '12.00', '9.00', '0.00', 0, 6, 70),
(34, 'producto', '067', NULL, 'LINO PESADO ROJO PERÚ', NULL, 15, 'Activo', NULL, '12.00', '9.00', '0.00', 0, 6, 70),
(35, 'producto', '068', NULL, 'LINO PESADO NEGRO', NULL, 15, 'Activo', NULL, '12.00', '9.00', '0.00', 0, 6, 70),
(36, 'producto', '069', NULL, 'MANDIL PARA SOLDAR', NULL, 7, 'Activo', NULL, '25.00', '18.00', '0.00', 0, 5, 5),
(37, 'producto', '072', NULL, 'MARROQUI', NULL, 15, 'Activo', NULL, '12.50', '14.00', '100.00', 0, 6, 100),
(38, 'producto', '073', NULL, 'MEZCLA MIG 80/20', NULL, 6, 'Activo', NULL, '250.00', '280.00', '3.00', 0, 5, 8),
(39, 'producto', '074', NULL, 'MICA POLARIZADA', NULL, 15, 'Activo', NULL, '12.00', '8.20', '0.00', 0, 6, 40),
(40, 'producto', '079', NULL, 'PEGA PEGA 50MM', NULL, 5, 'Activo', NULL, '24.00', '17.00', '0.00', 0, 6, 10),
(41, 'producto', '080', NULL, 'PERNO CABEZA COCHE 1/4 x 1', NULL, 7, 'Activo', NULL, '1.00', '0.00', '0.00', 10, 6, 1500),
(42, 'producto', '081', NULL, 'PERNO 3/8 x 1Y1/4 (CARRETE)', NULL, 7, 'Activo', NULL, '0.80', '0.21', '0.00', 0, 2, 700),
(43, 'producto', '082', NULL, 'PERNO 8x20 (CARROCERÍA)', NULL, 7, 'Activo', NULL, '0.60', '0.00', '0.00', 10, 2, 700),
(44, 'producto', '083', NULL, 'PERNO M-5x25 (FARO POSTERIOR)', NULL, 7, 'Activo', NULL, '0.30', '0.07', '0.00', 0, 2, 50),
(45, 'producto', '084', NULL, 'PERNO M-6x30 (FARO DIRECCIONAL)', NULL, 7, 'Activo', NULL, '0.40', '0.07', '1253.00', 0, 2, 200),
(46, 'producto', '085', NULL, 'PERNO M-6x20 (VARILLA DE FRENO)', NULL, 7, 'Activo', NULL, '0.30', '0.06', '2655.00', 0, 2, 300),
(47, 'producto', '086', NULL, 'PERNO 1/4 x 1/2 (GUARDAFANGO)', NULL, 7, 'Activo', NULL, '0.50', '0.08', '0.00', 0, 2, 300),
(48, 'producto', '087', NULL, 'PIN DE AMORTIGUADOR', NULL, 7, 'Activo', NULL, '2.00', '0.82', '0.00', 0, 5, 300),
(49, 'producto', '088', NULL, 'PINTURA GLOSS NEGRO', NULL, 9, 'Activo', NULL, '100.00', '70.00', '0.00', 0, 3, 4),
(50, 'producto', '109', NULL, 'REMACHES 5/32 x 3/4', NULL, 7, 'Activo', NULL, '0.30', '0.03', '0.00', 0, 6, 1500),
(51, 'producto', '110', NULL, 'RESORTE INTERNO DE BARRA', NULL, 2, 'Activo', NULL, '17.00', '10.47', '118.00', 0, 2, 70),
(52, 'producto', '111', NULL, 'RIBETE NEGRO', NULL, 1, 'Activo', NULL, '12.00', '7.00', '0.00', 0, 6, 12),
(53, 'producto', '112', NULL, 'RIBETE ROJO', NULL, 1, 'Activo', NULL, '20.00', '14.00', '0.00', 0, 6, 12),
(54, 'producto', '113', NULL, 'RODAJE 6302', NULL, 7, 'Activo', NULL, '5.00', '1.86', '306.00', 0, 2, 120),
(55, 'producto', '117', NULL, 'SIERRA', NULL, 7, 'Activo', NULL, '6.00', '4.00', '0.00', 0, 5, 20),
(56, 'producto', '119', NULL, 'DRIZA', NULL, 1, 'Activo', NULL, '25.00', '20.00', '0.00', 0, 6, 5),
(57, 'producto', '120', NULL, 'SOLDADURA PUNTO AZUL', NULL, 3, 'Activo', NULL, '18.00', '12.00', '0.00', 0, 5, 5),
(58, 'producto', '121', NULL, 'SOLDADURA MIG', NULL, 7, 'Activo', NULL, '100.00', '80.00', '0.00', 0, 5, 10),
(59, 'producto', '132', NULL, 'GUARDAFANGO AZUL', NULL, 7, 'Activo', NULL, '22.00', '20.00', '56.00', 0, 2, 70),
(60, 'producto', '133', NULL, 'GUARDAFANGO ROJO', NULL, 7, 'Activo', NULL, '22.00', '20.00', '24.00', 0, 2, 70),
(61, 'producto', '134', NULL, 'TEMPLADOR DE CARRETE', NULL, 7, 'Activo', NULL, '1.00', '0.40', '0.00', 0, 2, 120),
(62, 'producto', '135', NULL, 'TEROCAL', NULL, 11, 'Activo', NULL, '200.00', '155.00', '0.00', 0, 6, 3),
(63, 'producto', '136', NULL, 'THINNER', NULL, 9, 'Activo', NULL, '24.00', '18.00', '12.00', 0, 3, 6),
(64, 'producto', '137', NULL, 'TIRAFON 1/4 x 1Y1/2', NULL, 7, 'Activo', NULL, '0.40', '0.07', '2600.00', 0, 6, 300),
(65, 'producto', '140', NULL, 'TUBO ELECTRO SOLDADO 1 x 1.5 x 6 M', NULL, 7, 'Activo', NULL, '28.00', '21.00', '0.00', 0, 5, 40),
(66, 'producto', '141', NULL, 'TUBO ELECTRO SOLDADO 1/2 x 1.2 x 6 M', NULL, 7, 'Activo', NULL, '16.00', '11.00', '0.00', 0, 5, 100),
(67, 'producto', '142', NULL, 'TUBO ELECTRO SOLDADO 3/4 x 1.5 x 6 M', NULL, 7, 'Activo', NULL, '23.00', '16.00', '0.00', 0, 5, 100),
(68, 'producto', '143', NULL, 'TUBO ELECTRO SOLDADO 5/8 x 1.2 x 6 M', NULL, 7, 'Activo', NULL, '15.00', '11.00', '0.00', 0, 5, 20),
(69, 'producto', '145', NULL, 'TUBO NEGRO REDONDO 1 x 2.5 x 6.4 M', NULL, 7, 'Activo', NULL, '55.00', '43.50', '0.00', 0, 5, 150),
(70, 'producto', '146', NULL, 'TUBO NEGRO REDONDO 1/2 x 1.8 x 6 M', NULL, 7, 'Activo', NULL, '19.50', '26.00', '0.00', 0, 5, 150),
(71, 'producto', '147', NULL, 'TUBO NEGRO REDONDO 3/4 x 2.5 x 6.4 M', NULL, 7, 'Activo', NULL, '42.00', '34.50', '0.00', 0, 5, 150),
(72, 'producto', '148', NULL, 'TUERCA DE ESPEJO', NULL, 7, 'Activo', NULL, '0.50', '0.13', '0.00', 0, 2, 120),
(73, 'producto', '154', NULL, 'VINIPISO 1.25M', NULL, 15, 'Activo', NULL, '11.00', '8.00', '0.00', 0, 6, 60),
(74, 'producto', '155', NULL, 'VINIPISO 1.50M', NULL, 15, 'Activo', NULL, '12.50', '9.30', '0.00', 0, 6, 60),
(75, 'producto', '159', NULL, 'PINTURA PARA ESTAMPAR BLANCO', NULL, 1, 'Activo', NULL, '42.00', '37.00', '0.00', 0, 6, 3),
(76, 'producto', '160', NULL, 'ANGULO DE ALUMINIO 3/4', NULL, 7, 'Activo', NULL, '9.00', '6.38', '0.00', 0, 6, 60),
(77, 'producto', '162', NULL, 'TUERCA CIEGA DE AMORTIGUADOR', NULL, 7, 'Activo', NULL, '1.00', '0.33', '1424.00', 0, 2, 250),
(78, 'producto', '164', NULL, 'DOBLE FAZ HONDA NEGRO', NULL, 15, 'Activo', NULL, '16.00', '12.00', '72.00', 0, 6, 60),
(79, 'producto', '166', NULL, 'DISCO DE CORTE METAL N° 4', NULL, 7, 'Activo', NULL, '4.00', '2.00', '0.00', 0, 5, 15),
(80, 'producto', '172', NULL, 'TRIPLEY 10MM', NULL, 7, 'Activo', NULL, '50.00', '44.00', '0.00', 0, 6, 60),
(81, 'producto', '173', NULL, 'TRIPLEY 8MM', NULL, 7, 'Activo', NULL, '45.00', '38.00', '0.00', 0, 6, 20),
(82, 'producto', '174', NULL, 'GUARDAFANGO NEGRO', NULL, 7, 'Activo', NULL, '22.00', '16.00', '0.00', 0, 2, 50),
(83, 'producto', '175', NULL, 'REMACHE DE FIERRO 1/4 x 1/2', NULL, 7, 'Activo', NULL, '0.30', '0.05', '0.00', 0, 5, 200),
(84, 'producto', '176', NULL, 'DOBLE FAZ HONDA PLATA', NULL, 15, 'Activo', NULL, '16.00', '11.00', '0.00', 0, 6, 30),
(85, 'producto', '177', NULL, 'COLOMBIANO ROJO', NULL, 15, 'Activo', NULL, '16.00', '11.00', '0.00', 0, 6, 30),
(86, 'producto', '178', NULL, 'COLOMBIANO AZUL', NULL, 15, 'Activo', NULL, '16.00', '11.00', '0.00', 0, 6, 30),
(87, 'producto', '179', NULL, 'GAS PARA HORNO', NULL, 1, 'Activo', NULL, '10.00', '6.50', '0.00', 0, 3, 70),
(88, 'producto', '182', NULL, 'TUERCAS 10MM', NULL, 7, 'Activo', NULL, '0.10', '0.02', '5514.00', 0, 2, 700),
(89, 'producto', '183', NULL, 'ACONDICIONADOR', NULL, 9, 'Activo', NULL, '44.00', '0.00', '8.80', 5, 3, 10),
(90, 'producto', '188', NULL, 'LATA GALVANIZADA 1/40', NULL, 7, 'Activo', NULL, '30.00', '20.00', '0.00', 0, 5, 5),
(91, 'producto', '190', NULL, 'PINTURA EN POLVO NEGRO', NULL, 1, 'Activo', NULL, '20.00', '12.50', '0.00', 0, 3, 25),
(92, 'producto', '191', NULL, 'PINTURA SPRAY AZUL', NULL, 7, 'Activo', NULL, '8.00', '3.80', '0.00', 0, 3, 10),
(93, 'producto', '192', NULL, 'PINTURA SPRAY ROJO', NULL, 7, 'Activo', NULL, '7.00', '3.80', '0.00', 0, 3, 10),
(94, 'producto', '289', NULL, 'CATALINA 45T', NULL, 7, 'Activo', NULL, '12.00', '7.70', '40.00', 0, 2, 30),
(95, 'producto', '253', NULL, 'GUANTES NITRON (ACIDO)', NULL, 2, 'Activo', NULL, '15.00', '9.90', '4.00', 0, 3, 5),
(96, 'producto', '193', NULL, 'PINTURA SPRAY NEGRO', NULL, 7, 'Activo', NULL, '7.00', '3.25', '95.00', 0, 3, 20);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `producto_stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `producto_stock` (
`idproducto` int(11)
,`codproducto` varchar(5)
,`producto` varchar(100)
,`presentacion` varchar(50)
,`precio_venta` decimal(10,2)
,`precio_compra` decimal(10,2)
,`ingresado` decimal(18,2)
,`salido` bigint(11)
,`stock` decimal(19,2)
,`estado` varchar(48)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idproveedor` int(11) NOT NULL,
  `razon_social` varchar(200) DEFAULT NULL,
  `nombre_comercial` varchar(200) DEFAULT NULL,
  `ruc` varchar(11) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `contacto` varchar(20) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idproveedor`, `razon_social`, `nombre_comercial`, `ruc`, `direccion`, `contacto`, `fecha_creacion`, `estado`) VALUES
(1, 'EL GATO S.A.C', 'COMERCIAL EL GATO S.A.C', '20393654059', 'AV. VIA DE EVITEMIENTO', '943926474', '2020-01-10 09:26:01', 'Activo'),
(2, 'MADEC S.R.L', 'MATERIALES ADITIVOS Y DERIVADOS PARA LA CONSTRUCCIÓN S.R.L', '20404175166', 'JR: RICARDO PALMA N° 498 - TARAPOTO', '942620159', '2020-01-10 09:33:44', 'Activo'),
(3, 'FACTORÍA INDUSTRIAL MEUSER', 'FACTORÍA INDUSTRIAL MEUSER', '10011627001', 'JR: MARTINEZ DE COMPAGÑON N° 1309 - TARAPOTO', '942822320', '2020-01-10 09:38:45', 'Activo'),
(4, 'COMERCIAL FERRETERÍA SELVA E.I.R.L', 'COMERCIAL FERRETERÍA SELVA E.I.R.L', '20542310163', 'JR: SHAPAJA N° 282 - TARAPOTO', '942471434', '2020-01-10 09:42:31', 'Activo'),
(5, 'PERNOS Y REPUESTOS \"SANTA ROSA\"', 'GRUPO HECALIRO JIA S.A.C', '20450481875', 'AV: VIA DE EVITAMIENTO N° 402 - TARAPOTO', '-', '2020-01-10 09:48:51', 'Activo'),
(6, 'OXIGENO ALFA MEDICAL S.A.C', 'OXIGENO ALFA MEDICAL S.A.C', '20572100368', 'NUEVA VIA DE EVITAMIENTO KM 3.5 - MORALES', '971375211', '2020-01-10 09:58:27', 'Activo'),
(7, 'SOCCOPUR S.A.C', 'SOCCOPUR S.A.C', '20128967606', 'JR: RAMIREZ HURTADO N° 297 - TARAPOTO', '042523015', '2020-01-10 10:13:14', 'Activo'),
(8, 'GRUPO CONTISEL S.A.C', 'GRUPO CONTISEL S.A.C', '20601035929', 'JR: TAHUANTINSUYO N° 227 - TARAPOTO', '952328042', '2020-01-10 10:16:56', 'Activo'),
(9, 'PROMART', 'HOMECENTERS PERUANOS S.A', '20536557858', 'Av. SALAVERRY CUADRA 24 S/N', '-', '2020-01-10 10:20:46', 'Activo'),
(10, 'SALDAÑA S.A.C', 'IMPORTADORES Y DISTRIBUIDORES SALDAÑA S.A.C', '20487855902', 'CALLE MIRALOVERDE N° 161 - LAS BRISAS - CHICLAYO', '956481569', '2020-01-10 10:37:22', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida`
--

CREATE TABLE `salida` (
  `idsalida` int(11) NOT NULL,
  `tienda_idtienda` int(11) DEFAULT NULL,
  `colaborador_registro` int(11) DEFAULT NULL,
  `tipo_comprobante_idtipo_comprobante` int(11) DEFAULT NULL,
  `nrocomprobante` varchar(50) DEFAULT NULL,
  `motivo_movimiento_idmotivo` int(11) DEFAULT NULL,
  `nombre_recepciona` varchar(150) DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `serie` varchar(100) DEFAULT NULL,
  `motor` varchar(100) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `estado` enum('vigente','anulado') DEFAULT 'vigente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `salida`
--

INSERT INTO `salida` (`idsalida`, `tienda_idtienda`, `colaborador_registro`, `tipo_comprobante_idtipo_comprobante`, `nrocomprobante`, `motivo_movimiento_idmotivo`, `nombre_recepciona`, `observacion`, `fecha_emision`, `fecha_creacion`, `serie`, `motor`, `color`, `estado`) VALUES
(1, 1, 1, 2, 'fichA 01', 2, 'JUAN', '', '2020-07-31', '2020-07-31 12:29:10', '', '', 'ROJO', 'vigente'),
(2, 1, 1, 2, '0002', 2, 'NELSON', 'MATERIAL FALLIDO', '2020-07-31', '2020-07-31 12:33:15', '', '', '', 'vigente'),
(3, 1, 1, 2, '', 1, '', '', '2021-05-31', '2021-05-31 21:19:59', '', '', '', 'vigente'),
(4, 1, 1, 2, '3333', 1, '', '', '2021-05-31', '2021-05-31 21:21:41', '', '', '', 'vigente'),
(5, 1, 1, 2, '', 1, '', '', '2021-05-31', '2021-05-31 21:23:12', '', '', '', 'vigente'),
(6, 1, 1, 2, '', 1, '', '', '2021-05-31', '2021-05-31 21:25:00', '', '', '', 'vigente'),
(7, 1, 1, 2, '', 1, '', '', '2021-05-31', '2021-05-31 21:26:29', '', '', '', 'vigente'),
(8, 1, 1, 2, '', 1, '', '', '2021-05-31', '2021-05-31 21:34:34', '', '', '', 'vigente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seg_menus`
--

CREATE TABLE `seg_menus` (
  `id_modulo` int(11) DEFAULT NULL,
  `id_perfil` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `seg_menus`
--

INSERT INTO `seg_menus` (`id_modulo`, `id_perfil`, `priority`) VALUES
(5, 1, 14),
(6, 1, 13),
(10, 1, 10),
(7, 1, 11),
(9, 1, 12),
(11, 1, 9),
(17, 3, 0),
(16, 3, 1),
(3, 2, 18),
(8, 2, 19),
(10, 2, 20),
(11, 2, 21),
(18, 2, 22),
(17, 2, 23),
(14, 2, 24),
(21, 2, 25),
(16, 2, 26),
(2, 2, 27),
(7, 2, 28),
(13, 2, 29),
(28, 1, 8),
(29, 2, 6),
(31, 2, 7),
(27, 2, 8),
(5, 2, 9),
(25, 2, 10),
(26, 2, 11),
(30, 2, 12),
(6, 2, 13),
(24, 2, 14),
(9, 2, 15),
(23, 2, 16),
(22, 2, 17),
(32, 2, 3),
(35, 2, 4),
(34, 2, 5),
(36, 2, 0),
(38, 2, 1),
(37, 2, 2),
(36, 1, 5),
(38, 1, 6),
(37, 1, 7),
(39, 1, 4),
(41, 1, 3),
(42, 1, 2),
(43, 1, 1),
(44, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seg_modulo`
--

CREATE TABLE `seg_modulo` (
  `id_modulo` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `nivel` enum('primer','segundo','tercer') DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `id_modulo_padre` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `seg_modulo`
--

INSERT INTO `seg_modulo` (`id_modulo`, `nombre`, `url`, `nivel`, `icono`, `id_modulo_padre`, `orden`, `descripcion`) VALUES
(1, 'Administrativo', '#', 'primer', ' fa-wrench', NULL, 2, NULL),
(4, 'Seguridad', '#', 'primer', 'fa-key', NULL, 1, NULL),
(5, 'Modulos', 'seguridad/modulos', 'segundo', 'fa-tasks', 4, 1, NULL),
(6, 'Perfiles', 'seguridad/perfiles', 'segundo', 'fa fa-users', 4, 2, NULL),
(7, 'Productos', 'productos/lista', 'segundo', 'fa-cubes', 1, 3, NULL),
(9, 'Proveedores', 'proveedores/lista', 'segundo', 'fa-bus', 1, 5, NULL),
(10, 'Colaboradores', 'colaboradores/lista', 'segundo', 'fa-home', 4, 6, NULL),
(11, 'Comprobantes', 'comprobantes/lista', 'segundo', 'fa-file-text-o', 1, 6, NULL),
(12, 'Almacén', '#', 'primer', 'fa-angle-left pull-right', NULL, 3, NULL),
(19, 'Compras', '#', 'primer', 'fa-suitcase', NULL, 5, NULL),
(20, 'Reportes', '#', 'primer', 'fa-text', NULL, 6, NULL),
(28, 'CPE', '#', 'primer', 'fa fa-cloud', NULL, 9, NULL),
(33, 'Documentación', '#', 'primer', 'fa-key', NULL, 8, NULL),
(36, 'Area', 'areas/lista', 'segundo', 'fa fa-home', 1, 7, NULL),
(37, 'Unidades medida', 'unidades_medida/lista', 'segundo', 'fa fa-th', 1, 8, NULL),
(38, 'Motivos', 'motivos_movimiento/lista', 'segundo', 'fa fa-arrows', 1, 9, NULL),
(39, 'Ingresos', 'ingresos/lista', 'segundo', 'fa fa-chevron-left', 12, 5, NULL),
(42, 'salidas', 'salidas/lista', 'segundo', 'fa-key', 12, 2, NULL),
(43, 'Stock', 'almacenes/stock', 'segundo', 'fa fa-box', 12, 3, NULL),
(44, 'Reporte creditos', 'creditos', 'segundo', 'fa-file-word-o', 20, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seg_perfil`
--

CREATE TABLE `seg_perfil` (
  `id_perfil` int(255) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `seg_perfil`
--

INSERT INTO `seg_perfil` (`id_perfil`, `nombre`, `descripcion`) VALUES
(1, 'Master ', NULL),
(2, 'Administrador', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serie_comprobante`
--

CREATE TABLE `serie_comprobante` (
  `idserie_comprobante` int(11) NOT NULL,
  `tipo_comprobante_idtipocomprobante` int(11) DEFAULT NULL,
  `serie` varchar(50) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `titulo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `serie_comprobante`
--

INSERT INTO `serie_comprobante` (`idserie_comprobante`, `tipo_comprobante_idtipocomprobante`, `serie`, `correlativo`, `fecha_creacion`, `estado`, `titulo`) VALUES
(1, 1, '001', 1, NULL, 'Activo', NULL),
(2, 2, 'F001', 5, NULL, 'Activo', NULL),
(3, 3, 'B001', 1, NULL, 'Activo', NULL),
(4, 4, '001', 3, NULL, 'Activo', NULL),
(5, 5, 'NE', 1, NULL, 'Activo', NULL),
(6, 6, 'NS', 1, NULL, 'Activo', NULL),
(7, 7, 'CERT', 2, NULL, 'Activo', NULL),
(8, 8, 'CONST', 1, NULL, 'Activo', NULL),
(9, 9, 'ACT', 1, NULL, 'Activo', NULL),
(10, 10, 'CER', 14, NULL, 'Activo', ''),
(11, 11, 'G001', 1, NULL, 'Activo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `idstock` int(11) NOT NULL,
  `tienda_idtienda` int(11) DEFAULT NULL,
  `producto_idproducto` int(11) DEFAULT NULL,
  `stock_almacen` int(11) DEFAULT NULL,
  `stock_mostrador` decimal(18,2) DEFAULT NULL,
  `ultimo_ingreso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE `tienda` (
  `idtienda` int(11) NOT NULL,
  `codtienda` varchar(50) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tienda`
--

INSERT INTO `tienda` (`idtienda`, `codtienda`, `descripcion`, `observacion`, `estado`) VALUES
(1, '001', 'Tienda 1', NULL, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_comprobante`
--

CREATE TABLE `tipo_comprobante` (
  `idtipo_comprobante` int(11) NOT NULL,
  `codsunat` varchar(50) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `abreviatura` varchar(50) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `codigo_nubefact` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_comprobante`
--

INSERT INTO `tipo_comprobante` (`idtipo_comprobante`, `codsunat`, `descripcion`, `abreviatura`, `estado`, `codigo_nubefact`) VALUES
(1, NULL, 'Ticket', 'TIC', 'Activo', NULL),
(2, '01', 'Factura', 'FAC', 'Activo', 1),
(3, '03', 'Boleta', 'BOL', 'Activo', 2),
(4, NULL, 'Proforma', 'PRO', 'Activo', NULL),
(5, NULL, 'Nota entrada', 'NE', 'Activo', NULL),
(6, NULL, 'Nota salida', 'NS', 'Activo', NULL),
(7, NULL, 'Certificado', 'CTF', 'Activo', NULL),
(8, NULL, 'Constancia', 'CTC', 'Inactivo', NULL),
(9, NULL, 'Acta', 'Acta', 'Inactivo', NULL),
(10, NULL, 'Certificado', 'CER', 'Activo', NULL),
(11, NULL, 'Guia remisión', 'GUIA', 'Activo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `idtipo_pago` int(11) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `abreviatura` varchar(10) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`idtipo_pago`, `descripcion`, `abreviatura`, `estado`) VALUES
(1, 'Efectivo', 'efect.', 'Activo'),
(2, 'Deposito', 'Depos.', 'Activo'),
(3, 'Cheque', 'cheque', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `idunidad_medida` int(11) NOT NULL,
  `presentacion_idpresentacion` int(11) DEFAULT NULL,
  `producto_idproducto` int(11) DEFAULT NULL,
  `cantidad` decimal(18,2) DEFAULT NULL,
  `precio_compra` decimal(18,2) DEFAULT NULL,
  `precio_venta` decimal(18,2) DEFAULT NULL,
  `utilidad` decimal(18,2) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura para la vista `creditos`
--
DROP TABLE IF EXISTS `creditos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `creditos`  AS  select `ing`.`idingreso` AS `idingreso`,'Credito' AS `pedido`,`ing`.`estado_pago` AS `estado`,`pro`.`razon_social` AS `razon_social`,`ing`.`fecha_compra` AS `fecha_compra`,`ing`.`fecha_recepcion` AS `fecha_recepcion`,`tc`.`descripcion` AS `descripcion`,`ing`.`nrocomprobante` AS `nrocomprobante`,`ing`.`total` AS `total`,'.....................' AS `observacion` from ((`ingreso` `ing` join `proveedor` `pro` on((`ing`.`proveedor_idproveedor` = `pro`.`idproveedor`))) join `tipo_comprobante` `tc` on((`ing`.`tipo_comprobante_idtipo_comprobante` = `tc`.`idtipo_comprobante`))) where (`ing`.`idperiodo_pago` = 2) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `producto_stock`
--
DROP TABLE IF EXISTS `producto_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `producto_stock`  AS  select `pro`.`idproducto` AS `idproducto`,lpad(`pro`.`codproducto`,5,'0') AS `codproducto`,`pro`.`nombre` AS `producto`,`pre`.`abreviatura` AS `presentacion`,coalesce(`pro`.`precio_venta`,0) AS `precio_venta`,coalesce(`pro`.`precio_unitario`,0) AS `precio_compra`,coalesce(`pro`.`und_ingresadas`,0) AS `ingresado`,coalesce(`pro`.`und_salidas`,0) AS `salido`,coalesce((`pro`.`und_ingresadas` - `pro`.`und_salidas`),0) AS `stock`,(case when (coalesce(`pro`.`control_stock`,0) = 0) then 'RANGO NO DEFINIDO' when (coalesce((`pro`.`und_ingresadas` - `pro`.`und_salidas`),0) >= coalesce(`pro`.`control_stock`,0)) then '<span class=\'suficiente_stock\'>SUFICIENTE</span>' else '<span class=\'comprar_stock\'>COMPRAR</span>' end) AS `estado` from (`producto` `pro` left join `presentacion` `pre` on((`pre`.`idpresentacion` = `pro`.`presentacion_minima`))) order by `pro`.`nombre` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`idarea`);

--
-- Indices de la tabla `colaborador`
--
ALTER TABLE `colaborador`
  ADD PRIMARY KEY (`idcolaborador`);

--
-- Indices de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD PRIMARY KEY (`iddetalle_ingreso`),
  ADD KEY `ingreso_idingreso` (`ingreso_idingreso`);

--
-- Indices de la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  ADD PRIMARY KEY (`iddetalle_salida`),
  ADD KEY `ingreso_idingreso` (`salida_idsalida`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `proveedor_idproveedor` (`proveedor_idproveedor`),
  ADD KEY `colaborador_recepcion` (`colaborador_recepcion`),
  ADD KEY `colaborador_registro` (`colaborador_registro`),
  ADD KEY `tipo_comprobante_idtipo_comprobante` (`tipo_comprobante_idtipo_comprobante`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`idkardex`),
  ADD KEY `producto_idproducto` (`producto_idproducto`),
  ADD KEY `stock_idstock` (`tienda_idtienda`);

--
-- Indices de la tabla `motivo_movimiento`
--
ALTER TABLE `motivo_movimiento`
  ADD PRIMARY KEY (`idmotivo`);

--
-- Indices de la tabla `periodo_pago`
--
ALTER TABLE `periodo_pago`
  ADD PRIMARY KEY (`idperiodo_pago`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`idpresentacion`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idproveedor`);

--
-- Indices de la tabla `salida`
--
ALTER TABLE `salida`
  ADD PRIMARY KEY (`idsalida`),
  ADD KEY `colaborador_registro` (`colaborador_registro`),
  ADD KEY `tipo_comprobante_idtipo_comprobante` (`tipo_comprobante_idtipo_comprobante`);

--
-- Indices de la tabla `seg_modulo`
--
ALTER TABLE `seg_modulo`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `seg_perfil`
--
ALTER TABLE `seg_perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `serie_comprobante`
--
ALTER TABLE `serie_comprobante`
  ADD PRIMARY KEY (`idserie_comprobante`),
  ADD KEY `tipo_comprobante_idtipocomprobante` (`tipo_comprobante_idtipocomprobante`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idstock`),
  ADD KEY `tienda_idtienda` (`tienda_idtienda`),
  ADD KEY `producto_idproducto` (`producto_idproducto`);

--
-- Indices de la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`idtienda`);

--
-- Indices de la tabla `tipo_comprobante`
--
ALTER TABLE `tipo_comprobante`
  ADD PRIMARY KEY (`idtipo_comprobante`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`idtipo_pago`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`idunidad_medida`),
  ADD KEY `presentacion_idpresentacion` (`presentacion_idpresentacion`),
  ADD KEY `producto_idproducto` (`producto_idproducto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `idarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `colaborador`
--
ALTER TABLE `colaborador`
  MODIFY `idcolaborador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  MODIFY `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  MODIFY `iddetalle_salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `idkardex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `motivo_movimiento`
--
ALTER TABLE `motivo_movimiento`
  MODIFY `idmotivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `periodo_pago`
--
ALTER TABLE `periodo_pago`
  MODIFY `idperiodo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `idpresentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `salida`
--
ALTER TABLE `salida`
  MODIFY `idsalida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `seg_modulo`
--
ALTER TABLE `seg_modulo`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `seg_perfil`
--
ALTER TABLE `seg_perfil`
  MODIFY `id_perfil` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `serie_comprobante`
--
ALTER TABLE `serie_comprobante`
  MODIFY `idserie_comprobante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `idstock` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tienda`
--
ALTER TABLE `tienda`
  MODIFY `idtienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_comprobante`
--
ALTER TABLE `tipo_comprobante`
  MODIFY `idtipo_comprobante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `idtipo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `idunidad_medida` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD CONSTRAINT `detalle_ingreso_ibfk_1` FOREIGN KEY (`ingreso_idingreso`) REFERENCES `ingreso` (`idingreso`);

--
-- Filtros para la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  ADD CONSTRAINT `detalle_salida_ibfk_1` FOREIGN KEY (`salida_idsalida`) REFERENCES `salida` (`idsalida`);

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `ingreso_ibfk_1` FOREIGN KEY (`proveedor_idproveedor`) REFERENCES `proveedor` (`idproveedor`),
  ADD CONSTRAINT `ingreso_ibfk_2` FOREIGN KEY (`colaborador_recepcion`) REFERENCES `colaborador` (`idcolaborador`),
  ADD CONSTRAINT `ingreso_ibfk_3` FOREIGN KEY (`colaborador_registro`) REFERENCES `colaborador` (`idcolaborador`),
  ADD CONSTRAINT `ingreso_ibfk_4` FOREIGN KEY (`tipo_comprobante_idtipo_comprobante`) REFERENCES `tipo_comprobante` (`idtipo_comprobante`);

--
-- Filtros para la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD CONSTRAINT `kardex_ibfk_1` FOREIGN KEY (`producto_idproducto`) REFERENCES `producto` (`idproducto`);

--
-- Filtros para la tabla `salida`
--
ALTER TABLE `salida`
  ADD CONSTRAINT `salida_ibfk_3` FOREIGN KEY (`colaborador_registro`) REFERENCES `colaborador` (`idcolaborador`),
  ADD CONSTRAINT `salida_ibfk_4` FOREIGN KEY (`tipo_comprobante_idtipo_comprobante`) REFERENCES `tipo_comprobante` (`idtipo_comprobante`);

--
-- Filtros para la tabla `serie_comprobante`
--
ALTER TABLE `serie_comprobante`
  ADD CONSTRAINT `serie_comprobante_ibfk_1` FOREIGN KEY (`tipo_comprobante_idtipocomprobante`) REFERENCES `tipo_comprobante` (`idtipo_comprobante`);

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`tienda_idtienda`) REFERENCES `tienda` (`idtienda`),
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`producto_idproducto`) REFERENCES `producto` (`idproducto`);

--
-- Filtros para la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD CONSTRAINT `unidad_medida_ibfk_1` FOREIGN KEY (`presentacion_idpresentacion`) REFERENCES `presentacion` (`idpresentacion`),
  ADD CONSTRAINT `unidad_medida_ibfk_2` FOREIGN KEY (`producto_idproducto`) REFERENCES `producto` (`idproducto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
