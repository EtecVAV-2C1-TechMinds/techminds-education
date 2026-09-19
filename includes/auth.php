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

if (empty($_SESSION[SESSION_USUARIO])) {

    header('Location: ' . URL_SISTEMA . '/pages/login.php?erro=acesso');

    exit;
}

/* =========================================
   CHECK ADMIN ACCESS (opcional por página)
========================================= */

if (!empty($GLOBALS['EXIGE_ADMIN']) && ($_SESSION[SESSION_TIPO] ?? null) !== TIPO_ADMIN) {

    header('Location: ' . URL_SISTEMA . '/pages/login.php?erro=permissao');

    exit;
}
