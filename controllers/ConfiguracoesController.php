<?php

/* =========================================
   TECHMINDS EDUCATION
   CONFIGURAÇÕES CONTROLLER
========================================= */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('pages/configuracoes.php');
}

$usuarioId = usuarioLogadoId();

$senhaAtual = $_POST['senha_atual'] ?? '';
$novaSenha = $_POST['nova_senha'] ?? '';
$confirmarSenha = $_POST['confirmar_senha'] ?? '';

if ($senhaAtual === '' || $novaSenha === '' || $confirmarSenha === '') {
    redirecionar('pages/configuracoes.php?erro=preencha');
}

if (strlen($novaSenha) < 6) {
    redirecionar('pages/configuracoes.php?erro=senha_curta');
}

if ($novaSenha !== $confirmarSenha) {
    redirecionar('pages/configuracoes.php?erro=senhas');
}

$usuarioModel = new Usuario();

$hashAtual = $usuarioModel->buscarSenhaHash($usuarioId);

if (!$hashAtual || !password_verify($senhaAtual, $hashAtual)) {
    redirecionar('pages/configuracoes.php?erro=senha_incorreta');
}

try {

    $usuarioModel->atualizarSenha($usuarioId, $novaSenha);

    redirecionar('pages/configuracoes.php?sucesso=1');

} catch (PDOException $e) {

    error_log('Erro ao atualizar senha: ' . $e->getMessage());

    redirecionar('pages/configuracoes.php?erro=atualizar');
}