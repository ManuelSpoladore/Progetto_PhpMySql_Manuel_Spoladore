-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 10, 2025 alle 10:11
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
-- Struttura della tabella `corsi`
--

CREATE TABLE `corsi` (
  `id` int(11) NOT NULL,
  `nome_corso` varchar(255) DEFAULT NULL,
  `posti_disponibili` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `corsi`
--

INSERT INTO `corsi` (`id`, `nome_corso`, `posti_disponibili`) VALUES
(5, 'Introduzione alla Filosofia', 20),
(6, 'Fondamenti di Programmazione con Python', 25),
(7, 'Storia dell’Arte Contemporanea', 18),
(8, 'Analisi dei Dati con Excel e Power BI', 22),
(9, 'Scrittura Creativa e Storytelling', 15),
(10, 'Logica Matematica per la Risoluzione di Problemi', 30),
(11, 'Psicologia del Lavoro e delle Organizzazioni', 20),
(12, 'Statistica per le Scienze Sociali', 24),
(13, 'Letteratura Italiana: da Dante a Calvino', 16),
(14, 'Sviluppo Sostenibile e Cambiamento Climatico', 28);

-- --------------------------------------------------------

--
-- Struttura della tabella `corso_materia`
--

CREATE TABLE `corso_materia` (
  `id` int(11) NOT NULL,
  `corso_id` int(11) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `corso_materia`
--

INSERT INTO `corso_materia` (`id`, `corso_id`, `materia_id`) VALUES
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
(22, 14, 16);

-- --------------------------------------------------------

--
-- Struttura della tabella `materie`
--

CREATE TABLE `materie` (
  `id` int(11) NOT NULL,
  `nome_materia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `materie`
--

INSERT INTO `materie` (`id`, `nome_materia`) VALUES
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
(20, 'Fondamenti di Informatica');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `corsi`
--
ALTER TABLE `corsi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `corso_materia`
--
ALTER TABLE `corso_materia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corso_id` (`corso_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Indici per le tabelle `materie`
--
ALTER TABLE `materie`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `corsi`
--
ALTER TABLE `corsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `corso_materia`
--
ALTER TABLE `corso_materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `materie`
--
ALTER TABLE `materie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `corso_materia`
--
ALTER TABLE `corso_materia`
  ADD CONSTRAINT `corso_materia_ibfk_1` FOREIGN KEY (`corso_id`) REFERENCES `corsi` (`id`),
  ADD CONSTRAINT `corso_materia_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
