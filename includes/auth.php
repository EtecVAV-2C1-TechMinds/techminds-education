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

/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Camada de controle
Finalidade: Orientação na organização dos links e no redirecionamento entre páginas do projeto. 
Validação: Todos os caminhos e navegações foram testados manualmente no navegador para evitar links quebrados. 
*/
