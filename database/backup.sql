-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/11/2026 às 02:12
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
(12, 1, 5, 'A mitose e a meiose são processos de divisão celular com características diferentes.\r\nAssinale a alternativa correta:', 'A mitose sempre produz quatro células geneticamente diferentes.', 'A meiose mantém obrigatoriamente o mesmo número de cromossomos das células parentais.', 'A mitose está relacionada ao crescimento e à renovação celular, enquanto a meiose contribui para a formação de células haploides e para a variabilidade genética.', 'Mitose e meiose são processos idênticos, diferenciando-se apenas pelo nome.', 'A meiose ocorre apenas em células procariontes.', 'C', 'media', 1, '2026-09-25 11:53:34'),
(13, 1, 3, 'Em um ecossistema, fungos e bactérias desempenham um papel fundamental na decomposição de restos de seres vivos e resíduos orgânicos.\r\nEsses organismos são importantes porque:', 'produzem seu próprio alimento por meio da fotossíntese.', 'ocupam sempre o último nível de todas as cadeias alimentares.', 'transformam a matéria orgânica, contribuindo para a reciclagem de nutrientes no ambiente.', 'impedem a transferência de energia entre os níveis tróficos.', 'consomem exclusivamente organismos vivos.', 'C', 'media', 1, '2026-11-05 23:35:03'),
(14, 1, 3, 'Em uma floresta, duas espécies de aves utilizam os mesmos tipos de alimento e disputam locais para construir seus ninhos. Como consequência, uma das espécies pode ter dificuldade para obter os recursos necessários à sua sobrevivência.\r\nEssa situação é um exemplo de:', 'mutualismo.', 'competição interespecífica.', 'comensalismo.', 'parasitismo.', 'predatismo.', 'B', 'media', 1, '2026-11-05 23:36:04'),
(15, 1, 4, 'O sistema digestório é responsável pela transformação dos alimentos em moléculas menores, que podem ser absorvidas e utilizadas pelas células do organismo.\r\nA maior parte da absorção dos nutrientes ocorre no:', 'estômago.', 'esôfago.', 'intestino delgado.', 'intestino grosso.', 'fígado.', 'C', 'media', 1, '2026-11-05 23:36:48'),
(16, 1, 4, 'O sistema nervoso e o sistema endócrino atuam na coordenação das funções do corpo humano. Uma das diferenças entre eles está na forma como transmitem informações.\r\nAssinale a alternativa correta:', 'O sistema endócrino utiliza hormônios transportados pelo sangue para regular diferentes funções do organismo.', 'O sistema nervoso atua exclusivamente na digestão dos alimentos.', 'O sistema endócrino é formado apenas pelo cérebro e pela medula espinhal.', 'Os hormônios são produzidos exclusivamente pelos neurônios.', 'O sistema nervoso e o sistema endócrino não participam da manutenção da homeostase.', 'A', 'media', 1, '2026-11-05 23:37:39'),
(17, 1, 5, 'As organelas celulares desempenham funções essenciais para o funcionamento das células. As mitocôndrias, por exemplo, são responsáveis principalmente pela:', 'produção de proteínas.', 'realização da respiração celular e produção de ATP.', 'digestão de substâncias dentro da célula.', 'armazenagem do material genético.', 'realização da fotossíntese.', 'B', 'media', 1, '2026-11-05 23:38:16'),
(18, 1, 5, 'As células vegetais possuem algumas estruturas que não são encontradas nas células animais. Uma dessas estruturas é responsável pela realização da fotossíntese.\r\nEssa estrutura é chamada de:', 'lisossomo.', 'ribossomo.', 'centríolo.', 'cloroplasto.', 'complexo de Golgi.', 'D', 'media', 1, '2026-11-05 23:38:45'),
(19, 3, 9, 'Considere uma reação entre zinco metálico e íons de cobre. Durante essa reação, o zinco perde elétrons e os íons de cobre recebem esses elétrons.\r\nCom base nessas informações, assinale a alternativa correta:', 'O zinco sofre redução porque recebe elétrons.', 'O cobre sofre oxidação porque recebe elétrons.', 'O zinco sofre oxidação e atua como agente redutor.', 'O cobre sofre oxidação e atua como agente redutor.', 'Não ocorre transferência de elétrons nessa reação.', 'C', 'media', 1, '2026-11-05 23:39:19'),
(20, 3, 9, 'Uma pilha é formada por dois metais diferentes. O primeiro metal apresenta maior tendência a sofrer redução, enquanto o segundo apresenta maior tendência a sofrer oxidação.\r\nSobre o funcionamento dessa pilha, assinale a alternativa correta:', 'A oxidação ocorre no cátodo e a redução ocorre no ânodo.', 'A oxidação ocorre no ânodo e a redução ocorre no cátodo.', 'Tanto a oxidação quanto a redução ocorrem no ânodo.', 'Os elétrons se deslocam espontaneamente do cátodo para o ânodo.', 'A pilha precisa receber energia elétrica continuamente para funcionar.', 'B', 'media', 1, '2026-11-05 23:41:20'),
(21, 3, 9, 'Durante um processo de eletrólise, uma corrente elétrica é mantida durante determinado período. A quantidade de substância produzida nesse processo depende da quantidade de carga elétrica que atravessa o sistema.\r\nConsiderando os princípios da eletrólise, assinale a alternativa correta:', 'Na eletrólise, uma reação química espontânea produz energia elétrica.', 'Na eletrólise, o cátodo é sempre o local onde ocorre oxidação.', 'Na eletrólise, o ânodo é sempre o local onde ocorre redução.', 'Na eletrólise, uma fonte externa de energia elétrica força a ocorrência de uma reação química.', 'A quantidade de substância produzida não depende da quantidade de eletricidade utilizada.', 'D', 'media', 1, '2026-11-05 23:43:52'),
(22, 3, 9, 'Em uma pilha eletroquímica, dois metais apresentam diferentes tendências de perder elétrons. O metal que sofre oxidação libera elétrons, que são transferidos pelo circuito externo até o outro eletrodo.\r\nNesse processo, é correto afirmar que:', 'Os elétrons se deslocam do cátodo para o ânodo pelo circuito externo.', 'O ânodo é o eletrodo onde ocorre a redução.', 'O cátodo é o eletrodo onde ocorre a oxidação.', 'Os elétrons se deslocam do ânodo para o cátodo pelo circuito externo.', 'A ponte salina impede a movimentação de íons entre as soluções.', 'D', 'media', 1, '2026-11-05 23:44:26'),
(23, 3, 9, 'Na eletrólise, uma corrente elétrica pode provocar a deposição de um metal sobre a superfície de um objeto. Esse processo é utilizado, por exemplo, no revestimento metálico de peças. Durante a deposição de um metal, os íons metálicos recebem elétrons e se transformam em átomos metálicos.\r\nEssa transformação corresponde a:', 'oxidação, que ocorre no ânodo.', 'redução, que ocorre no cátodo.', 'oxidação, que ocorre no cátodo.', 'neutralização, que ocorre no ânodo.', 'combustão, que ocorre no cátodo.', 'B', 'media', 1, '2026-11-05 23:45:17'),
(24, 3, 10, 'Uma pessoa possui uma mistura formada por água e areia e deseja separar completamente os dois componentes.\r\nQual método de separação é mais adequado para essa situação?', 'Destilação fracionada.', 'Filtração.', 'Separação magnética.', 'Sublimação.', 'Cromatografia.', 'B', 'media', 1, '2026-11-05 23:47:02'),
(25, 3, 10, 'O petróleo é formado por diversos hidrocarbonetos que apresentam diferentes pontos de ebulição. Durante o processo de refino, seus componentes são separados em diferentes frações.\r\nQual método é utilizado principalmente nesse processo?', 'Catação.', 'Filtração.', 'Destilação fracionada.', 'Separação magnética.', 'Decantação.', 'C', 'media', 1, '2026-11-05 23:47:49'),
(26, 3, 10, 'Uma mistura contém areia e sal. Para separar completamente seus componentes, um estudante adiciona água à mistura, sabendo que o sal se dissolve na água enquanto a areia não. Depois disso, ele realiza uma filtração e, posteriormente, utiliza outro processo para recuperar o sal.\r\nSobre esse procedimento, assinale a alternativa correta:', 'A primeira etapa utiliza dissolução fracionada e a filtração permite separar a areia da solução.', 'A primeira etapa corresponde à separação magnética e a filtração separa o sal da água.', 'A água transforma a areia em uma substância solúvel e permite sua evaporação.', 'A filtração é suficiente para recuperar separadamente tanto a areia quanto o sal sólido.', 'O processo utiliza exclusivamente a destilação fracionada.', 'A', 'media', 1, '2026-11-05 23:48:54'),
(27, 3, 10, 'Em um laboratório, um estudante precisa separar uma mistura heterogênea formada por água e óleo. Após algum tempo em repouso, é possível observar a formação de duas fases distintas.\r\nQual método é mais adequado para separar esses componentes?', 'Filtração simples.', 'Destilação fracionada.', 'Decantação, utilizando um funil de separação.', 'Separação magnética.', 'Sublimação.', 'C', 'media', 1, '2026-11-05 23:49:45'),
(28, 3, 10, 'Uma mistura homogênea é formada por água e sal de cozinha dissolvido. Um estudante deseja recuperar o sal sólido presente nessa mistura, sem a necessidade de recuperar a água.\r\nQual método de separação é o mais adequado?', 'Filtração.', 'Evaporação do solvente.', 'Decantação.', 'Catação.', 'Separação magnética.', 'B', 'media', 1, '2026-11-05 23:50:44'),
(29, 3, 11, 'Um estudante analisou um composto orgânico e verificou que ele é formado apenas por carbono e hidrogênio. Além disso, sua estrutura apresenta apenas ligações simples entre os átomos de carbono.\r\nCom base nessas características, esse composto pertence à função dos:', 'Álcoois.', 'Alcanos.', 'Alcenos.', 'Ácidos carboxílicos.', 'Ésteres.', 'B', 'media', 1, '2026-11-05 23:51:19'),
(30, 3, 11, 'Dois compostos orgânicos apresentam o mesmo número e os mesmos tipos de átomos, mas possuem diferentes formas de organização dos átomos em suas estruturas. Por causa dessa diferença estrutural, podem apresentar propriedades diferentes.\r\nO fenômeno descrito corresponde ao conceito de:', 'Combustão.', 'Polimerização.', 'Isomeria.', 'Oxidação.', 'Neutralização.', 'C', 'media', 1, '2026-11-05 23:51:52'),
(31, 3, 11, 'Um estudante precisa identificar a função orgânica de uma substância que possui um grupo hidroxila ligado diretamente a um anel aromático.\r\nA qual função orgânica essa substância pertence?', 'Álcool.', 'Éter.', 'Cetona.', 'Fenol.', 'Aldeído.', 'D', 'media', 1, '2026-11-05 23:52:21'),
(32, 3, 11, 'Os compostos orgânicos podem ser classificados de acordo com os grupos funcionais presentes em suas estruturas. Observe as características de uma substância que apresenta um grupo carbonila (C=O) localizado entre dois átomos de carbono.\r\nEssa substância pertence à função orgânica dos:', 'Aldeídos.', 'Álcoois.', 'Cetonas.', 'Ácidos carboxílicos.', 'Aminas.', 'C', 'media', 1, '2026-11-05 23:53:30'),
(33, 3, 11, 'Os hidrocarbonetos são compostos orgânicos formados exclusivamente por carbono e hidrogênio. Dependendo do tipo de ligação entre os átomos de carbono, eles podem ser classificados em diferentes grupos.\r\nUm hidrocarboneto que apresenta pelo menos uma ligação dupla entre carbonos pertence à classe dos:', 'Alcanos.', 'Alcenos.', 'Álcoois.', 'Éteres.', 'Ésteres.', 'B', 'media', 1, '2026-11-05 23:54:09'),
(34, 2, 6, 'Um aparelho elétrico está conectado a uma fonte de tensão e apresenta determinada resistência elétrica. Considerando a Primeira Lei de Ohm, se a resistência permanecer constante e a tensão aplicada ao aparelho aumentar, o que acontecerá com a corrente elétrica?', 'A corrente diminuirá.', 'A corrente permanecerá necessariamente igual.', 'A corrente aumentará.', 'A corrente se tornará nula.', 'A resistência aumentará automaticamente.', 'C', 'media', 1, '2026-11-05 23:55:05'),
(35, 2, 6, 'Em uma residência, diversos aparelhos elétricos precisam funcionar de maneira independente. Dessa forma, quando um aparelho é desligado ou deixa de funcionar, os demais devem continuar recebendo energia elétrica normalmente.\r\nQual tipo de associação é mais adequado para esse funcionamento?', 'Associação em série.', 'Associação em paralelo.', 'Associação exclusivamente magnética.', 'Associação sem resistência.', 'Associação em circuito aberto.', 'B', 'media', 1, '2026-11-05 23:56:02'),
(36, 2, 6, 'Um chuveiro elétrico transforma grande parte da energia elétrica recebida em energia térmica, aquecendo a água que passa por ele.\r\nO fenômeno físico responsável por essa transformação de energia é conhecido como:', 'Efeito Doppler.', 'Indução magnética.', 'Efeito Joule.', 'Reflexão elétrica.', 'Polarização.', 'C', 'media', 1, '2026-11-05 23:58:41'),
(37, 2, 6, 'Um resistor de resistência elétrica igual a 10 é ligado a uma fonte de tensão de 20V. Considerando que o resistor obedece à Primeira Lei de Ohm, qual é a intensidade da corrente elétrica que o atravessa?', '0,5A', '2A', '10A', '20A', '200A', 'B', 'media', 1, '2026-11-05 23:59:27'),
(38, 2, 6, 'Em um circuito elétrico, a potência indica a quantidade de energia elétrica transformada ou consumida por unidade de tempo.\r\nUm aparelho elétrico possui potência de 1.000W e permanece ligado durante 2 horas. Qual é a energia elétrica consumida nesse período?', '500Wh', '1.000Wh', '2.000Wh', '3.000Wh', '5.000Wh', 'C', 'media', 1, '2026-11-06 00:00:03'),
(39, 2, 8, 'Um estudante coloca uma colher de metal dentro de uma panela que contém água quente. Depois de algum tempo, a parte da colher que estava fora da água também apresenta aumento de temperatura.\r\nQual é o principal processo de transferência de energia térmica responsável pelo aquecimento da colher?', 'Convecção.', 'Radiação.', 'Condução.', 'Evaporação.', 'Sublimação.', 'C', 'media', 1, '2026-11-06 00:00:47'),
(40, 2, 8, 'Um recipiente contém uma determinada quantidade de água sendo aquecida. Durante o aquecimento, a temperatura da água aumenta até atingir seu ponto de ebulição. Enquanto a água permanece em ebulição, a temperatura permanece aproximadamente constante, mesmo com o fornecimento contínuo de energia.\r\nNesse período, a energia fornecida está principalmente relacionada:', 'Ao aumento da temperatura da água.', 'À mudança de estado físico da água.', 'À diminuição da massa da água sem mudança de estado.', 'Ao aumento da temperatura do recipiente exclusivamente.', 'À transformação da água em uma substância diferente.', 'B', 'media', 1, '2026-11-06 00:01:46'),
(41, 2, 8, 'Durante o verão, algumas estruturas metálicas de pontes e trilhos precisam possuir espaços ou juntas que permitam pequenas alterações em seu comprimento.\r\nEsses espaços são necessários principalmente porque:', 'Os metais não possuem temperatura própria.', 'O aumento da temperatura pode provocar dilatação térmica dos materiais.', 'O calor transforma os metais diretamente em líquidos.', 'A temperatura faz com que a massa dos metais desapareça.', 'A radiação impede que os metais mantenham seu comprimento.', 'B', 'media', 1, '2026-11-06 00:02:28'),
(42, 2, 8, 'Em um dia frio, uma pessoa utiliza uma garrafa térmica para manter seu café quente por mais tempo. Esse recipiente é construído de modo a reduzir as trocas de energia térmica entre o líquido e o ambiente.\r\nA principal finalidade da garrafa térmica é:', 'aumentar a temperatura do café continuamente.', 'impedir completamente qualquer transformação de energia.', 'reduzir a transferência de energia térmica entre o café e o ambiente.', 'transformar o calor em massa.', 'aumentar a condução térmica entre o líquido e o recipiente.', 'C', 'media', 1, '2026-11-06 00:02:59'),
(43, 2, 8, 'Uma barra metálica de 2 metros de comprimento é aquecida, provocando um aumento em sua temperatura. Como consequência, seu comprimento também aumenta.\r\nEsse fenômeno é denominado:', 'contração térmica.', 'equilíbrio térmico.', 'fusão.', 'dilatação térmica linear.', 'condução elétrica.', 'D', 'media', 1, '2026-11-06 00:03:47'),
(44, 2, 7, 'Uma onda se propaga em determinado meio transportando energia. Durante sua propagação, as partículas do meio oscilam perpendicularmente à direção em que a onda se desloca.\r\nCom base nessa característica, essa onda é classificada como:', 'Longitudinal.', 'Transversal.', 'Estacionária obrigatoriamente.', 'Eletrostática.', 'Térmica.', 'B', 'media', 1, '2026-11-06 00:04:23'),
(45, 2, 7, 'Uma onda possui determinada frequência e comprimento de onda. Durante sua propagação, a frequência permanece constante, mas a onda passa para outro meio no qual sua velocidade de propagação é diferente.\r\nO que acontece com o comprimento de onda?', 'Permanece necessariamente igual, independentemente da velocidade.', 'Torna-se zero.', 'Também se altera, pois a velocidade, a frequência e o comprimento de onda estão relacionados.', 'A frequência obrigatoriamente aumenta.', 'A onda deixa de transportar energia.', 'C', 'media', 1, '2026-11-06 00:05:25'),
(46, 2, 7, 'Uma pessoa está em frente a uma grande parede e emite um som. Após determinado intervalo de tempo, ela percebe novamente o som produzido.\r\nO fenômeno responsável pela repetição do som percebido é:', 'Refração.', 'Difração.', 'Polarização.', 'Reflexão.', 'Ressonância.', 'D', 'media', 1, '2026-11-06 00:06:10'),
(47, 2, 7, 'Uma onda sonora se propaga pelo ar com determinada frequência. Ao passar de uma região para outra, sua velocidade de propagação aumenta, mas a frequência permanece constante.\r\nNessa situação, o comprimento de onda:', 'Diminui, pois a velocidade aumentou.', 'Aumenta, pois a velocidade aumentou e a frequência permaneceu constante.', 'Permanece sempre igual, independentemente da velocidade.', 'Torna-se zero.', 'Faz com que a onda deixe de transportar energia.', 'B', 'media', 1, '2026-11-06 00:06:51'),
(48, 2, 7, 'Ao ouvir uma música, uma pessoa percebe sons graves e agudos produzidos por diferentes instrumentos musicais.\r\nA característica física da onda sonora relacionada à distinção entre sons graves e agudos é:', 'Amplitude.', 'Velocidade de propagação.', 'Frequência.', 'Intensidade luminosa.', 'Comprimento do instrumento.', 'C', 'media', 1, '2026-11-06 00:07:32');

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
(9, 8, 2, 'B', 0, '2026-09-25 11:40:51'),
(10, 7, 10, 'B', 0, '2026-11-05 12:12:37'),
(11, 7, 11, 'B', 0, '2026-11-05 12:12:37'),
(12, 7, 12, 'C', 1, '2026-11-05 12:12:37'),
(13, 7, 10, 'D', 0, '2026-11-05 20:14:05'),
(14, 7, 11, 'A', 1, '2026-11-05 20:14:05'),
(15, 7, 12, 'C', 1, '2026-11-05 20:14:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `simulados`
--

CREATE TABLE `simulados` (
  `id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `tempo_minutos` int(11) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `simulados`
--

INSERT INTO `simulados` (`id`, `titulo`, `descricao`, `pdf_path`, `tempo_minutos`, `ativo`, `data_criacao`) VALUES
(1, 'Simulado de Genética Básica', 'Teste seus conhecimentos sobre os principais conceitos de genética mendeliana.', NULL, 10, 1, '2026-09-16 09:03:56'),
(2, 'Simulado de Bio Teste', 'edzbhdthbdtned', NULL, 60, 1, '2026-09-25 00:52:14'),
(4, 'Introdução a Químicafqef', 'efwfgwe', NULL, 45, 1, '2026-09-25 01:09:03'),
(6, 'asd', 'def', NULL, 4, 1, '2026-09-25 01:22:38'),
(8, 'teste 29.10', 'gfiyfifgy', 'uploads/pdf-simulados/7e7126a00b099d2daddc05adbb553385.pdf', 150, 1, '2026-10-29 17:12:36'),
(9, 'Teste1', 'adfaf', 'uploads/pdf-simulados/55cec0b104d50f6c8d36a993bcc58269.pdf', 1, 1, '2026-11-05 13:11:13'),
(10, 'tate2', 'asfwrg', 'uploads/pdf-simulados/93292e524fc8b23c1264ce26be3b6d6e.pdf', 70, 0, '2026-11-05 23:20:04');

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

--
-- Despejando dados para a tabela `simulados_resultados`
--

INSERT INTO `simulados_resultados` (`id`, `usuario_id`, `simulado_id`, `total_questoes`, `acertos`, `data_realizacao`) VALUES
(1, 7, 8, 45, 13, '2026-11-05 19:49:57'),
(2, 7, 8, 45, 4, '2026-11-05 19:54:43'),
(3, 7, 8, 45, 4, '2026-11-05 19:55:03'),
(4, 7, 8, 45, 8, '2026-11-05 20:00:27'),
(5, 7, 8, 45, 0, '2026-11-05 20:17:25'),
(6, 7, 8, 45, 3, '2026-11-05 21:04:33'),
(7, 7, 8, 45, 2, '2026-11-05 21:07:55'),
(8, 7, 8, 45, 2, '2026-11-05 21:08:40'),
(9, 7, 8, 45, 2, '2026-11-05 21:08:45'),
(10, 7, 8, 45, 1, '2026-11-05 21:13:40'),
(11, 7, 9, 45, 0, '2026-11-05 21:16:47'),
(12, 7, 9, 45, 0, '2026-11-05 22:53:29'),
(13, 7, 9, 45, 0, '2026-11-05 22:58:05'),
(14, 7, 9, 45, 1, '2026-11-05 22:59:22'),
(15, 7, 9, 45, 0, '2026-11-05 23:24:04'),
(16, 7, 8, 45, 0, '2026-11-06 00:09:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `simulado_gabarito`
--

CREATE TABLE `simulado_gabarito` (
  `id` int(11) NOT NULL,
  `simulado_id` int(10) UNSIGNED NOT NULL,
  `numero_questao` int(11) NOT NULL,
  `resposta_correta` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `simulado_gabarito`
--

INSERT INTO `simulado_gabarito` (`id`, `simulado_id`, `numero_questao`, `resposta_correta`) VALUES
(91, 8, 1, 'B'),
(92, 8, 2, 'B'),
(93, 8, 3, 'B'),
(94, 8, 4, 'B'),
(95, 8, 5, 'B'),
(96, 8, 6, 'B'),
(97, 8, 7, 'B'),
(98, 8, 8, 'B'),
(99, 8, 9, 'B'),
(100, 8, 10, 'B'),
(101, 8, 11, 'B'),
(102, 8, 12, 'B'),
(103, 8, 13, 'B'),
(104, 8, 14, 'B'),
(105, 8, 15, 'B'),
(106, 8, 16, 'C'),
(107, 8, 17, 'C'),
(108, 8, 18, 'C'),
(109, 8, 19, 'C'),
(110, 8, 20, 'C'),
(111, 8, 21, 'C'),
(112, 8, 22, 'C'),
(113, 8, 23, 'C'),
(114, 8, 24, 'C'),
(115, 8, 25, 'C'),
(116, 8, 26, 'C'),
(117, 8, 27, 'C'),
(118, 8, 28, 'C'),
(119, 8, 29, 'C'),
(120, 8, 30, 'C'),
(121, 8, 31, 'D'),
(122, 8, 32, 'D'),
(123, 8, 33, 'D'),
(124, 8, 34, 'D'),
(125, 8, 35, 'D'),
(126, 8, 36, 'D'),
(127, 8, 37, 'D'),
(128, 8, 38, 'D'),
(129, 8, 39, 'D'),
(130, 8, 40, 'D'),
(131, 8, 41, 'D'),
(132, 8, 42, 'D'),
(133, 8, 43, 'D'),
(134, 8, 44, 'D'),
(135, 8, 45, 'D'),
(361, 10, 1, 'A'),
(362, 10, 2, 'A'),
(363, 10, 3, 'A'),
(364, 10, 4, 'A'),
(365, 10, 5, 'A'),
(366, 10, 6, 'A'),
(367, 10, 7, 'A'),
(368, 10, 8, 'A'),
(369, 10, 9, 'A'),
(370, 10, 10, 'A'),
(371, 10, 11, 'A'),
(372, 10, 12, 'A'),
(373, 10, 13, 'A'),
(374, 10, 14, 'A'),
(375, 10, 15, 'A'),
(376, 10, 16, 'B'),
(377, 10, 17, 'B'),
(378, 10, 18, 'B'),
(379, 10, 19, 'B'),
(380, 10, 20, 'B'),
(381, 10, 21, 'B'),
(382, 10, 22, 'B'),
(383, 10, 23, 'B'),
(384, 10, 24, 'B'),
(385, 10, 25, 'B'),
(386, 10, 26, 'B'),
(387, 10, 27, 'B'),
(388, 10, 28, 'B'),
(389, 10, 29, 'B'),
(390, 10, 30, 'B'),
(391, 10, 31, 'C'),
(392, 10, 32, 'C'),
(393, 10, 33, 'C'),
(394, 10, 34, 'C'),
(395, 10, 35, 'C'),
(396, 10, 36, 'C'),
(397, 10, 37, 'C'),
(398, 10, 38, 'C'),
(399, 10, 39, 'C'),
(400, 10, 40, 'C'),
(401, 10, 41, 'C'),
(402, 10, 42, 'C'),
(403, 10, 43, 'C'),
(404, 10, 44, 'C'),
(405, 10, 45, 'C'),
(451, 9, 1, 'D'),
(452, 9, 2, 'D'),
(453, 9, 3, 'D'),
(454, 9, 4, 'D'),
(455, 9, 5, 'D'),
(456, 9, 6, 'D'),
(457, 9, 7, 'D'),
(458, 9, 8, 'D'),
(459, 9, 9, 'D'),
(460, 9, 10, 'D'),
(461, 9, 11, 'D'),
(462, 9, 12, 'D'),
(463, 9, 13, 'D'),
(464, 9, 14, 'D'),
(465, 9, 15, 'D'),
(466, 9, 16, 'E'),
(467, 9, 17, 'E'),
(468, 9, 18, 'E'),
(469, 9, 19, 'E'),
(470, 9, 20, 'E'),
(471, 9, 21, 'E'),
(472, 9, 22, 'E'),
(473, 9, 23, 'E'),
(474, 9, 24, 'E'),
(475, 9, 25, 'E'),
(476, 9, 26, 'E'),
(477, 9, 27, 'D'),
(478, 9, 28, 'D'),
(479, 9, 29, 'D'),
(480, 9, 30, 'B'),
(481, 9, 31, 'E'),
(482, 9, 32, 'E'),
(483, 9, 33, 'E'),
(484, 9, 34, 'E'),
(485, 9, 35, 'E'),
(486, 9, 36, 'E'),
(487, 9, 37, 'E'),
(488, 9, 38, 'E'),
(489, 9, 39, 'E'),
(490, 9, 40, 'E'),
(491, 9, 41, 'E'),
(492, 9, 42, 'E'),
(493, 9, 43, 'E'),
(494, 9, 44, 'E'),
(495, 9, 45, 'E');

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
-- Índices de tabela `simulado_gabarito`
--
ALTER TABLE `simulado_gabarito`
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `respostas_questoes`
--
ALTER TABLE `respostas_questoes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `simulados`
--
ALTER TABLE `simulados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `simulados_resultados`
--
ALTER TABLE `simulados_resultados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `simulado_gabarito`
--
ALTER TABLE `simulado_gabarito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=496;

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
-- Restrições para tabelas `simulado_gabarito`
--
ALTER TABLE `simulado_gabarito`
  ADD CONSTRAINT `fk_simulado_gabarito` FOREIGN KEY (`simulado_id`) REFERENCES `simulados` (`id`) ON DELETE CASCADE;

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
