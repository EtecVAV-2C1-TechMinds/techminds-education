<?php

/* =========================================
   TECHMINDS EDUCATION
   SIMULADO CONTROLLER
========================================= */

require_once __DIR__ . '/../config/config.php';

$GLOBALS['EXIGE_ADMIN'] = true;

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/Simulado.php';

$acao = $_GET['acao'] ?? '';


/* =========================================
   CRIAR SIMULADO
========================================= */

if ($acao === 'criar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirecionar('admin/simulados.php');
    }

    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $tempo_minutos = (int) ($_POST['tempo_minutos'] ?? 0);

    if ($titulo === '') {
        redirecionar('admin/simulados.php?erro=preencha');
    }

    if ($tempo_minutos <= 0) {
        $tempo_minutos = null;
    }

    try {

        $simuladoModel = new Simulado();

        $idGerado = $simuladoModel->criar($titulo, $descricao, $tempo_minutos);

        redirecionar('admin/simulados.php?sucesso=criado&id=' . $idGerado);

    } catch (PDOException $e) {

        error_log('Erro ao criar simulado: ' . $e->getMessage());

        redirecionar('admin/simulados.php?erro=criar');
    }
}


/* =========================================
   EDITAR SIMULADO
========================================= */

if ($acao === 'editar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirecionar('admin/simulados.php');
    }

    $id = (int) ($_POST['id'] ?? 0);
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $tempo_minutos = (int) ($_POST['tempo_minutos'] ?? 0);
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    if ($id <= 0 || $titulo === '') {
        redirecionar('admin/simulados.php?erro=preencha');
    }

    if ($tempo_minutos <= 0) {
        $tempo_minutos = null;
    }

    try {

        $simuladoModel = new Simulado();

        $simuladoModel->editar($id, $titulo, $descricao, $tempo_minutos, $ativo);

        redirecionar('admin/simulados.php?sucesso=editado');

    } catch (PDOException $e) {

        error_log('Erro ao editar simulado: ' . $e->getMessage());

        redirecionar('admin/simulados.php?erro=editar');
    }
}


/* =========================================
   EXCLUIR SIMULADO
========================================= */

if ($acao === 'excluir') {

    $id = (int) ($_GET['id'] ?? 0);

    if ($id <= 0) {
        redirecionar('admin/simulados.php?erro=excluir');
    }

    try {

        $simuladoModel = new Simulado();

        $simuladoModel->excluir($id);

        redirecionar('admin/simulados.php?sucesso=excluido');

    } catch (PDOException $e) {

        error_log('Erro ao excluir simulado: ' . $e->getMessage());

        redirecionar('admin/simulados.php?erro=excluir');
    }
}


/* =========================================
   ADICIONAR QUESTÃO AO SIMULADO
========================================= */

if ($acao === 'adicionar_questao') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirecionar('admin/simulados.php');
    }

    $simulado_id = (int) ($_POST['simulado_id'] ?? 0);
    $questao_id = (int) ($_POST['questao_id'] ?? 0);

    if ($simulado_id <= 0 || $questao_id <= 0) {
        redirecionar('admin/simulado_questoes.php?id=' . $simulado_id . '&erro=preencha');
    }

    try {

        $simuladoModel = new Simulado();

        if ($simuladoModel->questaoJaAdicionada($simulado_id, $questao_id)) {
            redirecionar('admin/simulado_questoes.php?id=' . $simulado_id . '&erro=duplicada');
        }

        $ordem = $simuladoModel->proximaOrdem($simulado_id);

        $simuladoModel->adicionarQuestao($simulado_id, $questao_id, $ordem);

        redirecionar('admin/simulado_questoes.php?id=' . $simulado_id . '&sucesso=adicionada');

    } catch (PDOException $e) {

        error_log('Erro ao adicionar questão ao simulado: ' . $e->getMessage());

        redirecionar('admin/simulado_questoes.php?id=' . $simulado_id . '&erro=adicionar');
    }
}


/* =========================================
   REMOVER QUESTÃO DO SIMULADO
========================================= */

if ($acao === 'remover_questao') {

    $simulado_id = (int) ($_GET['simulado_id'] ?? 0);
    $questao_id = (int) ($_GET['questao_id'] ?? 0);

    if ($simulado_id <= 0 || $questao_id <= 0) {
        redirecionar('admin/simulados.php?erro=remover');
    }

    try {

        $simuladoModel = new Simulado();

        $simuladoModel->removerQuestao($simulado_id, $questao_id);

        redirecionar('admin/simulado_questoes.php?id=' . $simulado_id . '&sucesso=removida');

    } catch (PDOException $e) {

        error_log('Erro ao remover questão do simulado: ' . $e->getMessage());

        redirecionar('admin/simulado_questoes.php?id=' . $simulado_id . '&erro=remover');
    }
}


/* =========================================
   AÇÃO INVÁLIDA
========================================= */

redirecionar('admin/simulados.php');