-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Mag 31, 2019 alle 09:40
-- Versione del server: 5.7.21
-- Versione PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `grp_12_db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `ID` bigint(25) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(150) NOT NULL,
  `testo` text NOT NULL,
  `punteggio` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `macchine`
--

DROP TABLE IF EXISTS `macchine`;
CREATE TABLE IF NOT EXISTS `macchine` (
  `ID` bigint(25) NOT NULL AUTO_INCREMENT,
  `TARGA` varchar(150) NOT NULL,
  `modello` varchar(150) NOT NULL,
  `marca` varchar(150) NOT NULL,
  `prezzo` decimal(20,0) NOT NULL,
  `costi` tinyint(4) NOT NULL,
  `foto` text NOT NULL,
  `allestimento` text NOT NULL,
  PRIMARY KEY (`ID`,`TARGA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggi`
--

DROP TABLE IF EXISTS `messaggi`;
CREATE TABLE IF NOT EXISTS `messaggi` (
  `ID` bigint(25) NOT NULL AUTO_INCREMENT,
  `mittente` bigint(25) NOT NULL,
  `destinatario` bigint(25) NOT NULL,
  `testo` text NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `noleggi`
--

DROP TABLE IF EXISTS `noleggi`;
CREATE TABLE IF NOT EXISTS `noleggi` (
  `ID` bigint(25) NOT NULL AUTO_INCREMENT,
  `noleggiatore` bigint(25) NOT NULL,
  `macchina` bigint(25) NOT NULL,
  `inizio` datetime NOT NULL,
  `fine` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `occupazioni`
--

DROP TABLE IF EXISTS `occupazioni`;
CREATE TABLE IF NOT EXISTS `occupazioni` (
  `ID` bigint(25) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `ruoli`
--

DROP TABLE IF EXISTS `ruoli`;
CREATE TABLE IF NOT EXISTS `ruoli` (
  `ID` bigint(25) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `livello` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `transazioni`
--

DROP TABLE IF EXISTS `transazioni`;
CREATE TABLE IF NOT EXISTS `transazioni` (
  `ID` bigint(25) NOT NULL AUTO_INCREMENT,
  `utente` bigint(25) NOT NULL,
  `macchina` bigint(25) NOT NULL,
  `data` datetime NOT NULL,
  `prezzo` decimal(20,2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

DROP TABLE IF EXISTS `utenti`;
CREATE TABLE IF NOT EXISTS `utenti` (
  `ID` bigint(25) NOT NULL AUTO_INCREMENT,
  `Username` varchar(150) NOT NULL,
  `Nome` varchar(150) NOT NULL,
  `Cognome` varchar(150) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Residenza` varchar(500) NOT NULL,
  `Nascita` datetime NOT NULL,
  `Ruolo` bigint(25) NOT NULL,
  `Occupazione` bigint(25) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
