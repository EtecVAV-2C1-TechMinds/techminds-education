<?php

/* =========================================
   TECHMINDS EDUCATION
   ADMIN CONTROLLER
   (Matérias + gestão de alunos + mensagens)
========================================= */

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Materia.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Contato.php';

$acao = $_GET['acao'] ?? '';


/* =========================================
   CRIAR MATÉRIA
========================================= */

if ($acao === 'materia_criar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirecionar('admin/materias.php');
    }

    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($nome === '') {
        redirecionar('admin/materias.php?erro=preencha');
    }

    try {

        $materiaModel = new Materia();
        $materiaModel->criar($nome, $descricao);

        redirecionar('admin/materias.php?sucesso=criado');

    } catch (PDOException $e) {

        error_log('Erro ao criar matéria: ' . $e->getMessage());
        redirecionar('admin/materias.php?erro=criar');
    }
}


/* =========================================
   EDITAR MATÉRIA
========================================= */

if ($acao === 'materia_editar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirecionar('admin/materias.php');
    }

    $id = (int) ($_POST['id'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    if ($id <= 0 || $nome === '') {
        redirecionar('admin/materias.php?erro=preencha');
    }

    try {

        $materiaModel = new Materia();
        $materiaModel->editar($id, $nome, $descricao, $ativo);

        redirecionar('admin/materias.php?sucesso=editado');

    } catch (PDOException $e) {

        error_log('Erro ao editar matéria: ' . $e->getMessage());
        redirecionar('admin/materias.php?erro=editar');
    }
}


/* =========================================
   EXCLUIR MATÉRIA
========================================= */

if ($acao === 'materia_excluir') {

    $id = (int) ($_GET['id'] ?? 0);

    if ($id <= 0) {
        redirecionar('admin/materias.php?erro=excluir');
    }

    try {

        $materiaModel = new Materia();
        $materiaModel->excluir($id);

        redirecionar('admin/materias.php?sucesso=excluido');

    } catch (PDOException $e) {

        error_log('Erro ao excluir matéria: ' . $e->getMessage());
        redirecionar('admin/materias.php?erro=excluir');
    }
}


/* =========================================
   ATIVAR / DESATIVAR ALUNO
========================================= */

if ($acao === 'aluno_status') {

    $id = (int) ($_GET['id'] ?? 0);
    $status = (int) ($_GET['status'] ?? 1);

    if ($id <= 0 || !in_array($status, [0, 1], true)) {
        redirecionar('admin/alunos.php?erro=status');
    }

    try {

        $usuarioModel = new Usuario();
        $usuarioModel->atualizarStatus($id, $status);

        redirecionar('admin/alunos.php?sucesso=atualizado');

    } catch (PDOException $e) {

        error_log('Erro ao atualizar status do aluno: ' . $e->getMessage());
        redirecionar('admin/alunos.php?erro=status');
    }
}


/* =========================================
   MARCAR MENSAGEM DE CONTATO COMO LIDA
========================================= */

if ($acao === 'mensagem_lida') {

    $id = (int) ($_GET['id'] ?? 0);

    if ($id <= 0) {
        redirecionar('admin/mensagens.php?erro=lida');
    }

    try {

        $contatoModel = new Contato();
        $contatoModel->marcarComoLida($id);

        redirecionar('admin/mensagens.php?sucesso=lida');

    } catch (PDOException $e) {

        error_log('Erro ao marcar mensagem como lida: ' . $e->getMessage());
        redirecionar('admin/mensagens.php?erro=lida');
    }
}


/* =========================================
   EXCLUIR MENSAGEM DE CONTATO
========================================= */

if ($acao === 'mensagem_excluir') {

    $id = (int) ($_GET['id'] ?? 0);

    if ($id <= 0) {
        redirecionar('admin/mensagens.php?erro=excluir');
    }

    try {

        $contatoModel = new Contato();
        $contatoModel->excluir($id);

        redirecionar('admin/mensagens.php?sucesso=excluida');

    } catch (PDOException $e) {

        error_log('Erro ao excluir mensagem: ' . $e->getMessage());
        redirecionar('admin/mensagens.php?erro=excluir');
    }
}


/* =========================================
   AÇÃO INVÁLIDA
========================================= */

redirecionar('admin/painel.php');