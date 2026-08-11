<?php

/* =========================================
   TECHMINDS EDUCATION
   LOGIN CONTROLLER
========================================= */

session_start();

require_once __DIR__ . '/../models/Usuario.php';


/* =========================================
   CHECK REQUEST METHOD
========================================= */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Location: ../pages/login.php');

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

if (empty($email) || empty($senha)) {

    header(
        'Location: ../pages/login.php?erro=preencha'
    );

    exit;

}


/* =========================================
   VALIDATE EMAIL
========================================= */

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header(
        'Location: ../pages/login.php?erro=email'
    );

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
   CHECK IF USER EXISTS
========================================= */

if (!$usuario) {

    header(
        'Location: ../pages/login.php?erro=login'
    );

    exit;

}


/* =========================================
   CHECK ACCOUNT STATUS
========================================= */

if (isset($usuario['ativo']) && (int) $usuario['ativo'] !== 1) {

    header(
        'Location: ../pages/login.php?erro=desativado'
    );

    exit;

}


/* =========================================
   VERIFY PASSWORD
========================================= */

if (!password_verify($senha, $usuario['senha'])) {

    header(
        'Location: ../pages/login.php?erro=login'
    );

    exit;

}


/* =========================================
   CREATE USER SESSION
========================================= */

session_regenerate_id(true);


$_SESSION['usuario_id'] = $usuario['id'];

$_SESSION['usuario_nome'] = $usuario['nome'];

$_SESSION['usuario_email'] = $usuario['email'];

$_SESSION['usuario_tipo'] = $usuario['tipo'] ?? 'aluno';

$_SESSION['usuario_logado'] = true;


/* =========================================
   LOGIN SUCCESS
========================================= */

header(
    'Location: ../index.php?login=sucesso'
);

exit;
