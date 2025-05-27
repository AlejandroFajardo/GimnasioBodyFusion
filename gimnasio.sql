SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Caracteres
/*!40101 SET NAMES utf8mb4 */;

-- -------------------------------------------------------------------
-- Tabla: users (SIN MODIFICAR)
-- -------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `users` (
                                       `id` int(11) NOT NULL,
    `name` varchar(100) DEFAULT NULL,
    `email` varchar(100) DEFAULT NULL,
    `password` varchar(255) DEFAULT NULL,
    `role` enum('admin','user') DEFAULT 'user',
    `objetivo` varchar(100) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `objetivo`) VALUES
                                                                                (5, 'JUAN LORA ECHEVERRY', 'tobonflorezi@gmail.com', '$2y$10$zF7YKOKWWFtilQ6mXWiHZOeBwjo98PUSSDADYWQkUf5PP.CtRl0AG', 'user', 'ganar masa'),
                                                                                (7, 'JUAN LORA ECHEVERRY', 'klmnvhjk@gmail.com', '$2y$10$PyAi/9kgB/qwGohKA6xBiuGGKs.mkahOc/nbek8Jb1kuKVJYqMv8e', 'user', 'ganar masa'),
                                                                                (8, 'Isabella Tobon', 'hola@gmail.com', '$2y$10$E1DDe770mSk3kaXKEEgN1.GtDvtdstSBDmjdasJCvEh0cn193KqfG', 'user', 'resistencia'),
                                                                                (9, 'Admin', 'admin@gmail.com', '$2y$10$E1DDe770mSk3kaXKEEgN1.GtDvtdstSBDmjdasJCvEh0cn193KqfG', 'admin', 'administrador'),
                                                                                (10, 'Diana Marcela', 'isa@gmail.com', '$2y$10$6ObG0o8DLpsbRT/vyd9xe.vdvZzyIO.eQqUmv9RKsVmDE3oIIZ7y6', 'user', 'bajar grasa');

ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

-- -------------------------------------------------------------------
-- Tabla: recetas
-- -------------------------------------------------------------------

