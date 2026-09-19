-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/09/2026 às 04:22
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `techminds`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aulas`
--

CREATE TABLE `aulas` (
  `id` int(10) UNSIGNED NOT NULL,
  `conteudo_id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `ordem` int(11) NOT NULL DEFAULT 1,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aulas`
--

INSERT INTO `aulas` (`id`, `conteudo_id`, `titulo`, `descricao`, `video`, `material`, `ordem`, `ativo`, `data_criacao`) VALUES
(1, 1, 'Aula 1 - Introdução', 'Nesta aula vamos estudar os principais conceitos do conteúdo.', NULL, NULL, 1, 1, '2026-08-10 23:53:18');

-- --------------------------------------------------------

--
-- Estrutura para tabela `aulas_concluidas`
--

CREATE TABLE `aulas_concluidas` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `aula_id` int(10) UNSIGNED NOT NULL,
  `data_conclusao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aulas_concluidas`
--

INSERT INTO `aulas_concluidas` (`id`, `usuario_id`, `aula_id`, `data_conclusao`) VALUES
(1, 6, 1, '2026-09-15 14:14:19');

-- --------------------------------------------------------

--
-- Estrutura para tabela `conteudos`
--

CREATE TABLE `conteudos` (
  `id` int(10) UNSIGNED NOT NULL,
  `materia_id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `conteudos`
--

