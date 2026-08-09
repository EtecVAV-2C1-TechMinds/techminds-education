/* =========================================
   TECHMINDS EDUCATION
   DATABASE
========================================= */


/* =========================================
   CREATE DATABASE
========================================= */

CREATE DATABASE IF NOT EXISTS techminds
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE techminds;


/* =========================================
   USERS
========================================= */

CREATE TABLE IF NOT EXISTS usuarios (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    senha VARCHAR(255) NOT NULL,

    tipo ENUM('aluno', 'admin')
        NOT NULL DEFAULT 'aluno',

    ativo TINYINT(1)
        NOT NULL DEFAULT 1,

    data_cadastro TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB;


/* =========================================
   SUBJECTS
========================================= */

CREATE TABLE IF NOT EXISTS materias (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL,

    descricao TEXT,

    ativo TINYINT(1)
        NOT NULL DEFAULT 1,

    data_criacao TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB;


/* =========================================
   CONTENT
========================================= */

CREATE TABLE IF NOT EXISTS conteudos (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    materia_id INT UNSIGNED NOT NULL,

    titulo VARCHAR(150) NOT NULL,

    descricao TEXT,

    ativo TINYINT(1)
        NOT NULL DEFAULT 1,

    data_criacao TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (materia_id)
        REFERENCES materias(id)
        ON DELETE CASCADE

) ENGINE=InnoDB;


/* =========================================
   CLASSES
========================================= */

CREATE TABLE IF NOT EXISTS aulas (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    conteudo_id INT UNSIGNED NOT NULL,

    titulo VARCHAR(150) NOT NULL,

    descricao TEXT,

    video VARCHAR(255),

    material VARCHAR(255),

    ordem INT
        NOT NULL DEFAULT 1,

    ativo TINYINT(1)
        NOT NULL DEFAULT 1,

    data_criacao TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (conteudo_id)
        REFERENCES conteudos(id)
        ON DELETE CASCADE

) ENGINE=InnoDB;


/* =========================================
   QUESTIONS
========================================= */

CREATE TABLE IF NOT EXISTS questoes (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    materia_id INT UNSIGNED NOT NULL,

    enunciado TEXT NOT NULL,

    alternativa_a TEXT NOT NULL,

    alternativa_b TEXT NOT NULL,

    alternativa_c TEXT NOT NULL,

    alternativa_d TEXT NOT NULL,

    alternativa_e TEXT NOT NULL,

    resposta_correta CHAR(1) NOT NULL,

    dificuldade ENUM(
        'facil',
        'media',
        'dificil'
    )
    NOT NULL DEFAULT 'media',

    ativo TINYINT(1)
        NOT NULL DEFAULT 1,

    data_criacao TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (materia_id)
        REFERENCES materias(id)
        ON DELETE CASCADE

) ENGINE=InnoDB;


/* =========================================
   MOCK EXAMS
========================================= */

CREATE TABLE IF NOT EXISTS simulados (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    titulo VARCHAR(150) NOT NULL,

    descricao TEXT,

    tempo_minutos INT,

    ativo TINYINT(1)
        NOT NULL DEFAULT 1,

    data_criacao TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB;


/* =========================================
   MOCK EXAM QUESTIONS
========================================= */

CREATE TABLE IF NOT EXISTS simulado_questoes (

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    simulado_id INT UNSIGNED NOT NULL,

    questao_id INT UNSIGNED NOT NULL,

    ordem INT
        NOT NULL DEFAULT 1,

    FOREIGN KEY (simulado_id)
        REFERENCES simulados(id)
        ON DELETE CASCADE,

    FOREIGN KEY (questao_id)
        REFERENCES questoes(id)
        ON DELETE CASCADE

) ENGINE=InnoDB;


/* =========================================
   INITIAL SUBJECTS
========================================= */

INSERT INTO materias
(nome, descricao)
VALUES

(
    'Biologia',
    'Conteúdos de Biologia direcionados ao ENEM e vestibulares.'
),

(
    'Física',
    'Conteúdos de Física direcionados ao ENEM e vestibulares.'
),

(
    'Química',
    'Conteúdos de Química direcionados ao ENEM e vestibulares.'
);
