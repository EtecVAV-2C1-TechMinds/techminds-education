<?php

/* =========================================
   TECHMINDS EDUCATION
   DATABASE CONNECTION
========================================= */

/* =========================================
   DATABASE SETTINGS
========================================= */
$host = 'localhost';
$database = 'techminds';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

/* =========================================
   PDO CONNECTION
========================================= */
$dsn = "mysql:host={$host};dbname={$database};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    error_log('Erro de conexão PDO: ' . $e->getMessage());

    if (defined('DEBUG') && DEBUG) {
        die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
    } else {
        die('Erro ao conectar ao banco de dados. Tente novamente mais tarde.');
    }
}

/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Integração Backend e Banco de Dados 
Finalidade: Auxílio na sintaxe de envio, resgate e atualização de dados entre formulários web e o banco de dados. 
Validação: Código de manipulação testado na prática, consultas validadas diretamente no phpMyAdmin e comportamentos do sistema checados manualmente. 
*/