INSERT INTO `conteudos` (`id`, `materia_id`, `titulo`, `descricao`, `ativo`, `data_criacao`) VALUES
(1, 1, 'Introdução à Genética', 'Conceitos básicos de genética para o ENEM e vestibulares.', 1, '2026-08-09 19:47:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `materias`
--

CREATE TABLE `materias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `materias`
--

INSERT INTO `materias` (`id`, `nome`, `descricao`, `ativo`, `data_criacao`) VALUES
(1, 'Biologia', 'Conteúdos de Biologia direcionados ao ENEM e vestibulares.', 1, '2026-08-08 21:47:09'),
(2, 'Física', 'Conteúdos de Física direcionados ao ENEM e vestibulares.', 1, '2026-08-08 21:47:09'),
(3, 'Química', 'Conteúdos de Química direcionados ao ENEM e vestibulares.', 1, '2026-08-08 21:47:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens_contato`
--

CREATE TABLE `mensagens_contato` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `assunto` varchar(150) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `lida` tinyint(1) NOT NULL DEFAULT 0,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `questoes`
--

CREATE TABLE `questoes` (
  `id` int(10) UNSIGNED NOT NULL,
  `materia_id` int(10) UNSIGNED NOT NULL,
  `conteudo_id` int(10) UNSIGNED NOT NULL,
  `enunciado` text NOT NULL,
  `alternativa_a` text NOT NULL,
  `alternativa_b` text NOT NULL,
  `alternativa_c` text NOT NULL,
  `alternativa_d` text NOT NULL,
  `alternativa_e` text NOT NULL,
  `resposta_correta` char(1) NOT NULL,
  `dificuldade` enum('facil','media','dificil') NOT NULL DEFAULT 'media',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `questoes`
--

INSERT INTO `questoes` (`id`, `materia_id`, `conteudo_id`, `enunciado`, `alternativa_a`, `alternativa_b`, `alternativa_c`, `alternativa_d`, `alternativa_e`, `resposta_correta`, `dificuldade`, `ativo`, `data_criacao`) VALUES
(1, 1, 1, 'Qual estrutura celular é responsável por armazenar o material genético (DNA) em células eucarióticas?', 'Mitocôndria', 'Núcleo', 'Ribossomo', 'Complexo de Golgi', 'Retículo endoplasmático', 'B', 'facil', 1, '2026-09-16 09:03:56'),
(2, 1, 1, 'Um indivíduo heterozigoto para uma característica apresenta genótipo representado por:', 'AA', 'aa', 'Aa', 'A ou a, nunca os dois juntos', 'Nenhuma das alternativas', 'C', 'media', 1, '2026-09-16 09:03:56'),
(3, 1, 1, 'Na Primeira Lei de Mendel, os alelos de um mesmo gene se separam durante a formação dos gametas. Esse princípio é conhecido como:', 'Lei da segregação independente', 'Lei da recombinação gênica', 'Lei da dominância completa', 'Lei da pureza dos gametas', 'Lei da hereditariedade ligada', 'D', 'media', 1, '2026-09-16 09:03:56'),
(4, 1, 1, 'Em um cruzamento entre dois indivíduos Aa (heterozigotos), qual a proporção esperada de descendentes com genótipo aa?', '100%', '75%', '50%', '25%', '0%', 'D', 'dificil', 1, '2026-09-16 09:03:56'),
(5, 1, 1, 'O conjunto de características observáveis de um organismo, resultado da interação entre genótipo e ambiente, é chamado de:', 'Genótipo', 'Cariótipo', 'Fenótipo', 'Alelo', 'Loco gênico', 'C', 'facil', 1, '2026-09-16 09:03:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas_questoes`
--

CREATE TABLE `respostas_questoes` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `questao_id` int(10) UNSIGNED NOT NULL,
  `alternativa_escolhida` char(1) NOT NULL,
  `correta` tinyint(1) NOT NULL,
  `data_resposta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `respostas_questoes`
--

INSERT INTO `respostas_questoes` (`id`, `usuario_id`, `questao_id`, `alternativa_escolhida`, `correta`, `data_resposta`) VALUES
(1, 6, 1, 'A', 0, '2026-09-18 09:02:35'),
(2, 6, 2, 'C', 1, '2026-09-18 09:02:35'),
(3, 6, 3, 'E', 0, '2026-09-18 09:02:35'),
(4, 6, 4, 'A', 0, '2026-09-18 09:02:35'),
(5, 6, 5, 'C', 1, '2026-09-18 09:02:35');

-- --------------------------------------------------------

--
-- Estrutura para tabela `simulados`
--

CREATE TABLE `simulados` (
  `id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `tempo_minutos` int(11) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `simulados`
--

INSERT INTO `simulados` (`id`, `titulo`, `descricao`, `tempo_minutos`, `ativo`, `data_criacao`) VALUES
(1, 'Simulado de Genética Básica', 'Teste seus conhecimentos sobre os principais conceitos de genética mendeliana.', 10, 1, '2026-09-16 09:03:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `simulados_resultados`
--

CREATE TABLE `simulados_resultados` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `simulado_id` int(10) UNSIGNED NOT NULL,
  `total_questoes` int(11) NOT NULL,
  `acertos` int(11) NOT NULL,
  `data_realizacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `simulado_questoes`
--

CREATE TABLE `simulado_questoes` (
  `id` int(10) UNSIGNED NOT NULL,
  `simulado_id` int(10) UNSIGNED NOT NULL,
  `questao_id` int(10) UNSIGNED NOT NULL,
  `ordem` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `simulado_questoes`
--

INSERT INTO `simulado_questoes` (`id`, `simulado_id`, `questao_id`, `ordem`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2),
(3, 1, 3, 3),
(4, 1, 4, 4),
(5, 1, 5, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('aluno','admin') NOT NULL DEFAULT 'aluno',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `ativo`, `data_cadastro`, `foto`) VALUES
(4, 'Danila Ribeiro', 'danilaribeiro443@gmail.com', '$2y$10$ICVbZAJmKITci3ON9LxNl.V54dYtxnFHelx/0k8sMBWYqvGopX/4K', 'aluno', 1, '2026-08-09 23:41:30', NULL),
(5, 'Larissa Ribeiro', 'etecvavhooper@gmail.com', '$2y$10$v/e2Wizez9cZbOX3W2snPu8Mzmg6LFjyeROC.pUWHQ46VwuoM29h2', 'aluno', 1, '2026-08-11 16:12:59', NULL),
(6, 'Larissa Ribeiro', 'lrmusic718@gmail.com', '$2y$10$UmHwFrp2WkHHq2GKeCJ28.WjkgZwUmHg04BsCq6xKg0BcB29StDXm', 'admin', 1, '2026-08-17 00:36:45', NULL),
(7, 'Lucas', 'prime.gift10@gmail.com', '$2y$10$pRPIzJcWwt2s0MlombEEKuC6AZtFHqCP2kxDcwIK1pb5tYDxlq/t2', 'aluno', 1, '2026-09-14 19:54:13', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conteudo_id` (`conteudo_id`);

--
-- Índices de tabela `aulas_concluidas`
--
ALTER TABLE `aulas_concluidas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_usuario_aula` (`usuario_id`,`aula_id`),
  ADD KEY `fk_aulas_concluidas_aula` (`aula_id`);

--
-- Índices de tabela `conteudos`
--
ALTER TABLE `conteudos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mensagens_contato`
--
ALTER TABLE `mensagens_contato`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `questoes`
--
ALTER TABLE `questoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materia_id` (`materia_id`),
  ADD KEY `fk_questoes_conteudo` (`conteudo_id`);

--
-- Índices de tabela `respostas_questoes`
--
ALTER TABLE `respostas_questoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `questao_id` (`questao_id`);

--
-- Índices de tabela `simulados`
--
ALTER TABLE `simulados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `simulados_resultados`
--
ALTER TABLE `simulados_resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `simulado_id` (`simulado_id`);

--
-- Índices de tabela `simulado_questoes`
--
ALTER TABLE `simulado_questoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `simulado_id` (`simulado_id`),
  ADD KEY `questao_id` (`questao_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `aulas_concluidas`
--
ALTER TABLE `aulas_concluidas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `conteudos`
--
ALTER TABLE `conteudos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `mensagens_contato`
--
ALTER TABLE `mensagens_contato`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `questoes`
--
ALTER TABLE `questoes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `respostas_questoes`
--
ALTER TABLE `respostas_questoes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `simulados`
--
ALTER TABLE `simulados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `simulados_resultados`
--
ALTER TABLE `simulados_resultados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `simulado_questoes`
--
ALTER TABLE `simulado_questoes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `aulas`
--
ALTER TABLE `aulas`
  ADD CONSTRAINT `aulas_ibfk_1` FOREIGN KEY (`conteudo_id`) REFERENCES `conteudos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `aulas_concluidas`
--
ALTER TABLE `aulas_concluidas`
  ADD CONSTRAINT `fk_aulas_concluidas_aula` FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_aulas_concluidas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `conteudos`
--
ALTER TABLE `conteudos`
  ADD CONSTRAINT `conteudos_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `questoes`
--
ALTER TABLE `questoes`
  ADD CONSTRAINT `fk_questoes_conteudo` FOREIGN KEY (`conteudo_id`) REFERENCES `conteudos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questoes_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `respostas_questoes`
--
ALTER TABLE `respostas_questoes`
  ADD CONSTRAINT `fk_respostas_questao` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_respostas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `simulados_resultados`
--
ALTER TABLE `simulados_resultados`
  ADD CONSTRAINT `fk_simulados_resultados_simulado` FOREIGN KEY (`simulado_id`) REFERENCES `simulados` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_simulados_resultados_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `simulado_questoes`
--
ALTER TABLE `simulado_questoes`
  ADD CONSTRAINT `simulado_questoes_ibfk_1` FOREIGN KEY (`simulado_id`) REFERENCES `simulados` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `simulado_questoes_ibfk_2` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
