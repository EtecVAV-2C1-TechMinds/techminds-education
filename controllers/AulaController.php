<?php

/* =========================================
   TECHMINDS EDUCATION
   CLASS CONTROLLER
========================================= */

require_once __DIR__ . '/../models/Aula.php';

$aulaModel = new Aula();

$acao = $_GET['acao'] ?? '';


/* =========================================
   CREATE
========================================= */

if ($acao === 'criar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header('Location: ../pages/cadastroaula.php');
        exit;

    }


    $conteudo_id = (int) ($_POST['conteudo_id'] ?? 0);

    $titulo = trim($_POST['titulo'] ?? '');

    $descricao = trim($_POST['descricao'] ?? '');

    $video = trim($_POST['video'] ?? '');

    $material = trim($_POST['material'] ?? '');

    $ordem = (int) ($_POST['ordem'] ?? 1);


    /* =========================================
       VALIDATION
    ========================================== */

    if (
        $conteudo_id <= 0 ||
        empty($titulo) ||
        empty($descricao)
    ) {

        header(
            'Location: ../pages/cadastroaula.php?erro=preencha'
        );

        exit;

    }


    if ($ordem <= 0) {

        $ordem = 1;

    }


    /* =========================================
       CREATE
    ========================================== */

    try {

        $resultado = $aulaModel->criar(
            $conteudo_id,
            $titulo,
            $descricao,
            $video !== '' ? $video : null,
            $material !== '' ? $material : null,
            $ordem
        );


        if ($resultado) {

            header(
                'Location: ../pages/cadastroaula.php?sucesso=criado'
            );

            exit;

        }


        header(
            'Location: ../pages/cadastroaula.php?erro=criar'
        );

        exit;


    } catch (PDOException $e) {

        header(
            'Location: ../pages/cadastroaula.php?erro=criar'
        );

        exit;

    }

}


/* =========================================
   UPDATE
========================================= */

if ($acao === 'editar') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header('Location: ../pages/cadastroaula.php');
        exit;

    }


    $id = (int) ($_POST['id'] ?? 0);

    $conteudo_id = (int) ($_POST['conteudo_id'] ?? 0);

    $titulo = trim($_POST['titulo'] ?? '');

    $descricao = trim($_POST['descricao'] ?? '');

    $video = trim($_POST['video'] ?? '');

    $material = trim($_POST['material'] ?? '');

    $ordem = (int) ($_POST['ordem'] ?? 1);


    /* =========================================
       VALIDATION
    ========================================== */

    if (
        $id <= 0 ||
        $conteudo_id <= 0 ||
        empty($titulo) ||
        empty($descricao)
    ) {

        header(
            'Location: ../pages/cadastroaula.php?erro=preencha'
        );

        exit;

    }


    if ($ordem <= 0) {

        $ordem = 1;

    }


    /* =========================================
       UPDATE
    ========================================== */

    try {

        $resultado = $aulaModel->atualizar(
            $id,
            $conteudo_id,
            $titulo,
            $descricao,
            $video !== '' ? $video : null,
            $material !== '' ? $material : null,
            $ordem
        );


        if ($resultado) {

            header(
                'Location: ../pages/cadastroaula.php?sucesso=editado'
            );

            exit;

        }


        header(
            'Location: ../pages/cadastroaula.php?erro=editar'
        );

        exit;


    } catch (PDOException $e) {

        header(
            'Location: ../pages/cadastroaula.php?erro=editar'
        );

        exit;

    }

}


/* =========================================
   DELETE
========================================= */

if ($acao === 'excluir') {

    $id = (int) ($_GET['id'] ?? 0);


    if ($id <= 0) {

        header(
            'Location: ../pages/cadastroaula.php?erro=excluir'
        );

        exit;

    }


    try {

        $resultado = $aulaModel->excluir($id);


        if ($resultado) {

            header(
                'Location: ../pages/cadastroaula.php?sucesso=excluido'
            );

            exit;

        }


        header(
            'Location: ../pages/cadastroaula.php?erro=excluir'
        );

        exit;


    } catch (PDOException $e) {

        header(
            'Location: ../pages/cadastroaula.php?erro=excluir'
        );

        exit;

    }

}


/* =========================================
   INVALID ACTION
========================================= */

header('Location: ../pages/cadastroaula.php');

exit;

?>