CREATE TABLE `recetas` (
                           `id` INT NOT NULL AUTO_INCREMENT,
                           `titulo` VARCHAR(255) NOT NULL,
                           `objetivo` VARCHAR(100) NOT NULL,
                           `descripcion` TEXT,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3 recetas por cada objetivo

INSERT INTO `recetas` (`titulo`, `objetivo`, `descripcion`) VALUES
-- Ganar masa muscular
('Omelette de claras y avena', 'ganar masa', 'Aporta proteínas de alta calidad y carbohidratos complejos.'),
('Batido de banano y mantequilla de maní', 'ganar masa', 'Ideal para después del entrenamiento, rico en calorías y proteínas.'),
('Pollo con arroz integral y brócoli', 'ganar masa', 'Comida completa con proteína, carbohidrato y fibra.'),
-- Bajar grasa
('Ensalada de atún y aguacate', 'bajar grasa', 'Bajo en carbohidratos y alto en grasas saludables.'),
('Pollo a la plancha con espárragos', 'bajar grasa', 'Fuente magra de proteína y vegetales con fibra.'),
('Sopa de verduras con tofu', 'bajar grasa', 'Alta en nutrientes y baja en calorías.'),
-- Resistencia
('Pasta integral con vegetales', 'resistencia', 'Ideal para cargas energéticas antes de entrenos largos.'),
('Yogurt natural con granola', 'resistencia', 'Fuente de energía rápida con probióticos.'),
('Sándwich integral de pavo', 'resistencia', 'Proteína magra y carbohidrato complejo.'),
-- Fuerza
('Carne magra con papas al horno', 'fuerza', 'Alta en proteínas y carbohidratos para la recuperación muscular.'),
('Huevos con pan integral', 'fuerza', 'Desayuno potente para aumentar fuerza.'),
('Lentejas con arroz y huevo', 'fuerza', 'Combinación de proteína vegetal y animal.'),
-- Salud general
('Frutas frescas con yogur griego', 'salud general', 'Rico en antioxidantes y probióticos.'),
('Verduras al vapor con quinoa', 'salud general', 'Fibra, proteína vegetal y micronutrientes.'),
('Smoothie verde con espinaca y piña', 'salud general', 'Ideal para el sistema digestivo y la energía diaria.');

-- -------------------------------------------------------------------
-- Tabla: rutinas
-- -------------------------------------------------------------------

CREATE TABLE `rutinas` (
                           `id` INT NOT NULL AUTO_INCREMENT,
                           `titulo` VARCHAR(255) NOT NULL,
                           `objetivo` VARCHAR(100) NOT NULL,
                           `descripcion` TEXT,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3 rutinas por cada objetivo

INSERT INTO `rutinas` (`titulo`, `objetivo`, `descripcion`) VALUES
-- Ganar masa muscular
('Rutina fullbody con pesas', 'ganar masa', 'Ejercicios compuestos 4 veces por semana.'),
('Piernas y glúteos con peso libre', 'ganar masa', 'Enfocada en tren inferior con mancuernas.'),
('Push/Pull/Legs', 'ganar masa', 'División de entrenamiento por grupos musculares.'),
-- Bajar grasa
('Cardio HIIT 20 minutos', 'bajar grasa', 'Intervalos de alta intensidad para quemar grasa.'),
('Circuito funcional en casa', 'bajar grasa', 'Rutina sin equipamiento para pérdida de grasa.'),
('Caminata rápida 45 minutos', 'bajar grasa', 'Ideal para quemar grasa sin impacto.'),
-- Resistencia
('Entrenamiento de intervalos', 'resistencia', 'Combina cardio con descanso activo.'),
('Carrera de fondo progresiva', 'resistencia', 'Aumenta resistencia cardiovascular.'),
('Saltar la cuerda + abdominales', 'resistencia', 'Cardio y fuerza del core.'),
-- Fuerza
('5x5 Sentadilla-Peso muerto', 'fuerza', 'Rutina clásica de fuerza pura.'),
('Fuerza en tren superior', 'fuerza', 'Press banca, remo con barra, dominadas.'),
('Plan de 3 días fuerza', 'fuerza', 'Ejercicios básicos con incremento de carga.'),
-- Salud general
('Yoga para principiantes', 'salud general', 'Flexibilidad, equilibrio y respiración.'),
('Movilidad articular diaria', 'salud general', 'Prevención de lesiones y bienestar.'),
('Caminata diaria 30 min', 'salud general', 'Actividad básica para la salud general.');

-- -------------------------------------------------------------------
-- Tabla: recomendaciones
-- -------------------------------------------------------------------

CREATE TABLE `recomendaciones` (
                                   `id` INT NOT NULL AUTO_INCREMENT,
                                   `titulo` VARCHAR(255) NOT NULL,
                                   `objetivo` VARCHAR(100) NOT NULL,
                                   `descripcion` TEXT,
                                   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3 recomendaciones por cada objetivo

INSERT INTO `recomendaciones` (`titulo`, `objetivo`, `descripcion`) VALUES
-- Ganar masa muscular
('Comer cada 3 horas', 'ganar masa', 'Mantén un superávit calórico constante.'),
('Entrena con progresión de carga', 'ganar masa', 'Aumenta los pesos gradualmente.'),
('Duerme mínimo 8h', 'ganar masa', 'El descanso permite la síntesis muscular.'),
-- Bajar grasa
('Déficit calórico moderado', 'bajar grasa', 'Consume menos calorías de las que gastas.'),
('Evita azúcares añadidos', 'bajar grasa', 'Prioriza alimentos naturales y saciantes.'),
('Haz cardio en ayunas', 'bajar grasa', 'Potencia la quema de grasa almacenada.'),
-- Resistencia
('Hidrátate antes, durante y después', 'resistencia', 'La deshidratación disminuye el rendimiento.'),
('Incrementa volumen gradualmente', 'resistencia', 'Evita sobrecargas y lesiones.'),
('Alterna días duros con suaves', 'resistencia', 'Favorece la recuperación y adaptación.'),
-- Fuerza
('Lleva registro de tus pesos', 'fuerza', 'Controla tu progreso y haz ajustes.'),
('Trabaja técnica antes que carga', 'fuerza', 'Una buena técnica evita lesiones.'),
('Come post-entreno proteína y carbos', 'fuerza', 'Ayuda a la recuperación y crecimiento.'),
-- Salud general
('Come frutas y verduras a diario', 'salud general', 'Ricas en fibra, vitaminas y minerales.'),
('Evita el sedentarismo prolongado', 'salud general', 'Levántate y muévete cada hora.'),
('Medita o respira profundo', 'salud general', 'Reduce estrés y mejora la salud mental.');

-- -------------------------------------------------------------------
-- Fin del script
COMMIT;
