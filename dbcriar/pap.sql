-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2024 at 10:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vitech`
--
CREATE DATABASE IF NOT EXISTS `vitech` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `vitech`;

-- --------------------------------------------------------

--
-- Table structure for table `acoes`
--

CREATE TABLE `acoes` (
  `id_acao` int(11) NOT NULL,
  `id_ticket` int(9) DEFAULT NULL,
  `id_user` int(9) DEFAULT NULL,
  `data_acao` timestamp NOT NULL DEFAULT current_timestamp(),
  `acao` varchar(255) DEFAULT NULL,
  `status_change` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `acoes`
--

INSERT INTO `acoes` (`id_acao`, `id_ticket`, `id_user`, `data_acao`, `acao`, `status_change`) VALUES
(3, 5, 1, '2024-06-16 19:48:59', 'Alterou o estado no ticket', 'F'),
(4, 6, 1, '2024-06-16 21:31:55', 'Alterou o estado no ticket', 'F'),
(5, 5, 1, '2024-06-16 21:32:06', 'Alterou o estado no ticket', 'P');

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` varchar(3) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `Status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nome`, `Status`) VALUES
('ADM', 'Admin', 'A'),
('DIF', 'Departamento de Informática', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id_faq` int(9) NOT NULL,
  `Categoria_Dep` varchar(3) DEFAULT NULL,
  `Questao` varchar(30) NOT NULL,
  `Informacao` varchar(50) NOT NULL,
  `Status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logfile`
--

CREATE TABLE `logfile` (
  `id_log` int(9) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_user` int(9) DEFAULT NULL,
  `tabela` varchar(50) DEFAULT NULL,
  `operacao` char(1) DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `noticia`
--

CREATE TABLE `noticia` (
  `id_noticia` int(9) NOT NULL,
  `Data_inicio` date NOT NULL,
  `Data_fim` date NOT NULL,
  `Assunto` varchar(20) NOT NULL,
  `Noticia` text NOT NULL,
  `Status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resposta`
--

CREATE TABLE `resposta` (
  `id_resposta` int(9) NOT NULL,
  `id_user` int(9) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `resposta` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `resposta`
--

INSERT INTO `resposta` (`id_resposta`, `id_user`, `data`, `resposta`) VALUES
(1, 1, '2024-04-18 09:16:29', 'Olá, Como pode ver o inovar está em manutenção por isso os seus serviços encontram-se indisponiveis'),
(2, 1, '2024-06-16 20:50:18', 'assasas'),
(3, 1, '2024-06-16 21:18:00', 'pila'),
(4, 1, '2024-06-16 21:20:33', 'oola\r\n'),
(5, 1, '2024-06-16 21:37:06', 'dassdasa'),
(6, 1, '2024-06-16 21:38:15', 'assad'),
(7, 1, '2024-06-16 21:38:29', 'assad');

-- --------------------------------------------------------

--
-- Table structure for table `resposta_ticket`
--

CREATE TABLE `resposta_ticket` (
  `id_resposta` int(9) NOT NULL,
  `id_ticket` int(9) NOT NULL,
  PRIMARY KEY (`id_resposta`, `id_ticket`),
  FOREIGN KEY (`id_resposta`) REFERENCES `resposta` (`id_resposta`) ON DELETE CASCADE,
  FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id_ticket`) ON DELETE CASCADE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `resposta_ticket`
--

INSERT INTO `resposta_ticket` (`id_resposta`, `id_ticket`) VALUES
(1, 1),
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(6, 5),
(7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_ticket` char(1) NOT NULL,
  `assunto_local` varchar(50) NOT NULL,
  `mensagem_sintomas` text NOT NULL,
  `id_departamento_destino` varchar(3) NOT NULL,
  `urgencia` tinyint(1) NOT NULL,
  `status` char(1) NOT NULL,
  `id_user_atribuido` int(9) DEFAULT NULL,
  `data_atribuido` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `id_user`, `data`, `tipo_ticket`, `assunto_local`, `mensagem_sintomas`, `id_departamento_destino`, `urgencia`, `status`, `id_user_atribuido`, `data_atribuido`) VALUES
(1, 2, '2024-04-17 23:00:00', 'A', 'Como entrar no Inovar', 'Olá, não sei como entrar no inovar', 2, 1, 'F', 1, '2024-04-18'),
(2, 2, '2024-04-24 09:00:00', 'I', 'Problema de Conexão', 'Estou enfrentando problemas de conexão com a rede interna.', 2, 0, 'A', 1, NULL),
(3, 2, '2024-04-24 10:30:00', 'I', 'Problema no Software', 'O software X está apresentando falhas constantes.', 2, 1, 'A', 1, '2024-04-24'),
(4, 1, '2024-05-02 12:01:23', 'I', 'Como entrar no Inovas', 'Olá, não sei como entrar no inovar', 2, 1, 'A', NULL, NULL),
(5, 1, '2024-06-16 19:47:03', 'I', 'aS', 'ASaS', 1, 0, 'P', NULL, NULL),
(6, 1, '2024-06-16 21:31:47', 'I', 'okok', 'uinnun', 1, 0, 'F', NULL, NULL),
(7, 1, '2024-06-16 21:36:31', 'I', 'assad', 'asdsad', 1, 0, 'P', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_user`
--

CREATE TABLE `tipo_user` (
  `id_tipo_user` int(9) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `permissoes` char(1) DEFAULT NULL,
  `status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tipo_user`
--

INSERT INTO `tipo_user` (`id_tipo_user`, `nome`, `permissoes`, `status`) VALUES
(1, 'Admin', 'A', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(9) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` int(9) DEFAULT NULL,
  `status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nome`, `username`, `password`, `email`, `telefone`, `status`) VALUES
(1, 'Admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@gmail.com', NULL, 'A'),
(2, 'Sender', 'sender', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'sender@example.com', NULL, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `user_departamento_tipo`
--

CREATE TABLE `user_departamento_tipo` (
  `id_user` int(9) DEFAULT NULL,
  `id_departamento` varchar(3) DEFAULT NULL,
  `id_tipo` int(9) DEFAULT NULL,
  `id_ligacao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user_departamento_tipo`
--

INSERT INTO `user_departamento_tipo` (`id_user`, `id_departamento`, `id_tipo`, `id_ligacao`) VALUES
(1, 'ADM', 1, 1),
(2, 'ADM', 1, 2),
(1, 'DIF', 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acoes`
--
ALTER TABLE `acoes`
  ADD PRIMARY KEY (`id_acao`),
  ADD KEY `fk_id_ticket` (`id_ticket`),
  ADD KEY `fk_id_user` (`id_user`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`),
  ADD KEY `Categoria_Dep` (`Categoria_Dep`);

--
-- Indexes for table `logfile`
--
ALTER TABLE `logfile`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Indexes for table `resposta`
--
ALTER TABLE `resposta`
  ADD PRIMARY KEY (`id_resposta`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `resposta_ticket`
--
ALTER TABLE `resposta_ticket`
  ADD KEY `id_resposta` (`id_resposta`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_departamento_destino` (`id_departamento_destino`),
  ADD KEY `id_user_atribuido` (`id_user_atribuido`);

--
-- Indexes for table `tipo_user`
--
ALTER TABLE `tipo_user`
  ADD PRIMARY KEY (`id_tipo_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_departamento_tipo`
--
ALTER TABLE `user_departamento_tipo`
  ADD PRIMARY KEY (`id_ligacao`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_departamento` (`id_departamento`),
  ADD KEY `fk_tipo_user` (`id_tipo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acoes`
--
ALTER TABLE `acoes`
  MODIFY `id_acao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logfile`
--
ALTER TABLE `logfile`
  MODIFY `id_log` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id_noticia` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `resposta`
--
ALTER TABLE `resposta`
  MODIFY `id_resposta` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_ticket` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tipo_user`
--
ALTER TABLE `tipo_user`
  MODIFY `id_tipo_user` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_departamento_tipo`
--
ALTER TABLE `user_departamento_tipo`
  MODIFY `id_ligacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
