-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 21-Mar-2024 às 11:37
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pap`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` varchar(3) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `Status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nome`, `Status`) VALUES
('ADM', 'Admin', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `faq`
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
-- Estrutura da tabela `logfile`
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
-- Estrutura da tabela `noticia`
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
-- Estrutura da tabela `resposta`
--

CREATE TABLE `resposta` (
  `id_resposta` int(9) NOT NULL,
  `id_user` int(9) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `Resposta` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta_ticket`
--

CREATE TABLE `resposta_ticket` (
  `id_resposta` int(9) DEFAULT NULL,
  `id_ticket` int(9) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` int(9) NOT NULL,
  `id_user` int(9) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_ticket` char(1) NOT NULL,
  `assunto_local` varchar(50) NOT NULL,
  `mensagem_sintomas` text NOT NULL,
  `id_departamento_destino` int(9) NOT NULL,
  `urgencia` tinyint(1) NOT NULL,
  `status` char(1) NOT NULL,
  `id_user_atribuido` int(9) DEFAULT NULL,
  `data_atribuido` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_user`
--

CREATE TABLE `tipo_user` (
  `id_tipoUser` int(9) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `permissoes` char(1) DEFAULT NULL,
  `status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tipo_user`
--

INSERT INTO `tipo_user` (`id_tipoUser`, `nome`, `permissoes`, `status`) VALUES
(1, 'Admin', 'A', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id_user` int(9) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` int(9) DEFAULT NULL,
  `tipo_user` int(11) DEFAULT NULL,
  `status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id_user`, `nome`, `username`, `password`, `email`, `telefone`, `tipo_user`, `status`) VALUES
(1, 'Admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@gmail.com', NULL, 1, 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_departamento_tipo`
--

CREATE TABLE `user_departamento_tipo` (
  `id_user` int(9) DEFAULT NULL,
  `id_departamento` varchar(3) DEFAULT NULL,
  `id_tipo` int(9) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `user_departamento_tipo`
--

INSERT INTO `user_departamento_tipo` (`id_user`, `id_departamento`, `id_tipo`) VALUES
(1, 'ADM', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Índices para tabela `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`),
  ADD KEY `Categoria_Dep` (`Categoria_Dep`);

--
-- Índices para tabela `logfile`
--
ALTER TABLE `logfile`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user` (`id_user`);

--
-- Índices para tabela `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Índices para tabela `resposta`
--
ALTER TABLE `resposta`
  ADD PRIMARY KEY (`id_resposta`),
  ADD KEY `id_user` (`id_user`);

--
-- Índices para tabela `resposta_ticket`
--
ALTER TABLE `resposta_ticket`
  ADD KEY `id_resposta` (`id_resposta`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Índices para tabela `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_departamento_destino` (`id_departamento_destino`),
  ADD KEY `id_user_atribuido` (`id_user_atribuido`);

--
-- Índices para tabela `tipo_user`
--
ALTER TABLE `tipo_user`
  ADD PRIMARY KEY (`id_tipoUser`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `tipo_user` (`tipo_user`);

--
-- Índices para tabela `user_departamento_tipo`
--
ALTER TABLE `user_departamento_tipo`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_departamento` (`id_departamento`),
  ADD KEY `fk_tipo_user` (`id_tipo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `logfile`
--
ALTER TABLE `logfile`
  MODIFY `id_log` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id_noticia` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `resposta`
--
ALTER TABLE `resposta`
  MODIFY `id_resposta` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_ticket` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipo_user`
--
ALTER TABLE `tipo_user`
  MODIFY `id_tipoUser` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
