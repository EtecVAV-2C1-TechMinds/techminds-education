<?php

/* =========================================
   TECHMINDS EDUCATION
   AUTHENTICATION
========================================= */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/* =========================================
   CHECK LOGIN
========================================= */

if (
    empty($_SESSION['usuario_logado']) ||
    $_SESSION['usuario_logado'] !== true
) {

    header('Location: ../pages/login.php?erro=acesso');

    exit;
}
