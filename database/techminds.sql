-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/09/2026 às 13:58
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
(1, 1, 'Introdução à Genética', 'Conceitos básicos de genética para o ENEM e vestibulares.', 1, '2026-08-09 19:47:05'),
(3, 1, 'Ecologia', 'Conceitos básicos de ecologia focado em ENEM e vestibulares de forma descomplicada.', 1, '2026-09-25 11:23:55'),
(4, 1, 'Fisiologia Humana', 'Conceitos básicos de fisiologia humana, focado em ENEM e vestibulares de forma descomplicada', 1, '2026-09-25 11:24:41'),
(5, 1, 'Citologia', 'Conceitos básicos de citologia focado em ENEM e vestibulares de forma descomplicada.', 1, '2026-09-25 11:24:59'),
(6, 2, 'Eletrodinâmica', 'Conceitos básicos de eletrodinâmica focado em ENEM e vestibulares de forma descomplicada', 1, '2026-09-25 11:25:55'),
(7, 2, 'Ondulatória', 'Conceitos básicos de ondulatória focado em ENEM e vestibulares de forma descomplicada', 1, '2026-09-25 11:29:46'),
(8, 2, 'Termologia', 'Conceitos básicos de termologia focado em ENEM e vestibulares de forma descomplicada', 1, '2026-09-25 11:30:38'),
(9, 3, 'Eletroquímica', 'Conceitos básicos de eletroquímica focado em ENEM e vestibulares de forma descomplicada', 1, '2026-09-25 11:34:16'),
(10, 3, 'Separação de misturas', 'Conceitos básicos de separação de misturas focado em ENEM e vestibulares de forma descomplicada', 1, '2026-09-25 11:34:52'),
(11, 3, 'Química orgânica', 'Conceitos básicos de química orgânica focado em ENEM e vestibulares de forma descomplicada', 1, '2026-09-25 11:35:16');

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
  `conteudo_id` int(10) UNSIGNED DEFAULT NULL,
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
(1, 1, 3, 'Em um ecossistema de campo, o capim é consumido por gafanhotos, que são consumidos por sapos. Os sapos podem ser predados por cobras.\r\nConsiderando essa cadeia alimentar, assinale a alternativa correta:', 'O gafanhoto é produtor e o capim é consumidor primário.', 'O capim é produtor e o gafanhoto é consumidor primário.', 'O sapo é produtor e a cobra é consumidor primário.', 'O capim é decompositor e o gafanhoto é consumidor secundário.', 'Todos os organismos apresentados são consumidores.', 'B', 'media', 1, '2026-08-13 16:41:26'),
(2, 1, 3, 'Sobre o fluxo de energia nos ecossistemas, analise as afirmações:\r\nI. A energia solar é utilizada pelos produtores na fotossíntese.\r\nII. A energia passa de um nível trófico para outro por meio das relações alimentares.\r\nIII. Parte da energia é dissipada na forma de calor.\r\nIV. A energia é reciclada indefinidamente dentro do ecossistema.\r\nEstá correto o que se afirma em:', 'Apenas I e II.', 'Apenas II e IV.', 'Apenas I, II e III.', 'Apenas I, III e IV.', 'I, II, III e IV.', 'C', 'media', 1, '2026-08-13 16:56:12'),
(6, 1, 3, 'Uma determinada espécie de ave vive em uma floresta. Ela constrói seus ninhos em árvores, alimenta-se principalmente de determinados frutos e possui predadores específicos.\r\nConsiderando os conceitos ecológicos, assinale a alternativa correta:', 'As árvores representam o nicho ecológico da ave.', 'A floresta representa necessariamente o nicho ecológico da ave.', 'O local onde a ave vive corresponde ao seu habitat, enquanto seu modo de vida e suas relações com o ambiente fazem parte de seu nicho ecológico.', 'Habitat e nicho ecológico são conceitos exatamente iguais.', 'O nicho ecológico corresponde apenas ao local onde a espécie constrói seu ninho.', 'C', 'media', 1, '2026-09-24 23:52:53'),
(7, 1, 4, 'Durante uma corrida, uma pessoa apresenta aumento da frequência cardíaca e respiratória. Essas alterações são importantes porque permitem que o organismo atenda ao aumento da demanda energética dos músculos.\r\nNesse processo, é correto afirmar que:', 'O sistema respiratório diminui a entrada de oxigênio para evitar alterações no sangue.', 'O sistema circulatório transporta oxigênio e nutrientes para os tecidos e remove parte dos resíduos metabólicos.', 'O sistema nervoso deixa de atuar para que os músculos funcionem de maneira independente.', 'O sistema urinário é responsável diretamente pela entrada de oxigênio nos músculos.', 'Os sistemas corporais funcionam de maneira independente durante o exercício', 'B', 'media', 1, '2026-09-25 11:45:59'),
(8, 1, 4, 'A homeostase é fundamental para a sobrevivência dos seres humanos. Um exemplo de mecanismo relacionado à homeostase é a regulação da temperatura corporal.\r\nQuando a temperatura do ambiente aumenta, o organismo pode aumentar a produção de suor.', 'aumentar a temperatura corporal.', 'impedir completamente a perda de água.', 'contribuir para a redução da temperatura corporal por meio da evaporação do suor', 'interromper a circulação sanguínea.', 'aumentar a concentração de glicose no sangue.', 'C', 'media', 1, '2026-09-25 11:47:07'),
(9, 1, 4, 'O sangue passa pelos pulmões, onde ocorre uma importante troca gasosa. Sobre esse processo, assinale a alternativa correta:', 'O dióxido de carbono passa do ar dos alvéolos para o sangue, enquanto o oxigênio passa do sangue para os alvéolos.', 'O oxigênio e o dióxido de carbono permanecem exclusivamente no sistema respiratório', 'A hematose ocorre principalmente no estômago.', 'O oxigênio passa dos alvéolos para o sangue, enquanto o dióxido de carbono passa do sangue para os alvéolos.', 'As trocas gasosas acontecem apenas nas artérias.', 'D', 'media', 1, '2026-09-25 11:49:09'),
(10, 1, 5, 'Uma célula apresenta membrana plasmática, citoplasma, ribossomos e material genético localizado em uma região que não é delimitada por uma membrana nuclear.\r\nCom base nessas características, essa célula é:', 'eucarionte animal.', 'eucarionte vegetal.', 'procarionte.', 'exclusivamente uma célula muscular.', 'exclusivamente uma célula nervosa.', 'C', 'media', 1, '2026-09-25 11:50:36'),
(11, 1, 5, 'Uma determinada célula apresenta grande quantidade de retículo endoplasmático rugoso e complexo de Golgi bem desenvolvido.\r\nConsiderando as funções dessas estruturas, é possível concluir que essa célula apresenta intensa atividade relacionada principalmente à:', 'síntese e processamento de proteínas.', 'realização da fotossíntese.', 'produção de gametas exclusivamente.', 'digestão extracelular.', 'formação da parede celular.', 'A', 'media', 1, '2026-09-25 11:52:17'),
(12, 1, 5, 'A mitose e a meiose são processos de divisão celular com características diferentes.\r\nAssinale a alternativa correta:', 'A mitose sempre produz quatro células geneticamente diferentes.', 'A meiose mantém obrigatoriamente o mesmo número de cromossomos das células parentais.', 'A mitose está relacionada ao crescimento e à renovação celular, enquanto a meiose contribui para a formação de células haploides e para a variabilidade genética.', 'Mitose e meiose são processos idênticos, diferenciando-se apenas pelo nome.', 'A meiose ocorre apenas em células procariontes.', 'C', 'media', 1, '2026-09-25 11:53:34');

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
(5, 6, 5, 'C', 1, '2026-09-18 09:02:35'),
(6, 7, 1, 'C', 0, '2026-09-25 10:48:45'),
(7, 7, 2, 'B', 0, '2026-09-25 10:48:45'),
(8, 7, 6, 'A', 0, '2026-09-25 10:48:45'),
(9, 8, 2, 'B', 0, '2026-09-25 11:40:51');

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
(1, 'Simulado de Genética Básica', 'Teste seus conhecimentos sobre os principais conceitos de genética mendeliana.', 10, 1, '2026-09-16 09:03:56'),
(2, 'Simulado de Bio Teste', 'edzbhdthbdtned', 60, 1, '2026-09-25 00:52:14'),
(4, 'Introdução a Químicafqef', 'efwfgwe', 45, 1, '2026-09-25 01:09:03'),
(6, 'asd', 'def', 4, 1, '2026-09-25 01:22:38');

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
(6, 2, 1, 1),
(10, 4, 2, 1),
(13, 6, 2, 1);

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
(3, 'Larissa Ribeiro', 'lrmusic718@gmail.com', '$2y$10$QXP.YgJE9VSXF9HDYcVtYuia/YDXSiij0aanhvmznybbP7588eaae', 'aluno', 1, '2026-08-09 19:48:34', NULL),
(4, 'Danila Ribeiro', 'danilaribeiro443@gmail.com', '$2y$10$ICVbZAJmKITci3ON9LxNl.V54dYtxnFHelx/0k8sMBWYqvGopX/4K', 'aluno', 1, '2026-08-09 23:41:30', NULL),
(5, 'Larissa Ribeiro', 'etecvavhooper@gmail.com', '$2y$10$v/e2Wizez9cZbOX3W2snPu8Mzmg6LFjyeROC.pUWHQ46VwuoM29h2', 'aluno', 1, '2026-08-11 16:12:59', NULL),
(6, 'Isabella Fernanda da Silva Barbosa', 'isabellafernanda2511@icloud.com', '$2y$10$KmJYUBUj.DFcEVR9IaIQ6.uWVM9F7g2hVzga/541z5Ph7e/jQ8V0O', 'aluno', 1, '2026-08-13 16:31:56', 'uploads/perfil/perfil_6_6a7e84a58fe43.jpg'),
(7, 'Isabella Fernanda', 'isa.fernanda.251109@gmail.com', '$2y$10$hcddMikGBhJ0Dytx8iRfguiYaKbWzHwtIiDY5JR2b9E38IJ15LqBG', 'admin', 1, '2026-09-24 22:13:00', NULL),
(8, 'Malu Gibrail', 'malu.bomdia@gmail.com', '$2y$10$OU9FzXfuwFEJDjs6.ERsi.yokya7aMQ64d1qOwLMi6lWVLnOrcWsO', 'admin', 1, '2026-09-25 11:18:23', NULL);

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
  ADD KEY `fk_questoes_conteudos` (`conteudo_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `respostas_questoes`
--
ALTER TABLE `respostas_questoes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `simulados`
--
ALTER TABLE `simulados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `simulados_resultados`
--
ALTER TABLE `simulados_resultados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `simulado_questoes`
--
ALTER TABLE `simulado_questoes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `fk_questoes_conteudos` FOREIGN KEY (`conteudo_id`) REFERENCES `conteudos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `questoes_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

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
