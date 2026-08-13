<?php

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Questao.php';


/* =========================================
   VERIFICAR AÇÃO
========================================= */

$acao = $_GET['acao'] ?? '';


/* =========================================
   CRIAR
========================================= */

if ($acao === 'criar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header('Location: ../pages/exercicios.php');
        exit;

    }


    /* =====================================
       RECEBER DADOS
    ====================================== */

    $materia_id = $_POST['materia_id'] ?? '';

    $conteudo_id = $_POST['conteudo_id'] ?? '';

    $enunciado = trim($_POST['enunciado'] ?? '');

    $alternativa_a = trim($_POST['alternativa_a'] ?? '');

    $alternativa_b = trim($_POST['alternativa_b'] ?? '');

    $alternativa_c = trim($_POST['alternativa_c'] ?? '');

    $alternativa_d = trim($_POST['alternativa_d'] ?? '');

    $alternativa_e = trim($_POST['alternativa_e'] ?? '');

    $resposta_correta = $_POST['resposta_correta'] ?? '';


    /* =====================================
       VERIFICAR CAMPOS
    ====================================== */

    if (
        empty($materia_id) ||
        empty($conteudo_id) ||
        empty($enunciado) ||
        empty($alternativa_a) ||
        empty($alternativa_b) ||
        empty($alternativa_c) ||
        empty($alternativa_d) ||
        empty($alternativa_e) ||
        empty($resposta_correta)
    ) {

        header(
            'Location: ../pages/exercicios.php?erro=preencha'
        );

        exit;
    }


    /* =====================================
       VERIFICAR RESPOSTA CORRETA
    ====================================== */

    if (!in_array($resposta_correta, ['A', 'B', 'C', 'D', 'E'])) {

        header(
            'Location: ../pages/exercicios.php?erro=cadastro'
        );

        exit;
    }


    try {

        $questao = new Questao($pdo);


        $idGerado = $questao->criar(
            $materia_id,
            $conteudo_id,
            $enunciado,
            $alternativa_a,
            $alternativa_b,
            $alternativa_c,
            $alternativa_d,
            $alternativa_e,
            $resposta_correta
        );


        header(
            'Location: ../pages/exercicios.php?sucesso=1&id=' . $idGerado
        );

        exit;


    } catch (PDOException $e) {

        error_log($e->getMessage());

        header(
            'Location: ../pages/exercicios.php?erro=cadastro'
        );

        exit;
    }
}



/* =========================================
   EDITAR
========================================= */

if ($acao === 'editar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header('Location: ../pages/exercicios.php');
        exit;

    }


    /* =====================================
       RECEBER DADOS
    ====================================== */

    $id = $_POST['id'] ?? '';

    $materia_id = $_POST['materia_id'] ?? '';

    $conteudo_id = $_POST['conteudo_id'] ?? '';

    $enunciado = trim($_POST['enunciado'] ?? '');

    $alternativa_a = trim($_POST['alternativa_a'] ?? '');

    $alternativa_b = trim($_POST['alternativa_b'] ?? '');

    $alternativa_c = trim($_POST['alternativa_c'] ?? '');

    $alternativa_d = trim($_POST['alternativa_d'] ?? '');

    $alternativa_e = trim($_POST['alternativa_e'] ?? '');

    $resposta_correta = $_POST['resposta_correta'] ?? '';


    /* =====================================
       VERIFICAR CAMPOS
    ====================================== */

    if (
        empty($id) ||
        empty($materia_id) ||
        empty($conteudo_id) ||
        empty($enunciado) ||
        empty($alternativa_a) ||
        empty($alternativa_b) ||
        empty($alternativa_c) ||
        empty($alternativa_d) ||
        empty($alternativa_e) ||
        empty($resposta_correta)
    ) {

        header(
            'Location: ../pages/exercicios.php?erro=preencha'
        );

        exit;
    }


    /* =====================================
       VERIFICAR RESPOSTA CORRETA
    ====================================== */

    if (!in_array($resposta_correta, ['A', 'B', 'C', 'D', 'E'])) {

        header(
            'Location: ../pages/exercicios.php?erro=editar'
        );

        exit;
    }


    try {

        $questao = new Questao($pdo);


        $questao->editar(
            $id,
            $materia_id,
            $conteudo_id,
            $enunciado,
            $alternativa_a,
            $alternativa_b,
            $alternativa_c,
            $alternativa_d,
            $alternativa_e,
            $resposta_correta
        );


        header(
            'Location: ../pages/exercicios.php?editado=1'
        );

        exit;


    } catch (PDOException $e) {

        error_log($e->getMessage());

        header(
            'Location: ../pages/exercicios.php?erro=editar'
        );

        exit;
    }
}



/* =========================================
   EXCLUIR
========================================= */

if ($acao === 'excluir') {

    $id = $_GET['id'] ?? '';


    if (!ctype_digit((string)$id)) {

        header(
            'Location: ../pages/exercicios.php?erro=excluir'
        );

        exit;
    }


    try {

        $questao = new Questao($pdo);

        $questao->excluir((int)$id);


        header(
            'Location: ../pages/exercicios.php?excluido=1'
        );

        exit;


    } catch (PDOException $e) {

        error_log($e->getMessage());

        header(
            'Location: ../pages/exercicios.php?erro=excluir'
        );

        exit;
    }
}


/* =========================================
   AÇÃO INVÁLIDA
========================================= */

header(
    'Location: ../pages/exercicios.php'
);

exit;
