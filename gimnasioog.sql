-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2025 a las 02:11:40
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gimnasio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidos`
--

CREATE TABLE `contenidos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `tipo` enum('rutina','habito') DEFAULT NULL,
  `objetivo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contenidos`
--

INSERT INTO `contenidos` (`id`, `titulo`, `tipo`, `objetivo`, `descripcion`) VALUES
(1, 'Dia 1 - Principiantes', 'rutina', 'Ganar musculo', 'Dirigido a mujeres. Duracion de la rutina: 5 Dias a la semana. \r\nLunes: Pierna (Femoral, Cuadricep y Pantorrilla)\r\nMartes: Espalda (Dorsales, Trapecio y Lumbal)\r\nMiercoles: Gluteo (Medio, Mayor y Femoral)\r\nJueves: Brazo (Hombro, Biceps, Triceps)\r\nViernes: Pierna (Abductores, Cuadriceps, Pantorrilla)\r\n'),
(4, 'Avanzado 2', 'habito', 'Fuerza', 'Domina las dominadas. Un habito muy util para ello es cada dia, hacer 3 ejercicios sin pesas antes de cada entreno, estos son:\r\n1) Cuelgate de la barra por 30 segundos, luego cada semana le subiras 10 segundos mas\r\n2) Intenta subir lentamente y bajar lentamente. 8 Reps\r\n3) Salta e impulsate hasta llegar arriba y baja lentamente. 8 Reps'),
(38, 'Avanzado', 'habito', 'bajar grasa', '------------------------------'),
(39, 'Cardio', 'habito', 'resistencia', 'Domina las dominadas. Un habito muy util para ello es cada dia, hacer 3 ejercicios sin pesas antes de cada entreno, estos son:\r\n1) Cuelgate de la barra por 30 segundos, luego cada semana le subiras 10 segundos mas\r\n2) Intenta subir lentamente y bajar lentamente. 8 Reps\r\n3) Salta e impulsate hasta llegar arriba y baja lentamente. 8 Reps'),
(40, 'Movilidad', 'habito', 'salud general', 'Domina las dominadas. Un habito muy util para ello es cada dia, hacer 3 ejercicios sin pesas antes de cada entreno, estos son:\r\n1) Cuelgate de la barra por 30 segundos, luego cada semana le subiras 10 segundos mas\r\n2) Intenta subir lentamente y bajar lentamente. 8 Reps\r\n3) Salta e impulsate hasta llegar arriba y baja lentamente. 8 Reps'),
(41, 'Movilidad', 'habito', 'salud general', 'Domina las dominadas. Un habito muy util para ello es cada dia, hacer 3 ejercicios sin pesas antes de cada entreno, estos son:\r\n1) Cuelgate de la barra por 30 segundos, luego cada semana le subiras 10 segundos mas\r\n2) Intenta subir lentamente y bajar lentamente. 8 Reps\r\n3) Salta e impulsate hasta llegar arriba y baja lentamente. 8 Reps');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `objetivo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `objetivo`) VALUES
(5, 'JUAN LORA ECHEVERRY', 'tobonflorezi@gmail.com', '$2y$10$zF7YKOKWWFtilQ6mXWiHZOeBwjo98PUSSDADYWQkUf5PP.CtRl0AG', 'user', 'ganar masa'),
(7, 'JUAN LORA ECHEVERRY', 'klmnvhjk@gmail.com', '$2y$10$PyAi/9kgB/qwGohKA6xBiuGGKs.mkahOc/nbek8Jb1kuKVJYqMv8e', 'user', 'ganar masa'),
(8, 'Isabella Tobon', 'hola@gmail.com', '$2y$10$E1DDe770mSk3kaXKEEgN1.GtDvtdstSBDmjdasJCvEh0cn193KqfG', 'user', 'resistencia'),
(9, 'Admin', 'admin@gmail.com', '$2y$10$E1DDe770mSk3kaXKEEgN1.GtDvtdstSBDmjdasJCvEh0cn193KqfG', 'admin', 'administrador'),
(10, 'Diana Marcela', 'isa@gmail.com', '$2y$10$6ObG0o8DLpsbRT/vyd9xe.vdvZzyIO.eQqUmv9RKsVmDE3oIIZ7y6', 'user', 'bajar grasa');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
