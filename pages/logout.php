<?php

require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Limpa todas as variáveis da sessão */
$_SESSION = [];

/* Remove o cookie da sessão */
if (ini_get('session.use_cookies')) {

    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

/* Destrói a sessão */
session_destroy();

/* Volta para a página inicial */
header('Location: ' . URL_SISTEMA . '/index.php');
exit;


/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Desenvolvimento de Layout.
Finalidade: Apoio na solução de alinhamentos (Flexbox/Grid) e regras de responsividade CSS. 
Validação: Estilos aplicados, inspecionados via Ferramentas do Desenvolvedor no navegador e testados em telas móveis e desktop pelas alunas. 
*/
