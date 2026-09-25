<?php

/* =========================================
   TECHMINDS EDUCATION
   LOGIN CONTROLLER
========================================= */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Usuario.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================================
   CHECK REQUEST METHOD
========================================= */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . URL_SISTEMA . '/pages/login.php');
    exit;
}

/* =========================================
   RECEIVE FORM DATA
========================================= */

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

/* =========================================
   VALIDATE REQUIRED FIELDS
========================================= */

if ($email === '' || $senha === '') {
    header('Location: ' . URL_SISTEMA . '/pages/login.php?erro=preencha');
    exit;
}

/* =========================================
   VALIDATE EMAIL
========================================= */

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ' . URL_SISTEMA . '/pages/login.php?erro=email');
    exit;
}

/* =========================================
   CREATE USER MODEL
========================================= */

$usuarioModel = new Usuario();

/* =========================================
   SEARCH USER BY EMAIL
========================================= */

$usuario = $usuarioModel->buscarPorEmail($email);

/* =========================================
   CHECK USER
========================================= */

if (!$usuario) {
    header('Location: ' . URL_SISTEMA . '/pages/login.php?erro=login');
    exit;
}

/* =========================================
   CHECK ACCOUNT STATUS
========================================= */

if (isset($usuario['ativo']) && (int) $usuario['ativo'] !== USUARIO_ATIVO) {
    header('Location: ' . URL_SISTEMA . '/pages/login.php?erro=desativado');
    exit;
}

/* =========================================
   VERIFY PASSWORD
========================================= */

if (!isset($usuario['senha']) || !password_verify($senha, $usuario['senha'])) {
    header('Location: ' . URL_SISTEMA . '/pages/login.php?erro=login');
    exit;
}

/* =========================================
   REGENERATE SESSION ID
========================================= */

session_regenerate_id(true);

/* =========================================
   CREATE USER SESSION
========================================= */

$_SESSION[SESSION_USUARIO] = (int) $usuario['id'];
$_SESSION[SESSION_TIPO] = $usuario['tipo'] ?? TIPO_ALUNO;
$_SESSION['usuario_nome'] = $usuario['nome'];
$_SESSION['usuario_email'] = $usuario['email'];

/* =========================================
   LOGIN SUCCESS
========================================= */

header('Location: ' . URL_SISTEMA . '/index.php?login=sucesso');
exit;


/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Camada de controle
Finalidade: Orientação na organização dos links e no redirecionamento entre páginas do projeto. 
Validação: Todos os caminhos e navegações foram testados manualmente no navegador para evitar links quebrados. 
*/
