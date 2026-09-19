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
