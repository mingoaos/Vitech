-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 03-Maio-2024 às 16:18
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `pap`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acoes`
--

CREATE TABLE `acoes` (
  `id_acao` int(11) NOT NULL,
  `id_ticket` int(9) DEFAULT NULL,
  `id_user` int(9) DEFAULT NULL,
  `data_acao` timestamp NOT NULL DEFAULT current_timestamp(),
  `acao` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `acoes`
--

INSERT INTO `acoes` (`id_acao`, `id_ticket`, `id_user`, `data_acao`, `acao`) VALUES
(1, 1, 2, '2024-05-03 09:40:21', 'Adicionou um Comentário no ticket');

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` varchar(3) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `Status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nome`, `Status`) VALUES
('ADM', 'Admin', 'A'),
('DIF', 'Departamento de Informática', 'A');

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

--
-- Extraindo dados da tabela `resposta`
--

INSERT INTO `resposta` (`id_resposta`, `id_user`, `data`, `Resposta`) VALUES
(1, 1, '2024-04-18 09:16:29', 'Olá, Como pode ver o inovar está em manutenção por isso os seus serviços encontram-se indisponiveis');

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta_ticket`
--

CREATE TABLE `resposta_ticket` (
  `id_resposta` int(9) NOT NULL,
  `id_ticket` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `resposta_ticket`
--

INSERT INTO `resposta_ticket` (`id_resposta`, `id_ticket`) VALUES
(1, 1);

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
  `id_departamento_destino` varchar(3) NOT NULL,
  `urgencia` tinyint(1) NOT NULL,
  `status` char(1) NOT NULL,
  `id_user_atribuido` int(9) DEFAULT NULL,
  `data_atribuido` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `id_user`, `data`, `tipo_ticket`, `assunto_local`, `mensagem_sintomas`, `id_departamento_destino`, `urgencia`, `status`, `id_user_atribuido`, `data_atribuido`) VALUES
(1, 2, '2024-04-17 23:00:00', 'A', 'Como entrar no Inovar', 'Olá, não sei como entrar no inovar', 'DIF', 1, 'F', 1, '2024-04-18'),
(2, 2, '2024-04-24 09:00:00', 'I', 'Problema de Conexão', 'Estou enfrentando problemas de conexão com a rede interna.', 'DIF', 0, 'A', 1, NULL),
(3, 2, '2024-04-24 10:30:00', 'I', 'Problema no Software', 'O software X está apresentando falhas constantes.', 'DIF', 1, 'A', 1, '2024-04-24'),
(4, 1, '2024-05-02 12:01:23', 'I', 'Como entrar no Inovas', 'Olá, não sei como entrar no inovar', 'DIF', 1, 'P', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_user`
--

CREATE TABLE `tipo_user` (
  `id_tipo_user` int(9) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `permissoes` char(1) DEFAULT NULL,
  `status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tipo_user`
--

INSERT INTO `tipo_user` (`id_tipo_user`, `nome`, `permissoes`, `status`) VALUES
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
  `status` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id_user`, `nome`, `username`, `password`, `email`, `telefone`, `status`) VALUES
(1, 'Admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@gmail.com', NULL, 'A'),
(2, 'Sender', 'sender', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'sender@example.com', NULL, 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_departamento_tipo`
--

CREATE TABLE `user_departamento_tipo` (
  `id_user` int(9) DEFAULT NULL,
  `id_departamento` varchar(3) DEFAULT NULL,
  `id_tipo` int(9) DEFAULT NULL,
  `id_ligacao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `user_departamento_tipo`
--

INSERT INTO `user_departamento_tipo` (`id_user`, `id_departamento`, `id_tipo`, `id_ligacao`) VALUES
(1, 'ADM', 1, 1),
(2, 'ADM', 1, 2),
(1, 'DIF', 1, 3);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `acoes`
--
ALTER TABLE `acoes`
  ADD PRIMARY KEY (`id_acao`),
  ADD KEY `fk_id_ticket` (`id_ticket`),
  ADD KEY `fk_id_user` (`id_user`);

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
  ADD PRIMARY KEY (`id_tipo_user`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Índices para tabela `user_departamento_tipo`
--
ALTER TABLE `user_departamento_tipo`
  ADD PRIMARY KEY (`id_ligacao`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_departamento` (`id_departamento`),
  ADD KEY `fk_tipo_user` (`id_tipo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acoes`
--
ALTER TABLE `acoes`
  MODIFY `id_acao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id_resposta` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_ticket` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tipo_user`
--
ALTER TABLE `tipo_user`
  MODIFY `id_tipo_user` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `user_departamento_tipo`
--
ALTER TABLE `user_departamento_tipo`
  MODIFY `id_ligacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
