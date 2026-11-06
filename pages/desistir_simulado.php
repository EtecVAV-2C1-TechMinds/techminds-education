<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

$simuladoId = (int) ($_GET['id'] ?? 0);

if ($simuladoId > 0) {

    $chaveInicio = 'simulado_inicio_' . $simuladoId;

    // Apaga o horário inicial da sessão
    unset($_SESSION[$chaveInicio]);
}

// Volta para a página de simulados
header('Location: ' . URL_SISTEMA . '/pages/simulados.php');
exit;
