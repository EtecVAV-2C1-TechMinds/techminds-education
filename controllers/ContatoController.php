<?php

/* =========================================
   TECHMINDS EDUCATION
   CONTATO CONTROLLER
========================================= */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Contato.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('pages/contato.php');
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$assunto = trim($_POST['assunto'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if ($nome === '' || $mensagem === '') {
    redirecionar('pages/contato.php?erro=preencha');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirecionar('pages/contato.php?erro=email');
}

try {

    $contatoModel = new Contato();

    $contatoModel->salvar($nome, $email, $assunto, $mensagem);

    redirecionar('pages/contato.php?sucesso=1');

} catch (PDOException $e) {

    error_log('Erro ao salvar mensagem de contato: ' . $e->getMessage());

    redirecionar('pages/contato.php?erro=enviar');
}

/*
DECLARAÇÃO DE USO DE INTELIGÊNCIA ARTIFICIAL

Ferramenta: ChatGPT
Etapa: Camada de controle
Finalidade: Orientação na organização dos links e no redirecionamento entre páginas do projeto. 
Validação: Todos os caminhos e navegações foram testados manualmente no navegador para evitar links quebrados. 
*/
