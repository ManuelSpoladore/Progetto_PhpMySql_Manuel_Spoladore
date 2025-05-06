-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 06, 2025 alle 09:43
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `owly`
--
CREATE DATABASE IF NOT EXISTS `owly` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `owly`;

-- --------------------------------------------------------

--
-- Struttura della tabella `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `available_places` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `available_places`) VALUES
(5, 'Introduzione alla Filosofia', 20),
(6, 'Fondamenti di Programmazione con Python', 25),
(7, 'Storia dell’Arte Contemporanea', 18),
(8, 'Analisi dei Dati con Excel e Power BI', 22),
(9, 'Scrittura Creativa e Storytelling', 15),
(10, 'Logica Matematica per la Risoluzione di Problemi', 30),
(11, 'Psicologia del Lavoro e delle Organizzazioni', 20),
(12, 'Statistica per le Scienze Sociali', 24),
(13, 'Letteratura Italiana: da Dante a Calvino', 16),
(14, 'Sviluppo Sostenibile e Cambiamento Climatico', 28),
(17, 'PHP for Beginners', 20),
(20, 'Frontend Foundations', 25);

-- --------------------------------------------------------

--
-- Struttura della tabella `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`) VALUES
(1, 'Filosofia Antica'),
(2, 'Etica e Filosofia Morale'),
(3, 'Fondamenti di Python'),
(4, 'HTML e CSS'),
(5, 'Storia dell’Arte Moderna'),
(6, 'Arte e Tecnologie Digitali'),
(7, 'Analisi Dati con Excel'),
(8, 'Visualizzazione Dati'),
(9, 'Tecniche di Scrittura'),
(10, 'Narrativa e Storytelling'),
(11, 'Logica Matematica'),
(12, 'Matematica Discreta'),
(13, 'Psicologia delle Organizzazioni'),
(14, 'Comunicazione e Leadership'),
(15, 'Statistica Descrittiva'),
(16, 'Statistica Inferenziale'),
(17, 'Letteratura Medievale'),
(18, 'Letteratura Contemporanea'),
(19, 'Fisica Meccanica'),
(20, 'Fondamenti di Informatica'),
(21, 'HTML Basics');

-- --------------------------------------------------------

--
-- Struttura della tabella `subject_courses`
--

DROP TABLE IF EXISTS `subject_courses`;
CREATE TABLE `subject_courses` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `subject_courses`
--

INSERT INTO `subject_courses` (`id`, `course_id`, `subject_id`) VALUES
(3, 5, 1),
(4, 5, 2),
(5, 6, 3),
(6, 6, 20),
(7, 7, 5),
(8, 7, 6),
(9, 8, 7),
(10, 8, 8),
(11, 9, 9),
(12, 9, 10),
(13, 10, 11),
(14, 10, 12),
(15, 11, 13),
(16, 11, 14),
(17, 12, 15),
(18, 12, 16),
(19, 13, 17),
(20, 13, 18),
(21, 14, 19),
(22, 14, 16),
(23, 17, 1),
(24, 17, 2),
(28, 20, 4);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `subject_courses`
--
ALTER TABLE `subject_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corso_id` (`course_id`),
  ADD KEY `materia_id` (`subject_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT per la tabella `subject_courses`
--
ALTER TABLE `subject_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `subject_courses`
--
ALTER TABLE `subject_courses`
  ADD CONSTRAINT `subject_courses_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `subject_courses_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
