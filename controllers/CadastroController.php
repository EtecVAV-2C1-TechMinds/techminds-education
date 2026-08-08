<?php

/* =========================================
   TECHMINDS EDUCATION
   REGISTRATION CONTROLLER
========================================= */

require_once __DIR__ . '/../models/Usuario.php';


/* =========================================
   CHECK REQUEST
========================================= */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Location: ../pages/cadastro.php');

    exit;

}


/* =========================================
   RECEIVE FORM DATA
========================================= */

$nome = trim($_POST['nome'] ?? '');

$email = trim($_POST['email'] ?? '');

$senha = $_POST['senha'] ?? '';

$confirmarSenha = $_POST['confirmar_senha'] ?? '';


/* =========================================
   VALIDATION
========================================= */

if (
    empty($nome) ||
    empty($email) ||
    empty($senha) ||
    empty($confirmarSenha)
) {

    header(
        'Location: ../pages/cadastro.php?erro=preencha'
    );

    exit;

}


/* =========================================
   VALIDATE EMAIL
========================================= */

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header(
        'Location: ../pages/cadastro.php?erro=email'
    );

    exit;

}


/* =========================================
   CONFIRM PASSWORD
========================================= */

if ($senha !== $confirmarSenha) {

    header(
        'Location: ../pages/cadastro.php?erro=senhas'
    );

    exit;

}


/* =========================================
   PASSWORD LENGTH
========================================= */

if (strlen($senha) < 6) {

    header(
        'Location: ../pages/cadastro.php?erro=senha_curta'
    );

    exit;

}


/* =========================================
   CREATE USER MODEL
========================================= */

$usuario = new Usuario();


/* =========================================
   CHECK EMAIL
========================================= */

if ($usuario->emailExiste($email)) {

    header(
        'Location: ../pages/cadastro.php?erro=email_existente'
    );

    exit;

}


/* =========================================
   REGISTER USER
========================================= */

try {

    $cadastro = $usuario->cadastrar(
        $nome,
        $email,
        $senha
    );


    if ($cadastro) {

        header(
            'Location: ../pages/login.php?cadastro=sucesso'
        );

        exit;

    }


    header(
        'Location: ../pages/cadastro.php?erro=cadastro'
    );

    exit;


} catch (PDOException $e) {

    header(
        'Location: ../pages/cadastro.php?erro=database'
    );

    exit;

}
